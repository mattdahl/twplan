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

$filepath = 'http://en' . $world. '.tribalwars.net/map/village.txt.gz';
$local_filepath = '/code/twplan/beta/app/tmp/data/villages/en' . $world . '_village_data.txt';

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

// Loads the database data from app/Config/database.php
include('../../Config/database.php');
$db_config = get_class_vars('DATABASE_CONFIG');
$village_db_config = $db_config['villages'];

$mysqli = new mysqli($village_db_config['host'], $village_db_config['login'], $village_db_config['password'], $village_db_config['database']);

// Checks for connection error
if ($mysqli->connect_errno) {
    printf("Connect failed: %s\n", $mysqli->connect_error);
    exit();
}
else {
	printf("Connected to database... \n");
}

$truncate_query = "DROP TABLE IF EXISTS en{$world}";

if (!$mysqli->query($truncate_query)) {
    printf("Error truncating old table with query \n %s \n", $create_query);
    printf("Error message: %s \n", $mysqli->error);
    exit();
}
else {
	printf("Truncated old table...\n");
}

$create_query = "CREATE TABLE IF NOT EXISTS en{$world}
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

$local_filepath_handle = fopen($local_filepath, "r");
    while (($data = fgetcsv($local_filepath_handle, 1000, ">"))) {
    	$load_query = "INSERT INTO en{$world} values('" . implode('\',\'', $data) . "')";
        $mysqli->query($load_query) or printf("Error loading player data with query \n %s \n Error message: %s \n", $load_query, $mysqli->error);

    }
fclose($local_filepath_handle);

printf("Parsed csv into mysql...\n");

$mysqli->select_db('twp_users');

date_default_timezone_set("Europe/London");
$now = date("Y-m-d H:i:s");
$last_updated_query = "UPDATE worlds SET last_updated='{$now}' WHERE world_number = '{$world}'";

if (!$mysqli->query($last_updated_query)) {
	printf("Error updating last_updated data with query \n %s \n", $last_updated_query);
	printf("Error message: %s \n", $mysqli->error);
	exit();
}
else {
	printf("Updated last_updated data...\n");
}

$mysqli->close();

$end_time = microtime(true);

printf("Database twp_villages successfully loaded village data for table en{$world}! \nElapsed time: %f \n", $end_time - $start_time);

exit();

?>