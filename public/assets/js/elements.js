document.addEventListener("DOMContentLoaded", function () {
    const courseSelect = document.getElementById("course_id");
    const moduleSelect = document.getElementById("module_id");
    const competencyUnitSelect = document.getElementById("competency_unit_id");

    // Check elements
    if (!courseSelect || !moduleSelect || !competencyUnitSelect) {
        console.error("Element form select not found.");
        return;
    }

    // Current values
    const currentModuleId = moduleSelect.dataset.currentModuleId || "";
    const currentCompetencyUnitId =
        competencyUnitSelect.dataset.currentCompetencyUnitId || "";

    // Initial state
    moduleSelect.disabled = true;
    competencyUnitSelect.disabled = true;

    // Load modules
    async function loadModules(courseId, selectedModuleId = "") {
        moduleSelect.innerHTML = `<option value="">Select a module</option>`;
        competencyUnitSelect.innerHTML = `<option value="">Select a competency unit</option>`;
        moduleSelect.disabled = true;
        competencyUnitSelect.disabled = true;

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

            if (!modules.length) {
                moduleSelect.innerHTML = `<option value="">No modules available</option>`;
                moduleSelect.disabled = true;
                return;
            }

            modules.forEach(function (module) {
                const option = document.createElement("option");
                option.value = module.id;
                option.textContent = module.module_number
                    ? `Module ${module.module_number} - ${module.name}`
                    : module.name;

                if (
                    selectedModuleId &&
                    String(selectedModuleId) === String(module.id)
                ) {
                    option.selected = true;
                }

                moduleSelect.appendChild(option);
            });

            moduleSelect.disabled = false;
            console.log("Selected module:", moduleSelect.value);

            // Load competency units for selected module
            if (selectedModuleId && moduleSelect.value) {
                await loadCompetencyUnits(
                    moduleSelect.value,
                    currentCompetencyUnitId,
                );
            }
        } catch (error) {
            console.error("Error loading modules:", error);
            moduleSelect.innerHTML = `<option value="">Failed to load modules</option>`;
            moduleSelect.disabled = true;
        }
    }

    // Load competency units
    async function loadCompetencyUnits(
        moduleId,
        selectedCompetencyUnitId = "",
    ) {
        competencyUnitSelect.innerHTML = `<option value="">Select a competency unit</option>`;
        competencyUnitSelect.disabled = true;

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

            if (!competencyUnits.length) {
                competencyUnitSelect.innerHTML = `<option value="">No competency units available</option>`;
                competencyUnitSelect.disabled = true;
                return;
            }

            // Add competency units
            competencyUnits.forEach(function (competencyUnit) {
                const option = document.createElement("option");
                option.value = competencyUnit.id;
                option.textContent =
                    competencyUnit.code ||
                    `Competency Unit #${competencyUnit.id}`;

                if (
                    selectedCompetencyUnitId &&
                    String(selectedCompetencyUnitId) ===
                        String(competencyUnit.id)
                ) {
                    option.selected = true;
                }

                competencyUnitSelect.appendChild(option);
            });

            competencyUnitSelect.disabled = false;
            console.log(
                "Selected competency unit:",
                competencyUnitSelect.value,
            );
        } catch (error) {
            console.error("Error loading competency units:", error);
            competencyUnitSelect.innerHTML = `<option value="">Failed to load competency units</option>`;
            competencyUnitSelect.disabled = true;
        }
    }

    // Course change
    courseSelect.addEventListener("change", function () {
        const courseId = this.value;
        loadModules(courseId, "");
    });

    // Module change
    moduleSelect.addEventListener("change", function () {
        const moduleId = this.value;
        loadCompetencyUnits(moduleId, "");
    });

    // Edit page initial load
    if (courseSelect.value) {
        console.log("Edit/Create initial course:", courseSelect.value);
        loadModules(courseSelect.value, currentModuleId);
    }
});
