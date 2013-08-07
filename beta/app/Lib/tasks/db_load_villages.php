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
	printf("No world supplied. \n Usage: $ php db_load_villages.php [world]");
	exit();
}

$filepath = 'http://en' . $world. '.tribalwars.net/map/village.txt';
$local_filepath = '/code/twplan/beta/app/tmp/data/villages/en' . $world . '_village_data.txt';

// Pulls the remote csv file into the tmp folder
if (!file_put_contents($local_filepath, file_get_contents($filepath))) {
	printf("Error writing remote file %s to path %s", $filepath, $local_filepath);
	exit();
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

set_time_limit(600); // in seconds; 10min should be ample

$create_query = "CREATE TABLE IF NOT EXISTS en{$world}
			(
				village_id INT NOT NULL,
				name VARCHAR(100) NOT NULL,
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

$load_query = "LOAD DATA INFILE '{$local_filepath}' INTO TABLE en{$world}
			FIELDS TERMINATED BY ','
			LINES TERMINATED BY '\n'
			(
				village_id,
				name,
				x_coord,
				y_coord,
				player_id,
				@dummy,
				@dummy
			)";

if (!$mysqli->query($load_query)) {
    printf("Error loading village data with query \n %s \n", $load_query);
    printf("Error message: %s \n", $mysqli->error);
    exit();
}

$mysqli->close();

$end_time = microtime(true);

printf("Database twp_villages loaded village data for table en{$world}... \n Elapsed time: %f \n", $end_time - $start_time);

exit();

?>