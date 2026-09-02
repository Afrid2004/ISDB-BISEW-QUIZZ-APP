document.addEventListener("DOMContentLoaded", function () {
    const dependencies = [
        {
            name: "Exam",
            source: "batch_id",
            target: "exam_id",
            url: (id) => `/exam-set-competency-units/exams?batch_id=${id}`,
        },
        {
            name: "Module",
            source: "batch_id",
            target: "module_id",
            url: (id) => `/exam-set-competency-units/modules?batch_id=${id}`,
        },
        {
            name: "Exam Set",
            source: "exam_id",
            target: "exam_set_id",
            url: (id) => `/exam-set-competency-units/exam-sets/${id}`,
        },
        {
            name: "Competency Unit",
            source: "module_id",
            target: "competency_unit_id",
            url: (id) => `/exam-set-competency-units/competency-units/${id}`,
        },
    ];

    async function loadDependent(dependency, selectedId, preselectValue) {
        const targetSelect = document.getElementById(dependency.target);
        if (!targetSelect) return;

        targetSelect.innerHTML = `<option value="">Select ${dependency.name}</option>`;
        targetSelect.disabled = true;

        if (!selectedId) return;

        try {
            const response = await fetch(dependency.url(selectedId));
            if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);
            const data = await response.json();

            data.forEach(function (item) {
                const option = document.createElement("option");
                option.value = item.id;

                if (dependency.target === "exam_set_id") {
                    option.textContent = `${item.name} — Set ${item.set_number}`;
                } else if (dependency.target === "module_id") {
                    option.textContent = item.module_number
                        ? `Module ${item.module_number} — ${item.name}`
                        : item.name;
                } else if (dependency.target === "exam_id") {
                    option.textContent = item.title;
                } else if (dependency.target === "competency_unit_id") {
                    option.textContent = item.code;
                }

                if (preselectValue && String(item.id) === String(preselectValue)) {
                    option.selected = true;
                }

                targetSelect.appendChild(option);
            });

            if (data.length > 0) {
                targetSelect.disabled = false;
            }

            // Chain: if this target itself has a dependent child, trigger it too
            const childDependency = dependencies.find((d) => d.source === dependency.target);
            if (childDependency && preselectValue) {
                const childPreselect = document.getElementById(childDependency.target)?.dataset.selected;
                await loadDependent(childDependency, preselectValue, childPreselect);
            }
        } catch (error) {
            console.error(`Error loading ${dependency.target}:`, error);
        }
    }

    dependencies.forEach(function (dependency) {
        const sourceSelect = document.getElementById(dependency.source);
        const targetSelect = document.getElementById(dependency.target);
        if (!sourceSelect || !targetSelect) return;

        targetSelect.disabled = true;

        sourceSelect.addEventListener("change", async function () {
            const preselect = null; // manual change, no preselect needed
            await loadDependent(dependency, this.value, preselect);
        });
    });

    // On page load (edit page), auto-trigger chain for pre-filled values
    const batchSelect = document.getElementById("batch_id");
    if (batchSelect && batchSelect.value) {
        dependencies
            .filter((d) => d.source === "batch_id")
            .forEach(async (dependency) => {
                const preselectValue = document.getElementById(dependency.target)?.dataset.selected;
                await loadDependent(dependency, batchSelect.value, preselectValue);
            });
    }
});