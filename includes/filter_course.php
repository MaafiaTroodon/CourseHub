<?php
header('Content-Type: application/json');
require_once 'db.php'; // Include your database connection

// Get filters from POST data
$data = json_decode(file_get_contents("php://input"), true);
$searchTerm = isset($data['searchTerm']) ? $data['searchTerm'] : '';
$days = isset($data['days']) ? $data['days'] : [];

// Start building SQL query with DISTINCT
$sql = "SELECT DISTINCT course_code, course_name, instructor, schedule FROM courses WHERE 1=1";

// Add search term filtering if present
if (!empty($searchTerm)) {
    $sql .= " AND course_code LIKE ?";
    $searchTerm = "%{$searchTerm}%";
}

// Add day filtering if specific days are selected
if (!empty($days)) {
    $dayConditions = [];
    foreach ($days as $day) {
        $dayConditions[] = "schedule LIKE ?";
    }
    $sql .= " AND (" . implode(" OR ", $dayConditions) . ")";
}

// Prepare the statement
$stmt = $mysqli->prepare($sql);

// Error handling for SQL preparation
if (!$stmt) {
    echo json_encode(["error" => "SQL Error: " . $mysqli->error]);
    exit;
}

// Dynamically bind parameters
$types = "";
$params = [];

if (!empty($searchTerm)) {
    $types .= "s";
    $params[] = $searchTerm;
}

foreach ($days as $day) {
    $types .= "s";
    $params[] = "%$day%";
}

// Bind parameters if there are any
if (!empty($types)) {
    $stmt->bind_param($types, ...$params);
}

// Execute and fetch results
if (!$stmt->execute()) {
    echo json_encode(["error" => "Execution Error: " . $stmt->error]);
    exit;
}

// Check for `get_result()` support
$result = $stmt->get_result();
if (!$result) {
    echo json_encode(["error" => "Result Error: " . $stmt->error]);
    exit;
}

// Fetch courses
$courses = $result->fetch_all(MYSQLI_ASSOC);

// Return the filtered courses as JSON
echo json_encode($courses);
?>
