<?php
/*
    CSCI 2170: Introduction to Server-Side Scripting
    (Fall Semester 2024)
    Assignment 3 (add_course.php)
*/

require_once 'db.php';
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'error' => 'You must be logged in to add a course to your schedule.']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $course_code = $_POST['course_code'] ?? '';

    if (empty($course_code)) {
        echo json_encode(['success' => false, 'error' => 'Course code is required.']);
        exit();
    }

    $user_id = $_SESSION['user_id'];

    // Use $mysqli_course to check if the course exists
    $stmt = $mysqli->prepare("SELECT id FROM courses WHERE course_code = ?");
    if (!$stmt) {
        echo json_encode(['success' => false, 'error' => 'Database error: ' . $mysqli_course->error]);
        exit();
    }
    $stmt->bind_param("s", $course_code);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 0) {
        echo json_encode(['success' => false, 'error' => 'Course does not exist.']);
        $stmt->close();
        exit();
    }
    $stmt->bind_result($course_id);
    $stmt->fetch();
    $stmt->close();

    // Check if the course is already in the user's schedule
    $stmt = $mysqli->prepare("SELECT id FROM schedule WHERE user_id = ? AND course_id = ?");
    if (!$stmt) {
        echo json_encode(['success' => false, 'error' => 'Database error: ' . $mysqli_course->error]);
        exit();
    }
    $stmt->bind_param("ii", $user_id, $course_id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo json_encode(['success' => false, 'error' => 'Course is already in your schedule.']);
        $stmt->close();
        exit();
    }
    $stmt->close();

    // Add course to user's schedule
    $stmt = $mysqli->prepare("INSERT INTO schedule (user_id, course_id) VALUES (?, ?)");
    if (!$stmt) {
        echo json_encode(['success' => false, 'error' => 'Database error: ' . $mysqli_course->error]);
        exit();
    }
    $stmt->bind_param("ii", $user_id, $course_id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Course successfully added to your schedule.']);
    } else {
        echo json_encode(['success' => false, 'error' => 'Failed to add course to schedule.']);
    }
    $stmt->close();
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request.']);
}
