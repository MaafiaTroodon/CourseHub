// Toggle filter options on smaller screens
document.addEventListener("DOMContentLoaded", function () {
    const filterToggle = document.getElementById("filter-toggle");
    const filterOptions = document.getElementById("filter-options");
  
    if (filterToggle && filterOptions) {
      filterToggle.addEventListener("click", function () {
        filterOptions.classList.toggle("d-none");
      });
    }
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
  

  function showNotification(message, type = 'success') {
    const notification = document.getElementById('notification');
    notification.innerText = message;
    notification.className = 'notification show ' + (type === 'error' ? 'error' : ''); // Add 'error' class if type is error

    // Show the notification
    setTimeout(() => {
        notification.classList.remove('show');
    }, 3000); // Hide after 3 seconds
}
