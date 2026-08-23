import './bootstrap';

document.addEventListener("DOMContentLoaded", () => {

    const sidebar = document.getElementById("sidebar");
    const sidebarToggle = document.getElementById("sidebarToggle");
    const sidebarOverlay = document.getElementById("sidebarOverlay");

    if (!sidebar || !sidebarToggle || !sidebarOverlay) {
        return;
    }

    sidebarToggle.addEventListener("click", () => {

        sidebar.classList.toggle("-translate-x-full");
        sidebarOverlay.classList.toggle("hidden");

    });


    sidebarOverlay.addEventListener("click", () => {

        sidebar.classList.add("-translate-x-full");
        sidebarOverlay.classList.add("hidden");

    });

});