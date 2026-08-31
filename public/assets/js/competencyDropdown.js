document.addEventListener("DOMContentLoaded", function () {
    const prefix = document.getElementById("prefix");
    const course = document.getElementById("course_id");
    const module = document.getElementById("module_id");
    const preview = document.getElementById("competency_unit_preview");

    // Existing Competency Unit ID
    const competencyUnitId =
        document.getElementById("competency_unit_id")?.value || null;

    // Check elements
    if (!prefix || !course || !module || !preview) {
        console.error("Competency Unit form elements not found.");
        return;
    }

    // Load modules
    function loadModules(courseId, selectedModuleId = null) {
        module.innerHTML = `<option value="">Select Module</option>`;
        module.disabled = true;

        if (!courseId) {
            preview.textContent = "-";
            return;
        }

        fetch(`/competency-units/modules/${courseId}`)
            .then((response) => {
                if (!response.ok) {
                    throw new Error(
                        `Failed to load modules. Status: ${response.status}`,
                    );
                }
                return response.json();
            })
            .then((data) => {
                data.forEach((item) => {
                    const option = document.createElement("option");
                    option.value = item.id;
                    option.textContent = `Module ${item.module_number} - ${item.name}`;

                    // Edit page existing module
                    if (
                        selectedModuleId !== null &&
                        String(selectedModuleId) === String(item.id)
                    ) {
                        option.selected = true;
                    }

                    module.appendChild(option);
                });

                module.disabled = false;

                if (module.value) {
                    generateCode();
                }
            })
            .catch((error) => {
                console.error("Error loading modules:", error);
                module.innerHTML = `<option value="">Failed to load modules</option>`;
                module.disabled = true;
                preview.textContent = "-";
            });
    }

    // Generate competency unit code
    function generateCode() {
        if (!course.value || !module.value) {
            preview.textContent = "-";
            return;
        }

        const courseText = course.options[course.selectedIndex].textContent;
        const courseCode = courseText.split(" - ")[0].trim();

        const moduleText = module.options[module.selectedIndex].textContent;
        const moduleMatch = moduleText.match(/\d+/);

        if (!moduleMatch) {
            console.error("Module number not found:", moduleText);
            preview.textContent = "-";
            return;
        }

        const moduleNumber = moduleMatch[0];
        let url = `/competency-units/next-serial/${module.value}`;

        // Edit page
        if (competencyUnitId) {
            url = `/competency-units/edit-next-serial/${module.value}/${competencyUnitId}`;
        }

        console.log("Generating competency unit code...");
        console.log("Course Code:", courseCode);
        console.log("Module Number:", moduleNumber);
        console.log("API URL:", url);

        fetch(url)
            .then((response) => {
                if (!response.ok) {
                    throw new Error(
                        `Failed to generate serial. Status: ${response.status}`,
                    );
                }
                return response.json();
            })
            .then((data) => {
                console.log("Serial Response:", data);
                const serial = String(data.serial).padStart(2, "0");
                const finalCode = `${prefix.value.toUpperCase()}${courseCode}${moduleNumber}${serial}`;
                preview.textContent = finalCode;
                console.log("Generated Code:", finalCode);
            })
            .catch((error) => {
                console.error("Error generating competency unit code:", error);
                preview.textContent = "-";
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

    // Edit page initial load
    if (course.value) {
        const selectedModuleId = module.dataset.selectedModule || null;
        loadModules(course.value, selectedModuleId);
    }
});
