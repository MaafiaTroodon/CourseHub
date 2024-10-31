<?php
// db.php
require_once 'db_config.php';

// Connect to the single database (dalhousie_timetable)
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PSWD, DB_NAME);
if ($mysqli->connect_error) {
    die("Connection failed for database: " . $mysqli->connect_error);
}
?>
