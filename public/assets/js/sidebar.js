document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll(".sidebar-dropdown").forEach((dropdown) => {
        const toggle = dropdown.querySelector(".sidebar-dropdown-toggle");
        const menu = dropdown.querySelector(".sidebar-dropdown-menu");
        const icon = toggle.querySelector(".bi-chevron-down");

        toggle.addEventListener("click", () => {
            const isOpen = menu.classList.contains("max-h-96");

            if (isOpen) {
                // Close
                menu.classList.remove("max-h-96", "opacity-100", "mt-2");
                menu.classList.add("max-h-0", "opacity-0", "mt-0");
                icon.classList.remove("rotate-180");
            } else {
                // Open
                menu.classList.remove("max-h-0", "opacity-0", "mt-0");
                menu.classList.add("max-h-96", "opacity-100", "mt-2");
                icon.classList.add("rotate-180");
            }
        });
    });
});
