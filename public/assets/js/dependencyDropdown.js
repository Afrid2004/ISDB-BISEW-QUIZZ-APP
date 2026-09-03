
document.addEventListener("DOMContentLoaded", () => {

    const dependencies = [
        ["course_id", "module_id", "/questions/modules/", "Select Module"],
        ["module_id", "competency_unit_id", "/questions/competency-units/", "Select Competency Unit"],
        ["competency_unit_id", "elements", "/questions/elements/", "Select Element"]
    ];

    dependencies.forEach(([source, target, url, placeholder]) => {

        const sourceEl = document.getElementById(source);
        const targetEl = document.getElementById(target);

        if (!sourceEl || !targetEl) return;

        sourceEl.addEventListener("change", async function () {

            // Reset target
            targetEl.innerHTML =
                `<option value="">${placeholder}</option>`;

            if (!this.value) return;

            // Loading
            targetEl.disabled = true;
            targetEl.innerHTML =
                `<option value="">Loading...</option>`;

            try {

                const response = await fetch(url + this.value, {
                    method: "GET",
                    headers: {
                        "Accept": "application/json",
                        "X-Requested-With": "XMLHttpRequest"
                    }
                });

                if (!response.ok) {
                    throw new Error(`HTTP ${response.status}`);
                }

                const data = await response.json();

                // Reset again
                targetEl.innerHTML =
                    `<option value="">${placeholder}</option>`;

                // No data
                if (!Array.isArray(data) || data.length === 0) {

                    targetEl.innerHTML +=
                        `<option value="" disabled>No data found</option>`;

                    return;
                }

                // Add options
                data.forEach(item => {

                    // Only Competency Unit shows CODE
                    const text =
                        target === "competency_unit_id"
                            ? item.code
                            : item.name;

                    targetEl.innerHTML +=
                        `<option value="${item.id}">${text}</option>`;
                });

            } catch (error) {

                console.error(
                    `Error loading ${target}:`,
                    error
                );

                targetEl.innerHTML =
                    `<option value="">Failed to load data</option>`;

            } finally {

                targetEl.disabled = false;
            }
        });
    });

});






// document.addEventListener("DOMContentLoaded", function () {

//     const dependencies = [
//         {
//             source: "course_id",
//             target: "module_id",
//             url: (id) => `/questions/modules/${id}`,
//             placeholder: "Select Module",
//         },
//         {
//             source: "module_id",
//             target: "competency_unit_id",
//             url: (id) => `/questions/competency-units/${id}`,
//             placeholder: "Select Competency Unit",
//         },
//     ];

//     dependencies.forEach(function (dependency) {
//         const sourceSelect = document.getElementById(dependency.source);
//         const targetSelect = document.getElementById(dependency.target);
//         if (!sourceSelect || !targetSelect) {
//             return;
//         }
//         sourceSelect.addEventListener("change", async function () {
//             const selectedId = this.value;
//             // Reset target select
//             targetSelect.innerHTML =
//                 `<option value="">${dependency.placeholder}</option>`;

//             if (!selectedId) {
//                 return;
//             }

//             try {
//                 const response = await fetch(
//                     dependency.url(selectedId)
//                 );

//                 if (!response.ok) {
//                     throw new Error("Failed to fetch data.");
//                 }

//                 const data = await response.json();

//                 data.forEach(function (item) {

//                     const option = document.createElement("option");

//                     option.value = item.id;
//                     option.textContent = item.name;

//                     targetSelect.appendChild(option);

//                 });

//             } catch (error) {
//                 console.error("Error loading data:", error);
//             }

//         });

//     });

// });