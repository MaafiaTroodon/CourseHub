<?php
/*
    CSCI 2170: Introduction to Server-Side Scripting
    (Fall Semester 2024)
    Assignment 3 (header.php)
*/

// Start the session only if it’s not already active
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dalhousie Timetable</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../assets/styles.css">
</head>

<body class="bg-light-grey">
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="collapse navbar-collapse" id="navbarNav">
    <a class="navbar-brand" href="index.php">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRHV0yTI5pWCUHLmQNLX3KdArcOxWUPBArzfg&s"
                    alt="Dalhousie Logo" height="40">
            </a>
    <ul class="navbar-nav ms-auto">
        <?php
        // Check if the user is logged in by verifying if 'user_id' is set in the session
        if (isset($_SESSION['user_id'])): 
        ?>
            <li class="nav-item">
                <a class="nav-link text-dark" href="index.php">Course Schedule</a> <!-- Link to index.php when logged in -->
            </li>
            <li class="nav-item">
                <a class="nav-link text-dark" href="dashboard.php">Dashboard</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-dark" href="logout.php">Logout</a>
            </li>
        <?php else: ?>
            <li class="nav-item">
                <a class="nav-link text-dark btn btn-brand" href="login.php">Login</a>
            </li>
        <?php endif; ?>
    </ul>
</div>

        </div>
    </nav>
    <div class="container mt-5">
