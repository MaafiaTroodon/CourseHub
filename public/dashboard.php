<?php
/*
    CSCI 2170: Introduction to Server-Side Scripting
    (Fall Semester 2024)
    Assignment 3 (dashboard.php)
*/

session_start();
require_once '../includes/db.php'; // Ensure db.php is included to connect to the databases

// Redirect to login if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Include header
include('../includes/header.php');

// Retrieve last login time from cookie
$last_login_time = isset($_COOKIE['last_login_time']) ? $_COOKIE['last_login_time'] : 'First time login';
$user_id = $_SESSION['user_id'];

// Fetch the user's schedule from the `schedule` table
$schedule = [];
$stmt = $mysqli_course->prepare("
    SELECT c.course_code, c.course_name, c.instructor, c.schedule 
    FROM schedule s 
    JOIN courses c ON s.course_id = c.id 
    WHERE s.user_id = ?
");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $schedule[] = $row;
}

$stmt->close();
?>

<main class="container">
    <h2 class="text-center text-primary">Welcome to Your Dashboard</h2>
    <div class="text-center mt-3">
        <p>Welcome, <strong><?php echo htmlspecialchars($_SESSION['user_id']); ?></strong>!</p>
        <p>Last Login Time: <strong><?php echo htmlspecialchars($last_login_time); ?></strong></p>
        <p>You can manage your course schedule here.</p>
    </div>

    <h3 class="mt-5">My Schedule</h3>
    <?php if (count($schedule) > 0): ?>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Course Code</th>
                        <th>Course Name</th>
                        <th>Instructor</th>
                        <th>Schedule</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($schedule as $course): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($course['course_code']); ?></td>
                            <td><?php echo htmlspecialchars($course['course_name']); ?></td>
                            <td><?php echo htmlspecialchars($course['instructor']); ?></td>
                            <td><?php echo htmlspecialchars($course['schedule']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <p>You have not added any courses to your schedule yet.</p>
    <?php endif; ?>

    <div class="mt-4">
        <a href="logout.php" class="btn btn-danger">Logout</a>
    </div>
</main>

<?php
// Include footer
include('../includes/footer.php');
?>
