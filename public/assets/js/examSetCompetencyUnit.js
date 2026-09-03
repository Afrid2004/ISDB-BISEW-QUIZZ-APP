document.addEventListener("DOMContentLoaded", function () {
    const batchSelect = document.getElementById("batch_id");
    const examSelect = document.getElementById("exam_id");
    const moduleSelect = document.getElementById("module_id");
    const examSetSelect = document.getElementById("exam_set_id");
    const competencyUnitsContainer = document.getElementById(
        "competencyUnitsContainer",
    );

    if (
        !batchSelect ||
        !examSelect ||
        !moduleSelect ||
        !examSetSelect ||
        !competencyUnitsContainer
    ) {
        return;
    }

    let existingMappings = {};

    try {
        existingMappings = JSON.parse(
            competencyUnitsContainer.dataset.existingMappings || "{}",
        );
    } catch (error) {
        existingMappings = {};
    }

    function resetSelect(select, placeholder) {
        select.innerHTML = `<option value="">${placeholder}</option>`;
        select.disabled = true;
    }

    function resetCompetencyUnits() {
        competencyUnitsContainer.innerHTML = `
            <p class="text-sm text-slate-400">
                Select a module to load competency units.
            </p>
        `;
    }

    async function fetchData(url) {
        const response = await fetch(url);

        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }

        return await response.json();
    }

    function populateSelect(select, data, type, selectedValue = "") {
        select.innerHTML = "";

        const placeholder = document.createElement("option");
        placeholder.value = "";
        placeholder.textContent = `Select ${type}`;
        select.appendChild(placeholder);

        data.forEach(function (item) {
            const option = document.createElement("option");

            option.value = item.id;

            if (type === "Exam") {
                option.textContent = item.title;
            }

            if (type === "Module") {
                option.textContent = item.module_number
                    ? `Module ${item.module_number} — ${item.name}`
                    : item.name;
            }

            if (type === "Exam Set") {
                option.textContent = `${item.name} — Set ${item.set_number}`;
            }

            if (selectedValue && String(item.id) === String(selectedValue)) {
                option.selected = true;
            }

            select.appendChild(option);
        });

        select.disabled = data.length === 0;
    }

    function renderCompetencyUnits(data, selectedUnits = {}) {
        competencyUnitsContainer.innerHTML = "";

        if (!data.length) {
            competencyUnitsContainer.innerHTML = `
                <p class="text-sm text-slate-400">
                    No competency units found for this module.
                </p>
            `;
            return;
        }

        data.forEach(function (item) {
            const selected = selectedUnits[item.id] || null;

            const row = document.createElement("div");

            row.className =
                "flex items-center gap-3 rounded-lg border border-slate-200 bg-white px-4 py-3";

            row.innerHTML = `
                <label class="flex min-w-0 flex-1 cursor-pointer items-center gap-3">
                    <input
                        type="checkbox"
                        name="competency_units[${item.id}][selected]"
                        value="1"
                        data-competency-id="${item.id}"
                        class="competency-unit-checkbox h-4 w-4 cursor-pointer rounded border-slate-300 text-primary focus:ring-primary/20"
                        ${selected ? "checked" : ""}
                    >

                    <span class="text-sm font-medium text-slate-700">
                        ${item.code}
                    </span>
                </label>

                <input
                    type="number"
                    name="competency_units[${item.id}][question_count]"
                    value="${selected ? selected.question_count : ""}"
                    min="1"
                    placeholder="Questions"
                    data-question-input="${item.id}"
                    class="w-28 rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm text-slate-700 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20 disabled:cursor-not-allowed disabled:bg-slate-100 disabled:text-slate-400"
                    ${selected ? "" : "disabled"}
                >
            `;

            competencyUnitsContainer.appendChild(row);
        });

        setupCompetencyUnitEvents();
    }

    function setupCompetencyUnitEvents() {
        const checkboxes = competencyUnitsContainer.querySelectorAll(
            ".competency-unit-checkbox",
        );

        checkboxes.forEach(function (checkbox) {
            checkbox.addEventListener("change", function () {
                const competencyId = this.dataset.competencyId;

                const input = competencyUnitsContainer.querySelector(
                    `[data-question-input="${competencyId}"]`,
                );

                if (!input) {
                    return;
                }

                input.disabled = !this.checked;

                if (this.checked) {
                    input.focus();
                } else {
                    input.value = "";
                }
            });
        });
    }

    async function loadExams(batchId, selectedValue = "") {
        resetSelect(examSelect, "Select Exam");
        resetSelect(examSetSelect, "Select Exam Set");
        resetCompetencyUnits();

        if (!batchId) {
            return;
        }

        try {
            const data = await fetchData(
                `/exam-set-competency-units/exams?batch_id=${batchId}`,
            );

            populateSelect(examSelect, data, "Exam", selectedValue);
        } catch (error) {
            console.error("Error loading exams:", error);
        }
    }

    async function loadModules(batchId, selectedValue = "") {
        resetSelect(moduleSelect, "Select Module");
        resetCompetencyUnits();

        if (!batchId) {
            return;
        }

        try {
            const data = await fetchData(
                `/exam-set-competency-units/modules?batch_id=${batchId}`,
            );

            populateSelect(moduleSelect, data, "Module", selectedValue);
        } catch (error) {
            console.error("Error loading modules:", error);
        }
    }

    async function loadExamSets(examId, selectedValue = "") {
        resetSelect(examSetSelect, "Select Exam Set");

        if (!examId) {
            return;
        }

        try {
            const data = await fetchData(
                `/exam-set-competency-units/exam-sets/${examId}`,
            );

            populateSelect(examSetSelect, data, "Exam Set", selectedValue);
        } catch (error) {
            console.error("Error loading exam sets:", error);
        }
    }

    async function loadCompetencyUnits(
        moduleId,
        selectedUnits = {},
    ) {
        resetCompetencyUnits();

        if (!moduleId) {
            return;
        }

        try {
            const data = await fetchData(
                `/exam-set-competency-units/competency-units/${moduleId}`,
            );

            renderCompetencyUnits(data, selectedUnits);
        } catch (error) {
            console.error("Error loading competency units:", error);
        }
    }

    batchSelect.addEventListener("change", async function () {
        existingMappings = {};

        await loadExams(this.value);
        await loadModules(this.value);

        resetSelect(examSetSelect, "Select Exam Set");
    });

    examSelect.addEventListener("change", async function () {
        await loadExamSets(this.value);
    });

    moduleSelect.addEventListener("change", async function () {
        await loadCompetencyUnits(this.value, existingMappings);
    });

    const oldBatch = batchSelect.value;
    const oldExam = examSelect.dataset.selected;
    const oldModule = moduleSelect.dataset.selected;
    const oldExamSet = examSetSelect.dataset.selected;

    if (oldBatch) {
        Promise.all([
            loadExams(oldBatch, oldExam),
            loadModules(oldBatch, oldModule),
        ]).then(async function () {
            if (oldExam) {
                await loadExamSets(oldExam, oldExamSet);
            }

            if (oldModule) {
                await loadCompetencyUnits(
                    oldModule,
                    existingMappings,
                );
            }
        });
    }
});