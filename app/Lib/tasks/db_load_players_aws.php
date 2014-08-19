<?php
/**
 * Intended for cron job usage for live development. Loads player data into the RDS database.
 * Crontab example:
 * /usr/local/bin/php ~/app/Lib/tasks/db_load_players_aws.php >/dev/null 2>&1
 */

error_reporting(-1);
ini_set('display_errors', true);
date_default_timezone_set("Europe/London");
require_once(dirname(__FILE__) . '/../../../twplan_config.php');

function log_success ($message) {
	$datetime = date("D M d, Y G:i:s");
	file_put_contents(TWPLAN_CONFIG::$app_path . '/app/Lib/tasks/update_log.txt', $datetime . ':: ' .$message, FILE_APPEND | LOCK_EX);
}

function log_error ($message) {
	$datetime = date("D M d, Y G:i:s");
	file_put_contents(TWPLAN_CONFIG::$app_path . '/app/Lib/tasks/update_log.txt', $datetime . ':: ERROR: ' .$message, FILE_APPEND | LOCK_EX);
	throw new Exception($message);
}

// Tracks execution time
$start_time = microtime(true);


try {
	log_success("** BEGIN PLAYERS LOAD **\n");

	// Loads the database data from app/Config/database.php
	require_once(TWPLAN_CONFIG::$app_path . '/app/Config/database.php');
	$db_config = (new DATABASE_CONFIG())->default;

	$mysqli = new mysqli($db_config['host'], $db_config['login'], $db_config['password'], $db_config['database']);

	// Checks for connection error
	if ($mysqli->connect_errno) {
		log_error(sprintf("Connect failed: %s\n", $mysqli->connect_error));
	}
	else {
		log_success("Connected to database...\n");
	}

	$world_query = "SELECT `world_number` FROM `worlds` ORDER BY `players_last_updated` LIMIT 1";

	if (!$result = $mysqli->query($world_query)) {
		log_error(sprintf("Error obtaining world with query \n %s \n Error message: %s \n", $world_query, $mysqli->error));
	}
	else {
		$world = $result->fetch_array()['world_number'];
		log_success(sprintf("Using world %d\n", $world));
	}

	// #CASUALWORLDHACK
	if ($world == 1 || $world == 2) { // casual
		$server_prefix = 'enp';
	}
	else {
		$server_prefix = 'en';
	}

	$filepath = 'http://' . $server_prefix . $world. '.tribalwars.net/map/player.txt.gz';

	$local_filepath = TWPLAN_CONFIG::$app_path . '/app/tmp/data/players/' . $server_prefix . $world . '_player_data.txt';

	// Unzips the remote data file into an array
	$player_file = gzfile($filepath);

	// Preprocesses the csv to decode the village names and remove extraneous columns
	if (!$player_file) {
		log_error(sprintf("Error loading remote file %s\n", $filepath));
	}
	else {
		log_success("Loaded remote player data... \n");
		$write_to = '';
		for ($i = 0; $i < count($player_file); $i++) {
			$line = explode(',', $player_file[$i]);
			$write_to .= $line[0] . '>' . urldecode($line[1]) . '>' . $line[2] . "\n"; // Delimit using '>' because TW doesn't allow this character
		}
		log_success("Processed data... \n");
	}

	if (!file_put_contents($local_filepath, $write_to)) {
		log_error(sprintf("Error writing remote file %s to path %s\n", $filepath, $local_filepath));
	}
	else {
		log_success("Wrote data to tmp folder... \n");
	}

	$table_name = "players_{$server_prefix}{$world}";

	$truncate_query = "DROP TABLE IF EXISTS {$table_name}";

	if (!$mysqli->query($truncate_query)) {
		log_error(sprintf("Error truncating old table with query \n %s \nError message: %s \n", $create_query, $mysqli->error));
	}
	else {
		log_success("Truncated old table...\n");
	}

	$create_query = "CREATE TABLE IF NOT EXISTS {$table_name}
	(
		player_id INT NOT NULL,
		username VARCHAR(100) NOT NULL,
		tribe_id INT NOT NULL,
		PRIMARY KEY
		(player_id)
		)";

	if (!$mysqli->query($create_query)) {
		log_error(sprintf("Error creating table with query \n %s \nError message: %s \n", $create_query, $mysqli->error));
	}
	else {
		log_success("Created table (IF NOT EXISTS)...\n");
	}

	$local_filepath_handle = fopen($local_filepath, "r");
	while (($data = fgetcsv($local_filepath_handle, 1000, ">"))) {
		$load_query = "INSERT INTO {$table_name} values('" . implode('\',\'', $data) . "')";
		$mysqli->query($load_query) or log_error(sprintf("Error loading player data with query \n %s \n Error message: %s \n", $load_query, $mysqli->error));
	}
	fclose($local_filepath_handle);

	log_success("Parsed csv into mysql...\n");

	$decode_query = "UPDATE {$table_name} SET username = REPLACE(username, '+', ' ')";

	if (!$mysqli->query($decode_query)) {
		log_error(sprintf("Error decoding player data with query \n %s \nError message: %s \n", $decode_query, $mysqli->error));
	}
	else {
		log_success("Decoded usernames...\n");
	}

	$current_time = date("Y-m-d H:i:s");
	$update_time_query = "UPDATE `worlds` SET players_last_updated='$current_time' WHERE `world_number` = '$world'";

	if (!$mysqli->query($update_time_query)) {
		log_error(sprintf("Error writing last updated with with query \n %s \nError message: %s \n", $update_time_query, $mysqli->error));
	}
	else {
		log_success("Wrote last updated time...\n");
	}

	$mysqli->close();
} catch (Exception $e) {
	mail("site@twplan.com", "db_load_players_aws ERROR (W" . $world . ")", $e->getMessage());
	exit();
}

$end_time = microtime(true);

log_success("Elapsed time: " . ($end_time - $start_time) . "\n");

exit();

?>