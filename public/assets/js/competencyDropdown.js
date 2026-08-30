document.addEventListener("DOMContentLoaded", function () {
    const prefix = document.getElementById("prefix");
    const course = document.getElementById("course_id");
    const module = document.getElementById("module_id");
    const preview = document.getElementById("competency_unit_preview");

    // ---------------------------------------------------------
    // Existing Competency Unit ID
    // ---------------------------------------------------------
    // Edit page হলে HTML থেকে ID নেওয়া হবে
    const competencyUnitId =
        document.getElementById("competency_unit_id")?.value || null;

    // ---------------------------------------------------------
    // Check Elements
    // ---------------------------------------------------------

    if (!prefix || !course || !module || !preview) {
        console.error("Competency Unit form elements not found.");
        return;
    }

    // ---------------------------------------------------------
    // Load Modules
    // ---------------------------------------------------------

    function loadModules(courseId, selectedModuleId = null) {
        module.innerHTML = `
            <option value="">Select Module</option>
        `;

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

                // -------------------------------------------------
                // Generate code after module is selected
                // -------------------------------------------------

                if (module.value) {
                    generateCode();
                }
            })
            .catch((error) => {
                console.error("Error loading modules:", error);

                module.innerHTML = `
                    <option value="">
                        Failed to load modules
                    </option>
                `;

                module.disabled = true;

                preview.textContent = "-";
            });
    }

    // ---------------------------------------------------------
    // Generate Competency Unit Code
    // ---------------------------------------------------------

    function generateCode() {
        // Course / Module না থাকলে
        if (!course.value || !module.value) {
            preview.textContent = "-";

            return;
        }

        // -----------------------------------------------------
        // Course Code
        // -----------------------------------------------------

        const courseText = course.options[course.selectedIndex].textContent;

        const courseCode = courseText.split(" - ")[0].trim();

        // -----------------------------------------------------
        // Module Number
        // -----------------------------------------------------

        const moduleText = module.options[module.selectedIndex].textContent;

        const moduleMatch = moduleText.match(/\d+/);

        if (!moduleMatch) {
            console.error("Module number not found:", moduleText);

            preview.textContent = "-";

            return;
        }

        const moduleNumber = moduleMatch[0];

        // -----------------------------------------------------
        // API URL
        // -----------------------------------------------------

        let url = `/competency-units/next-serial/${module.value}`;

        // -----------------------------------------------------
        // Edit Page
        // -----------------------------------------------------

        if (competencyUnitId) {
            url = `/competency-units/edit-next-serial/${module.value}/${competencyUnitId}`;
        }

        console.log("Generating competency unit code...");
        console.log("Course Code:", courseCode);
        console.log("Module Number:", moduleNumber);
        console.log("API URL:", url);

        // -----------------------------------------------------
        // Get Next Serial
        // -----------------------------------------------------

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

                // -------------------------------------------------
                // Final Code
                // -------------------------------------------------

                const finalCode = `${prefix.value.toUpperCase()}${courseCode}${moduleNumber}${serial}`;

                preview.textContent = finalCode;

                console.log("Generated Code:", finalCode);
            })
            .catch((error) => {
                console.error("Error generating competency unit code:", error);

                preview.textContent = "-";
            });
    }

    // ---------------------------------------------------------
    // Course Change
    // ---------------------------------------------------------

    course.addEventListener("change", function () {
        // Reset preview
        preview.textContent = "-";

        // Course change করলে নতুন module load হবে
        loadModules(this.value);
    });

    // ---------------------------------------------------------
    // Module Change
    // ---------------------------------------------------------

    module.addEventListener("change", function () {
        generateCode();
    });

    // ---------------------------------------------------------
    // Prefix Change
    // ---------------------------------------------------------

    prefix.addEventListener("input", function () {
        generateCode();
    });

    // ---------------------------------------------------------
    // Edit Page Initial Load
    // ---------------------------------------------------------

    if (course.value) {
        const selectedModuleId = module.dataset.selectedModule || null;

        loadModules(course.value, selectedModuleId);
    }
});
