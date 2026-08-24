document.addEventListener("DOMContentLoaded", function () {

    const types = document.querySelectorAll(".question-type");
    const options = document.querySelectorAll(".correct-input");

    types.forEach((type) => {

        type.addEventListener("change", function () {

            const isMultiple = this.value === "multiple_choice";

            options.forEach((option) => {

                option.type = isMultiple ? "checkbox" : "radio";

                option.name = isMultiple
                    ? "correct_answer[]"
                    : "correct_answer";

            });

        });

    });

});