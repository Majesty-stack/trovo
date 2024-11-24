
  // Function to open/close the sidebar
function toggleSidebar() {
    const sidebar = document.querySelector('.sidebar');
    sidebar.classList.toggle('open');

    // If the sidebar is open, add an event listener to close it when clicking outside
    if (sidebar.classList.contains('open')) {
        document.addEventListener('click', closeSidebarOnOutsideClick);
    } else {
        document.removeEventListener('click', closeSidebarOnOutsideClick);
    }
}

// Function to close sidebar when clicking outside
function closeSidebarOnOutsideClick(event) {
    const sidebar = document.querySelector('.sidebar');
    if (!sidebar.contains(event.target) && !event.target.classList.contains('navbar-toggler')) {
        sidebar.classList.remove('open');
        document.removeEventListener('click', closeSidebarOnOutsideClick);
    }
}
