
document.addEventListener("DOMContentLoaded", function () {
    const forms = document.querySelectorAll(".manage-questions-form");

    if (!forms.length) {
        return;
    }

    forms.forEach(function (form) {
        const dataElement = form.querySelector(".manage-questions-data");
        const moduleSections = form.querySelector(".module-sections");
        const addModuleBtn = form.querySelector(".add-module-btn");
        const selectedQuestionCount = form.querySelector(
            ".selected-question-count",
        );

        if (
            !dataElement ||
            !moduleSections ||
            !addModuleBtn ||
            !selectedQuestionCount
        ) {
            return;
        }

        const modules = JSON.parse(
            dataElement.dataset.modules || "[]",
        );

        const existingMappings = JSON.parse(
            dataElement.dataset.existingMappings || "{}",
        );

        let moduleIndex = 0;

        function fetchData(url) {
            return fetch(url).then(function (response) {
                if (!response.ok) {
                    throw new Error("Failed to load data.");
                }

                return response.json();
            });
        }

        function updateQuestionCount() {
            let totalQuestions = 0;

            moduleSections
                .querySelectorAll(".question-count-input")
                .forEach(function (input) {
                    if (!input.disabled && input.value) {
                        totalQuestions += parseInt(input.value) || 0;
                    }
                });

            selectedQuestionCount.textContent = totalQuestions;
        }

        function showLoading(container) {
            container.innerHTML = `
                <div class="flex items-center justify-center py-8">
                    <div class="h-6 w-6 animate-spin rounded-full border-2 border-slate-200 border-t-primary"></div>
                    <span class="ml-3 text-sm text-slate-400">
                        Loading competency units...
                    </span>
                </div>
            `;
        }

        function resetCompetencyUnits(container) {
            container.innerHTML = `
                <p class="text-sm text-slate-400">
                    Select a module to load competency units.
                </p>
            `;
        }

        function getSelectedModules() {
            const selectedModules = [];

            moduleSections
                .querySelectorAll(".module-select")
                .forEach(function (select) {
                    if (select.value) {
                        selectedModules.push(select.value);
                    }
                });

            return selectedModules;
        }

        function updateModuleOptions() {
            const selectedModules = getSelectedModules();

            moduleSections
                .querySelectorAll(".module-select")
                .forEach(function (select) {
                    const currentValue = select.value;

                    select.innerHTML = `
                        <option value="">Select Module</option>
                    `;

                    modules.forEach(function (module) {
                        const moduleId = String(module.id);

                        if (
                            !selectedModules.includes(moduleId) ||
                            moduleId === currentValue
                        ) {
                            const option = document.createElement("option");

                            option.value = module.id;

                            option.textContent =
                                (module.module_number
                                    ? "Module " +
                                      module.module_number +
                                      " — "
                                    : "") + module.name;

                            if (moduleId === currentValue) {
                                option.selected = true;
                            }

                            select.appendChild(option);
                        }
                    });
                });
        }

        function setupCompetencyUnitEvents(container) {
            const checkboxes = container.querySelectorAll(
                ".competency-unit-checkbox",
            );

            const inputs = container.querySelectorAll(
                ".question-count-input",
            );

            checkboxes.forEach(function (checkbox) {
                checkbox.addEventListener("change", function () {
                    const competencyId =
                        this.dataset.competencyId;

                    const input = container.querySelector(
                        `[data-question-input="${competencyId}"]`,
                    );

                    if (!input) {
                        return;
                    }

                    input.disabled = !this.checked;

                    if (!this.checked) {
                        input.value = "";
                    }

                    updateQuestionCount();
                });
            });

            inputs.forEach(function (input) {
                input.addEventListener("input", function () {
                    updateQuestionCount();
                });
            });
        }

        function renderCompetencyUnits(
            container,
            data,
            index,
            moduleId,
        ) {
            container.innerHTML = "";

            if (!data.length) {
                container.innerHTML = `
                    <p class="text-sm text-slate-400">
                        No competency units found for this module.
                    </p>
                `;

                return;
            }

            const savedUnits =
                existingMappings[String(moduleId)] || {};

            data.forEach(function (item) {
                const row = document.createElement("div");

                const savedData =
                    savedUnits[String(item.id)] || null;

                const isSelected = savedData !== null;

                const questionCount = savedData
                    ? savedData.question_count
                    : "";

                row.className =
                    "competency-unit-row flex items-center gap-3 rounded-lg border border-slate-200 bg-white px-4 py-3";

                row.innerHTML = `
                    <label class="flex min-w-0 flex-1 cursor-pointer items-center gap-3">

                        <input
                            type="checkbox"
                            name="modules[${index}][competency_units][${item.id}][selected]"
                            value="1"
                            data-competency-id="${item.id}"
                            class="competency-unit-checkbox h-4 w-4 cursor-pointer rounded border-slate-300 text-primary focus:ring-primary/20"
                            ${isSelected ? "checked" : ""}>

                        <span class="text-sm font-medium text-slate-700">
                            ${item.code}
                        </span>

                    </label>

                    <input
                        type="number"
                        name="modules[${index}][competency_units][${item.id}][question_count]"
                        value="${questionCount}"
                        min="1"
                        placeholder="Questions"
                        data-question-input="${item.id}"
                        class="question-count-input w-28 rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm text-slate-700 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20 disabled:cursor-not-allowed disabled:bg-slate-100 disabled:text-slate-400"
                        ${isSelected ? "" : "disabled"}>
                `;

                container.appendChild(row);
            });

            setupCompetencyUnitEvents(container);

            updateQuestionCount();
        }

        async function loadCompetencyUnits(moduleSelect) {
            const section = moduleSelect.closest(".module-section");

            if (!section) {
                return;
            }

            const container = section.querySelector(
                ".competency-units-container",
            );

            if (!moduleSelect.value) {
                resetCompetencyUnits(container);
                updateQuestionCount();
                return;
            }

            showLoading(container);

            try {
                const response = await fetchData(
                    `/exam-set-competency-units/competency-units/${moduleSelect.value}`,
                );

                const match = moduleSelect.name.match(
                    /modules\[(\d+)\]/,
                );

                if (!match) {
                    return;
                }

                const index = match[1];

                renderCompetencyUnits(
                    container,
                    response,
                    index,
                    String(moduleSelect.value),
                );
            } catch (error) {
                console.error(
                    "Error loading competency units:",
                    error,
                );

                container.innerHTML = `
                    <p class="text-sm text-red-500">
                        Failed to load competency units.
                    </p>
                `;
            }
        }

        function createModuleSection(
            selectedModuleId = "",
            loadUnits = false,
        ) {
            const index = moduleIndex;

            const section = document.createElement("div");

            section.className =
                "module-section rounded-lg border border-slate-200 bg-white p-4";

            section.innerHTML = `
                <div class="flex items-center gap-3">

                    <select
                        name="modules[${index}][module_id]"
                        class="module-select w-full rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-700 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20">

                        <option value="">
                            Select Module
                        </option>

                    </select>

                    <button
                        type="button"
                        class="remove-module-btn inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-lg border border-red-200 text-red-500 transition hover:bg-red-50"
                        title="Remove Module">

                        <i class="bi bi-trash"></i>

                    </button>

                </div>

                <p class="mt-1.5 text-xs text-slate-400">
                    Select a module to load competency units.
                </p>

                <div
                    class="competency-units-container mt-4 space-y-2 rounded-lg border border-slate-200 bg-slate-50 p-3">

                    <p class="text-sm text-slate-400">
                        Select a module to load competency units.
                    </p>

                </div>
            `;

            moduleSections.appendChild(section);

            const select =
                section.querySelector(".module-select");

            modules.forEach(function (module) {
                const option =
                    document.createElement("option");

                option.value = module.id;

                option.textContent =
                    (module.module_number
                        ? "Module " +
                          module.module_number +
                          " — "
                        : "") + module.name;

                if (
                    String(module.id) ===
                    String(selectedModuleId)
                ) {
                    option.selected = true;
                }

                select.appendChild(option);
            });

            select.addEventListener("change", function () {
                updateModuleOptions();
                loadCompetencyUnits(this);
            });

            section
                .querySelector(".remove-module-btn")
                .addEventListener("click", function () {
                    section.remove();

                    updateModuleOptions();
                    updateQuestionCount();
                });

            moduleIndex++;

            updateModuleOptions();

            if (loadUnits && selectedModuleId) {
                loadCompetencyUnits(select);
            }
        }

        function loadExistingModules() {
            const existingModuleIds =
                Object.keys(existingMappings);

            if (!existingModuleIds.length) {
                createModuleSection();
                return;
            }

            existingModuleIds.forEach(function (moduleId) {
                createModuleSection(moduleId, true);
            });
        }

        addModuleBtn.addEventListener("click", function () {
            createModuleSection();
        });

        loadExistingModules();

        updateQuestionCount();
    });
});

