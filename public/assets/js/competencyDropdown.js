document.addEventListener("DOMContentLoaded", function () {
    const prefix = document.getElementById("prefix");
    const course = document.getElementById("course_id");
    const module = document.getElementById("module_id");
    const preview = document.getElementById("competency_unit_preview");

    // Load modules
    function loadModules(courseId, selectedModuleId = null) {
        module.innerHTML = '<option value="">Select Module</option>';
        module.disabled = true;

        if (!courseId) {
            return;
        }

        fetch(`/competency-units/modules/${courseId}`)
            .then((response) => response.json())
            .then((data) => {
                data.forEach((item) => {
                    const option = document.createElement("option");

                    option.value = item.id;

                    option.textContent = `Module ${item.module_number} - ${item.name}`;

                    if (selectedModuleId == item.id) {
                        option.selected = true;
                    }

                    module.appendChild(option);
                });

                module.disabled = false;
            });
    }

    // Generate code
    function generateCode() {
        if (!course.value || !module.value) {
            preview.textContent = "-";
            return;
        }

        const courseCode = course.options[course.selectedIndex].text
            .split(" - ")[0]
            .trim();

        const moduleNumber =
            module.options[module.selectedIndex].textContent.match(/\d+/)[0];

        let url = `/competency-units/next-serial/${module.value}`;

        // Edit page হলে
        if (competencyUnitId) {
            url = `/competency-units/edit-next-serial/${module.value}/${competencyUnitId}`;
        }

        fetch(url)
            .then((response) => response.json())
            .then((data) => {
                const serial = String(data.serial).padStart(2, "0");

                preview.textContent = `${prefix.value.toUpperCase()}${courseCode}${moduleNumber}${serial}`;
            });
    }

    // Course change
    course.addEventListener("change", function () {
        preview.textContent = "-";

        loadModules(this.value);
    });

    // Module change
    module.addEventListener("change", function () {
        generateCode();
    });

    // Prefix change
    prefix.addEventListener("input", function () {
        generateCode();
    });

    // Edit page
    if (course.value) {
        const selectedModuleId = module.value;

        // শুধু modules load করবে
        // existing code change করবে না
        loadModules(course.value, selectedModuleId);
    }
});
