document.addEventListener("DOMContentLoaded", function () {
    const courseSelect = document.getElementById("course_id");
    const moduleSelect = document.getElementById("module_id");
    const competencyUnitSelect = document.getElementById(
        "competency_unit_id"
    );

    // ---------------------------------------------------------
    // Check Elements
    // ---------------------------------------------------------

    if (!courseSelect || !moduleSelect || !competencyUnitSelect) {
        console.error("Element form select not found.");
        return;
    }

    // ---------------------------------------------------------
    // Initial State
    // ---------------------------------------------------------

    // প্রথমে শুধু Course enabled থাকবে
    moduleSelect.disabled = true;
    competencyUnitSelect.disabled = true;

    // ---------------------------------------------------------
    // Course → Module
    // ---------------------------------------------------------

    courseSelect.addEventListener("change", async function () {
        const courseId = this.value;

        // Reset Module
        moduleSelect.innerHTML = `
            <option value="">Select a module</option>
        `;

        // Reset Competency Unit
        competencyUnitSelect.innerHTML = `
            <option value="">Select a competency unit</option>
        `;

        // Competency Unit disabled
        competencyUnitSelect.disabled = true;

        // Course select না করলে Module disabled
        if (!courseId) {
            moduleSelect.disabled = true;
            return;
        }

        try {
            console.log("Loading modules for course:", courseId);

            const response = await fetch(
                `/elements/modules/${courseId}`
            );

            if (!response.ok) {
                throw new Error(
                    `Failed to fetch modules. Status: ${response.status}`
                );
            }

            const modules = await response.json();

            console.log("Modules:", modules);

            // যদি কোনো module না থাকে
            if (!modules.length) {
                moduleSelect.innerHTML = `
                    <option value="">No modules available</option>
                `;

                moduleSelect.disabled = true;
                return;
            }

            // Add Modules
            modules.forEach(function (module) {
                const option = document.createElement("option");

                option.value = module.id;

                option.textContent = module.module_number
                    ? `Module ${module.module_number} - ${module.name}`
                    : module.name;

                moduleSelect.appendChild(option);
            });

            // Enable Module
            moduleSelect.disabled = false;
        } catch (error) {
            console.error("Error loading modules:", error);

            moduleSelect.innerHTML = `
                <option value="">Failed to load modules</option>
            `;

            moduleSelect.disabled = true;
        }
    });

    // ---------------------------------------------------------
    // Module → Competency Unit
    // ---------------------------------------------------------

    moduleSelect.addEventListener("change", async function () {
        const moduleId = this.value;

        // Reset Competency Unit
        competencyUnitSelect.innerHTML = `
            <option value="">Select a competency unit</option>
        `;

        // Competency Unit disabled
        competencyUnitSelect.disabled = true;

        // Module select না করলে
        if (!moduleId) {
            return;
        }

        try {
            console.log(
                "Loading competency units for module:",
                moduleId
            );

            const response = await fetch(
                `/elements/competency-units/${moduleId}`
            );

            if (!response.ok) {
                throw new Error(
                    `Failed to fetch competency units. Status: ${response.status}`
                );
            }

            const competencyUnits = await response.json();

            console.log(
                "Competency Units:",
                competencyUnits
            );

            // যদি কোনো competency unit না থাকে
            if (!competencyUnits.length) {
                competencyUnitSelect.innerHTML = `
                    <option value="">
                        No competency units available
                    </option>
                `;

                competencyUnitSelect.disabled = true;
                return;
            }

            // Add Competency Units
            competencyUnits.forEach(function (competencyUnit) {
                const option = document.createElement("option");

                option.value = competencyUnit.id;

                /*
                |--------------------------------------------------------------------------
                | Competency Unit Name
                |--------------------------------------------------------------------------
                |
                | তোমার database-এ যদি name থাকে → name দেখাবে
                | title থাকলে → title দেখাবে
                | code থাকলে → code দেখাবে
                |
                */

                option.textContent =
                    competencyUnit.name ??
                    competencyUnit.title ??
                    competencyUnit.code ??
                    `Competency Unit #${competencyUnit.id}`;

                competencyUnitSelect.appendChild(option);
            });

            // Enable Competency Unit
            competencyUnitSelect.disabled = false;
        } catch (error) {
            console.error(
                "Error loading competency units:",
                error
            );

            competencyUnitSelect.innerHTML = `
                <option value="">
                    Failed to load competency units
                </option>
            `;

            competencyUnitSelect.disabled = true;
        }
    });
});