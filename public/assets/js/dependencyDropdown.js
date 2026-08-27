document.addEventListener("DOMContentLoaded", function () {

    const dependencies = [
        {
            source: "course_id",
            target: "module_id",
            url: (id) => `/questions/modules/${id}`,
            placeholder: "Select Module",
        },
        {
            source: "module_id",
            target: "competency_unit_id",
            url: (id) => `/questions/competency-units/${id}`,
            placeholder: "Select Competency Unit",
        },
    ];

    dependencies.forEach(function (dependency) {
        const sourceSelect = document.getElementById(dependency.source);
        const targetSelect = document.getElementById(dependency.target);
        if (!sourceSelect || !targetSelect) {
            return;
        }
        sourceSelect.addEventListener("change", async function () {
            const selectedId = this.value;
            // Reset target select
            targetSelect.innerHTML =
                `<option value="">${dependency.placeholder}</option>`;

            if (!selectedId) {
                return;
            }

            try {
                const response = await fetch(
                    dependency.url(selectedId)
                );

                if (!response.ok) {
                    throw new Error("Failed to fetch data.");
                }

                const data = await response.json();

                data.forEach(function (item) {

                    const option = document.createElement("option");

                    option.value = item.id;
                    option.textContent = item.name;

                    targetSelect.appendChild(option);

                });

            } catch (error) {
                console.error("Error loading data:", error);
            }

        });

    });

});