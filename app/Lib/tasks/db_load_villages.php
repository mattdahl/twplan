<?php
/**
 * Intended for command line usage for local development. Loads village data into the local database. Example syntax for world 70:
 *
 * $ php db_load_villages.php 70
 */

// Tracks execution time
$start_time = microtime(true);

// Grabs the second argument from the command line (the first argument is the script name)
$world = $argv[1];

if (!$world) {
	printf("No world supplied.\nUsage: $ php db_load_villages.php [world]\n");
	exit();
}

// #CASUALWORLDHACK
if ($world == 1 || $world == 2) { // casual
	$server_prefix = 'enp';
}
else {
	$server_prefix = 'en';
}

$filepath = 'http://' . $server_prefix . $world. '.tribalwars.net/map/village.txt.gz';

require_once(dirname(__FILE__) . '/../../../twplan_config.php');
$local_filepath = TWPLAN_CONFIG::$app_path . '/beta/app/tmp/data/villages/' . $server_prefix . $world . '_village_data.txt';

// Unzips the remote data file into an array
$village_file = gzfile($filepath);

// Preprocesses the csv to decode the village names and remove extraneous columns
if (!$village_file) {
	printf("Error loading remote file %s\n", $filepath);
	exit();
}
else {
	printf("Loaded remote village data... \n");
	$write_to = '';
	for ($i = 0; $i < count($village_file); $i++) {
		$line = explode(',', $village_file[$i]);
		$write_to .= $line[0] . '>' . urldecode($line[1]) . '>' . $line[2] . '>' . $line[3] . '>' . $line[4] . "\n"; // Delimit using '>' because TW doesn't allow this character
	}
	printf("Processed data... \n");
}

// Pulls the processed csv file into the tmp folder
if (!file_put_contents($local_filepath, $write_to)) {
	printf("Error writing remote file %s to path %s\n", $filepath, $local_filepath);
	exit();
}
else {
	printf("Wrote data to tmp folder... \n");
}

// Loads the database data
require_once(TWPLAN_CONFIG::$app_path . 'beta/app/Config/database.php');
$db_config = (new DATABASE_CONFIG())->default;

$mysqli = new mysqli($db_config['host'], $db_config['login'], $db_config['password'], $db_config['database']);

// Checks for connection error
if ($mysqli->connect_errno) {
	printf("Connect failed: %s\n", $mysqli->connect_error);
	exit();
}
else {
	printf("Connected to database... \n");
}

$table_name = "villages_{$server_prefix}{$world}";

$truncate_query = "DROP TABLE IF EXISTS {$table_name}";

if (!$mysqli->query($truncate_query)) {
	printf("Error truncating old table with query \n %s \n", $create_query);
	printf("Error message: %s \n", $mysqli->error);
	exit();
}
else {
	printf("Truncated old table...\n");
}

$create_query = "CREATE TABLE IF NOT EXISTS {$table_name}
(
	village_id INT NOT NULL,
	village_name VARCHAR(100) NOT NULL,
	x_coord INT NOT NULL,
	y_coord INT NOT NULL,
	player_id INT NOT NULL,
	PRIMARY KEY
	(village_id)
)";

if (!$mysqli->query($create_query)) {
	printf("Error creating table with query \n %s \n", $create_query);
	printf("Error message: %s \n", $mysqli->error);
	exit();
}
else {
	printf("Created table (IF NOT EXISTS)...\n");
}

$load_query = "LOAD DATA INFILE '{$local_filepath}' INTO TABLE {$table_name}
FIELDS TERMINATED BY '>'
LINES TERMINATED BY '\n'
(
	village_id,
	village_name,
	x_coord,
	y_coord,
	player_id
	)";

if (!$mysqli->query($load_query)) {
	printf("Error loading village data with query \n %s \n", $load_query);
	printf("Error message: %s \n", $mysqli->error);
	exit();
}
else {
	printf("Parsed csv into mysql...\n");
}


// Logs record of last_updated
date_default_timezone_set("Europe/London");
$now = date("Y-m-d H:i:s");
$last_updated_query = "UPDATE worlds SET villages_last_updated='{$now}' WHERE world_number = '{$world}'";

if (!$mysqli->query($last_updated_query)) {
	printf("Error updating villages_last_updated data with query \n %s \n", $last_updated_query);
	printf("Error message: %s \n", $mysqli->error);
	exit();
}
else {
	printf("Updated last_updated data...\n");
}

$mysqli->close();

$end_time = microtime(true);

printf("Database twp_villages successfully loaded village data for table {$table_name}! \nElapsed time: %f \n", $end_time - $start_time);

exit();

?>