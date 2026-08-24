document.addEventListener("DOMContentLoaded", function () {
    const csvTab = document.getElementById("csvTab");
    const manualTab = document.getElementById("manualTab");

    const csvSection = document.getElementById("csvSection");
    const manualSection = document.getElementById("manualSection");

    function activateTab(tab, section, otherTab, otherSection) {
        tab.classList.add("bg-white", "text-primary", "shadow-sm");
        tab.classList.remove("text-slate-500");

        otherTab.classList.remove("bg-white", "text-primary", "shadow-sm");
        otherTab.classList.add("text-slate-500");

        section.classList.remove("hidden");
        otherSection.classList.add("hidden");
    }

    csvTab.onclick = () =>
        activateTab(csvTab, csvSection, manualTab, manualSection);

    manualTab.onclick = () =>
        activateTab(manualTab, manualSection, csvTab, csvSection);
});
