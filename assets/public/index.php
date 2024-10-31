<?php
/*
    CSCI 2170: Introduction to Server-Side Scripting
    (Fall Semester 2024)
    Assignment 3 (index.php)
*/

session_start();
$loggedIn = isset($_SESSION['user_id']);
include('../includes/header.php');
?>
<div id="notification" class="notification"></div>
<main class="container">
    <h1 class="mb-4">Available Courses</h1>
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="bg-light">
                <tr>
                    <th>Course Code</th>
                    <th>Course Name</th>
                    <th>Instructor</th>
                    <th>Schedule</th>
                    <th>Add to Schedule</th>
                </tr>
            </thead>
            <tbody id="course-table">
                <?php
                $json_data = file_get_contents('../files/timetable.json');
                if ($json_data === false) {
                    echo "<tr><td colspan='5'>Error: Unable to load timetable data.</td></tr>";
                } else {
                    $courses = json_decode($json_data, true);
                    if (is_array($courses)) {
                        foreach ($courses as $course) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($course['course_code'] ?? 'N/A') . "</td>";
                            echo "<td>" . htmlspecialchars($course['name'] ?? 'N/A') . "</td>";
                            echo "<td>" . htmlspecialchars($course['instructor'] ?? 'N/A') . "</td>";
                            echo "<td>" . htmlspecialchars($course['schedule'] ?? 'N/A') . "</td>";
                            echo "<td>";
                            if ($loggedIn) {
                                echo '<button class="btn btn-primary" onclick="addToSchedule(\'' . htmlspecialchars($course['course_code']) . '\')">Add to Schedule</button>';
                            } else {
                                echo '<span>Login to add courses</span>';
                            }
                            echo "</td></tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>Error: Timetable data is not in valid JSON format.</td></tr>";
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</main>

<script>
function showNotification(message, type = 'success') {
    const notification = document.getElementById('notification');
    notification.innerText = message;
    notification.className = 'notification show ' + (type === 'error' ? 'error' : 'success');

    // Show the notification for 3 seconds
    setTimeout(() => {
        notification.classList.remove('show');
    }, 3000); // Hide after 3 seconds
}

function addToSchedule(courseCode) {
    fetch('../includes/add_course.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: 'course_code=' + encodeURIComponent(courseCode)
    })
    .then(response => response.text())
    .then(text => {
        try {
            const data = JSON.parse(text);
            if (data.success) {
                showNotification(data.message, 'success'); // Show success notification
            } else {
                showNotification(data.error, 'error'); // Show error notification
            }
        } catch (error) {
            console.error('JSON parsing error:', error);
            showNotification('Unexpected response format. Check the console for details.', 'error');
        }
    })
    .catch(error => {
        console.error('Fetch error:', error);
        showNotification('An error occurred. Please check the console for details.', 'error');
    });
}
</script>


<?php
include('../includes/footer.php');
?>
