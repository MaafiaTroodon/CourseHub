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
    <div class="container mt-3">
    <button id="filter-toggle" class="btn btn-outline-secondary mb-3">Filter Courses</button>
    <div id="filter-options" class="d-none">
        <!-- Search bar for Course Code -->
        <div class="input-group mb-3">
            <input type="text" id="search-bar" class="form-control" placeholder="Search by Course Code">
            <button class="btn btn-primary" onclick="applyFilters()">Search</button>
        </div>

        <!-- Day filters -->
        <div class="mb-3">
            <label>Filter by Days:</label>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="Mon" id="filter-mon">
                <label class="form-check-label" for="filter-mon">Monday</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="Tue" id="filter-tue">
                <label class="form-check-label" for="filter-tue">Tuesday</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="Wed" id="filter-wed">
                <label class="form-check-label" for="filter-wed">Wednesday</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="Thu" id="filter-thu">
                <label class="form-check-label" for="filter-thu">Thursday</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="Fri" id="filter-fri">
                <label class="form-check-label" for="filter-fri">Friday</label>
            </div>
            <button class="btn btn-primary mt-2" onclick="applyFilters()">Apply Filters</button>
        </div>
    </div>
</div>

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

// javascript for filter course functionality 
document.addEventListener("DOMContentLoaded", function () {
    const filterToggle = document.getElementById("filter-toggle");
    const filterOptions = document.getElementById("filter-options");

    // Toggle filter options visibility
    filterToggle.addEventListener("click", function () {
        filterOptions.classList.toggle("d-none");
    });
});

// Function to apply filters and fetch filtered courses asynchronously
function applyFilters() {
    const searchTerm = document.getElementById("search-bar").value;
    const days = ["Mon", "Tue", "Wed", "Thu", "Fri"].filter(day => 
        document.getElementById(`filter-${day.toLowerCase()}`).checked
    );

    fetch('../includes/filter_course.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ searchTerm, days })
    })
    .then(response => response.json())
    .then(courses => {
        updateCourseTable(courses);
    })
    .catch(error => console.error('Error:', error));
}

// Function to update the course table with filtered results
function updateCourseTable(courses) {
    const courseTable = document.getElementById("course-table");
    courseTable.innerHTML = ""; // Clear existing courses

    courses.forEach(course => {
        const row = document.createElement("tr");
        row.innerHTML = `
            <td>${course.course_code}</td>
            <td>${course.course_name}</td> <!-- Updated field name -->
            <td>${course.instructor}</td>
            <td>${course.schedule}</td>
            <td><button class="btn btn-primary" onclick="addToSchedule('${course.course_code}')">Add to Schedule</button></td>
        `;
        courseTable.appendChild(row);
    });
}


</script>


<?php
include('../includes/footer.php');
?>
