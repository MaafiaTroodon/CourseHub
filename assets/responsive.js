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
