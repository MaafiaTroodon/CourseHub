<?php
// db.php
require_once 'db_config.php';

// Connect to the user database (university_schedule)
$mysqli_user = new mysqli(DB_HOST, DB_USER, DB_PSWD, 'university_schedule');
if ($mysqli_user->connect_error) {
    die("Connection failed for user database: " . $mysqli_user->connect_error);
}

// Connect to the course database (dalhousie_timetable)
$mysqli_course = new mysqli(DB_HOST, DB_USER, DB_PSWD, 'dalhousie_timetable');
if ($mysqli_course->connect_error) {
    die("Connection failed for course database: " . $mysqli_course->connect_error);
}
