<?php
/*
    CSCI 2170: Introduction to Server-Side Scripting
    (Fall Semester 2024)
    Assignment 3 (drop_course.php)
*/

require_once 'db.php';
session_start();

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'error' => 'You must be logged in to drop a course.']);
    exit();
}

$user_id = $_SESSION['user_id'];
$schedule_id = $_POST['schedule_id'] ?? '';

// Validate and check that the schedule ID is provided
if (empty($schedule_id)) {
    echo json_encode(['success' => false, 'error' => 'Schedule ID is required.']);
    exit();
}

// Prepare the statement to delete the course from the user's schedule
$stmt = $mysqli->prepare("DELETE FROM schedule WHERE id = ? AND user_id = ?");
if (!$stmt) {
    echo json_encode(['success' => false, 'error' => 'Database error: ' . $mysqli->error]);
    exit();
}

$stmt->bind_param("ii", $schedule_id, $user_id);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Course successfully dropped from your schedule.']);
} else {
    echo json_encode(['success' => false, 'error' => 'Failed to drop course from schedule.']);
}

$stmt->close();
?>
