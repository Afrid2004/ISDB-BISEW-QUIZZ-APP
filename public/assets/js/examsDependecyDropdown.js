document.addEventListener("DOMContentLoaded", function () {
    const dependencies = [
        {
            source: "course_id",
            target: "batch_id",
            url: (id) => `/exams/batches/${id}`,
            placeholder: "Select Batch",
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

            // Reset batch dropdown
            targetSelect.innerHTML = `
                <option value="">${dependency.placeholder}</option>
            `;

            // Disable if no course selected
            targetSelect.disabled = true;

            if (!selectedId) {
                return;
            }

            try {
                const response = await fetch(dependency.url(selectedId));

                if (!response.ok) {
                    throw new Error("Failed to fetch batches.");
                }

                const data = await response.json();

                data.forEach(function (item) {
                    const option = document.createElement("option");

                    option.value = item.id;
                    option.textContent = item.name;

                    targetSelect.appendChild(option);
                });

                // Enable batch dropdown
                targetSelect.disabled = false;
            } catch (error) {
                console.error("Error loading batches:", error);
            }
        });
    });
});
