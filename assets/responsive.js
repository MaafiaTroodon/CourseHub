// Toggle filter options on smaller screens
document.addEventListener("DOMContentLoaded", function () {
    const filterToggle = document.getElementById("filter-toggle");
    const filterOptions = document.getElementById("filter-options");

    if (filterToggle && filterOptions) {
        filterToggle.addEventListener("click", function () {
            filterOptions.classList.toggle("d-none");
        });
    }

    // Run fade-in effect and smooth scroll on page load
    applyScrollAnimations();
});

// Adjust timetable details for smaller screens
function adjustTimetableDetails() {
    const courseDetails = document.querySelectorAll(".course-detail");

    courseDetails.forEach(detail => {
        if (window.innerWidth < 576) {
            detail.classList.add("compact-view");
        } else {
            detail.classList.remove("compact-view");
        }
    });
}

// Run on window resize
window.addEventListener("resize", adjustTimetableDetails);
adjustTimetableDetails();

// Run fade-in effect on scroll for elements with .fade-scroll class
function applyScrollAnimations() {
    const fadeElements = document.querySelectorAll('.fade-scroll');

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('show');
            } else {
                entry.target.classList.remove('show'); // Remove if you want fade-out on exit
            }
        });
    }, { threshold: 0.1 });

    fadeElements.forEach(element => observer.observe(element));
}

// Apply animations on page load
document.addEventListener("DOMContentLoaded", function() {
    applyScrollAnimations();
});


// Notification display with type (success or error)
function showNotification(message, type = 'success') {
    const notification = document.getElementById('notification');
    notification.innerText = message;
    notification.className = 'notification show ' + (type === 'error' ? 'error' : '');

    // Show the notification
    setTimeout(() => {
        notification.classList.remove('show');
    }, 3000); // Hide after 3 seconds
}

// Apply animations on page scroll
window.addEventListener('scroll', applyScrollAnimations);

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

    fetch('../includes/filter_courses.php', {
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
            <td>${course.name}</td>
            <td>${course.instructor}</td>
            <td>${course.schedule}</td>
            <td><button class="btn btn-primary">Add to Schedule</button></td>
        `;
        courseTable.appendChild(row);
    });
}



