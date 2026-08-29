document.addEventListener("DOMContentLoaded", function () {
    const prefix = document.getElementById("prefix");
    const course = document.getElementById("course_id");
    const module = document.getElementById("module_id");
    const preview = document.getElementById("competency_unit_preview");

    course.addEventListener("change", function (event) {
        module.innerHTML = '<option value="">Select Module</option>';
        module.disabled = true;
        preview.textContent = "-";
        const courseId = event.target.value;
        if (!courseId) {
            return;
        }
        fetch(`/competency-units/modules/${courseId}`)
            .then((response) => response.json())
            .then((data) => {
                data.forEach(function (item) {
                    module.innerHTML += `
                        <option value="${item.id}">
                            Module ${item.module_number} - ${item.name}
                        </option>
                    `;
                });
                module.disabled = false;
            });
    });

    module.addEventListener("change", function () {
        if (!this.value) {
            preview.textContent = "-";
            return;
        }

        const courseCode =
            course.options[course.selectedIndex].text.split(" - ")[0];

        const moduleNumber =
            this.options[this.selectedIndex].text.match(/\d+/)[0];

        fetch(`/competency-units/next-serial/${this.value}`)
            .then((response) => response.json())
            .then((data) => {
                const serial = String(data.serial).padStart(2, "0");

                preview.textContent = `${prefix.value.toUpperCase()}${courseCode}${moduleNumber}${serial}`;
            });
    });
});
