document.addEventListener("DOMContentLoaded", function () {
    const courseSelect = document.getElementById("course_id");
    const moduleSelect = document.getElementById("module_id");
    const competencyUnitSelect = document.getElementById("competency_unit_id");

    // ---------------------------------------------------------
    // Check Elements
    // ---------------------------------------------------------

    if (!courseSelect || !moduleSelect || !competencyUnitSelect) {
        console.error("Element form select not found.");
        return;
    }

    // ---------------------------------------------------------
    // Current values from Blade
    // ---------------------------------------------------------

    const currentModuleId = moduleSelect.dataset.currentModuleId || "";

    const currentCompetencyUnitId =
        competencyUnitSelect.dataset.currentCompetencyUnitId || "";

    // ---------------------------------------------------------
    // Initial State
    // ---------------------------------------------------------

    moduleSelect.disabled = true;
    competencyUnitSelect.disabled = true;

    // =========================================================
    // Load Modules
    // =========================================================

    async function loadModules(courseId, selectedModuleId = "") {
        // Reset module
        moduleSelect.innerHTML = `
            <option value="">Select a module</option>
        `;

        // Reset competency unit
        competencyUnitSelect.innerHTML = `
            <option value="">Select a competency unit</option>
        `;

        moduleSelect.disabled = true;
        competencyUnitSelect.disabled = true;

        // No course
        if (!courseId) {
            return;
        }

        try {
            console.log("Loading modules for course:", courseId);

            const response = await fetch(`/elements/modules/${courseId}`);

            if (!response.ok) {
                throw new Error(
                    `Failed to fetch modules. Status: ${response.status}`,
                );
            }

            const modules = await response.json();

            console.log("Modules:", modules);

            // No modules
            if (!modules.length) {
                moduleSelect.innerHTML = `
                    <option value="">
                        No modules available
                    </option>
                `;

                moduleSelect.disabled = true;

                return;
            }

            // Add modules
            modules.forEach(function (module) {
                const option = document.createElement("option");

                option.value = module.id;

                option.textContent = module.module_number
                    ? `Module ${module.module_number} - ${module.name}`
                    : module.name;

                // IMPORTANT
                // Edit page হলে current module select হবে

                if (
                    selectedModuleId &&
                    String(selectedModuleId) === String(module.id)
                ) {
                    option.selected = true;
                }

                moduleSelect.appendChild(option);
            });

            // Enable module
            moduleSelect.disabled = false;

            console.log("Selected module:", moduleSelect.value);

            // -------------------------------------------------
            // If edit page has current module
            // automatically load competency units
            // -------------------------------------------------

            if (selectedModuleId && moduleSelect.value) {
                await loadCompetencyUnits(
                    moduleSelect.value,
                    currentCompetencyUnitId,
                );
            }
        } catch (error) {
            console.error("Error loading modules:", error);

            moduleSelect.innerHTML = `
                <option value="">
                    Failed to load modules
                </option>
            `;

            moduleSelect.disabled = true;
        }
    }

    // =========================================================
    // Load Competency Units
    // =========================================================

    async function loadCompetencyUnits(
        moduleId,
        selectedCompetencyUnitId = "",
    ) {
        // Reset
        competencyUnitSelect.innerHTML = `
            <option value="">
                Select a competency unit
            </option>
        `;

        competencyUnitSelect.disabled = true;

        // No module
        if (!moduleId) {
            return;
        }

        try {
            console.log("Loading competency units for module:", moduleId);

            const response = await fetch(
                `/elements/competency-units/${moduleId}`,
            );

            if (!response.ok) {
                throw new Error(
                    `Failed to fetch competency units. Status: ${response.status}`,
                );
            }

            const competencyUnits = await response.json();

            console.log("Competency Units:", competencyUnits);

            // No competency units
            if (!competencyUnits.length) {
                competencyUnitSelect.innerHTML = `
                    <option value="">
                        No competency units available
                    </option>
                `;

                competencyUnitSelect.disabled = true;

                return;
            }

            // -------------------------------------------------
            // Add competency units
            // -------------------------------------------------

            competencyUnits.forEach(function (competencyUnit) {
                const option = document.createElement("option");

                option.value = competencyUnit.id;

                /*
                |--------------------------------------------------------------------------
                | IMPORTANT
                |--------------------------------------------------------------------------
                |
                | তোমার competency_units table-এ name নেই।
                | তোমার code আছে।
                |
                */

                option.textContent =
                    competencyUnit.code ||
                    `Competency Unit #${competencyUnit.id}`;

                // Edit page হলে current CU select হবে

                if (
                    selectedCompetencyUnitId &&
                    String(selectedCompetencyUnitId) ===
                        String(competencyUnit.id)
                ) {
                    option.selected = true;
                }

                competencyUnitSelect.appendChild(option);
            });

            // Enable competency unit
            competencyUnitSelect.disabled = false;

            console.log(
                "Selected competency unit:",
                competencyUnitSelect.value,
            );
        } catch (error) {
            console.error("Error loading competency units:", error);

            competencyUnitSelect.innerHTML = `
                <option value="">
                    Failed to load competency units
                </option>
            `;

            competencyUnitSelect.disabled = true;
        }
    }

    // =========================================================
    // Course Change
    // =========================================================

    courseSelect.addEventListener("change", function () {
        const courseId = this.value;

        // যখন user নতুন course select করবে
        // তখন পুরাতন edit values আর ব্যবহার হবে না

        loadModules(courseId, "");
    });

    // =========================================================
    // Module Change
    // =========================================================

    moduleSelect.addEventListener("change", function () {
        const moduleId = this.value;

        // নতুন module হলে current CU select করার দরকার নেই

        loadCompetencyUnits(moduleId, "");
    });

    // =========================================================
    // Edit Page Initial Load
    // =========================================================

    if (courseSelect.value) {
        console.log("Edit/Create initial course:", courseSelect.value);

        /*
        |--------------------------------------------------------------------------
        | এখানে আসল fix
        |--------------------------------------------------------------------------
        |
        | Blade থেকে currentModuleId নেওয়া হচ্ছে।
        |
        | তারপর course অনুযায়ী modules load হবে।
        |
        | তারপর সেই module automatically selected হবে।
        |
        | তারপর competency units automatically load হবে।
        |
        */

        loadModules(courseSelect.value, currentModuleId);
    }
});
