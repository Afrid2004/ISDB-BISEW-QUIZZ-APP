document.addEventListener("DOMContentLoaded", function () {
    const optionsContainer = document.getElementById("options-container");
    const optionCount = document.getElementById("option-count");
    const questionTypes = document.querySelectorAll(".question-type");
    const addOptionButton = document.getElementById("add-option");

    const letters = ["A", "B", "C", "D"];

    // Question type change
    questionTypes.forEach(function (type) {
        type.addEventListener("change", function (event) {
            const isMultiple = event.target.value === "multiple_choice";

            const correctInputs =
                optionsContainer.querySelectorAll(".correct-input");

            correctInputs.forEach(function (input) {
                if (isMultiple) {
                    input.type = "checkbox";
                    input.name = "correct_answers[]";
                } else {
                    input.type = "radio";
                    input.name = "correct_answer";
                }
            });

            updateCorrectAnswerStyles();
        });
    });

    // Update correct answer style
    function updateCorrectAnswerStyles() {
        const correctInputs =
            optionsContainer.querySelectorAll(".correct-input");

        correctInputs.forEach(function (input) {
            const label = input.closest(".correct-option");
            const row = label.parentElement;
            const letter = row.querySelector(".option-letter");

            if (input.checked) {
                letter.classList.add("bg-primary/10", "text-primary");
                letter.classList.remove("bg-slate-100", "text-slate-500");

                label.classList.remove(
                    "border-slate-200",
                    "text-slate-400"
                );

                label.classList.add(
                    "border-primary",
                    "bg-primary",
                    "text-white"
                );
            } else {
                letter.classList.remove(
                    "bg-primary/10",
                    "text-primary"
                );

                letter.classList.add(
                    "bg-slate-100",
                    "text-slate-500"
                );

                label.classList.add(
                    "border-slate-200",
                    "text-slate-400"
                );

                label.classList.remove(
                    "border-primary",
                    "bg-primary",
                    "text-white"
                );
            }
        });
    }

    // Get option rows
    function getOptionRows() {
        return optionsContainer.querySelectorAll(".option-row");
    }

    // Update Add Option button
    function updateAddButton() {
        const count = getOptionRows().length;

        if (count < 4) {
            addOptionButton.classList.remove("hidden");
            addOptionButton.classList.add("inline-flex");
        } else {
            addOptionButton.classList.add("hidden");
            addOptionButton.classList.remove("inline-flex");
        }
    }

    // Re-index options
    function reindexOptions() {
        const rows = getOptionRows();

        rows.forEach(function (row, index) {
            const letter = letters[index];

            // Letter
            row.querySelector(".option-letter").textContent = letter;

            // Option input
            const optionInput = row.querySelector(".option-input");

            optionInput.name = `options[${letter}]`;
            optionInput.placeholder = `Enter option ${letter}`;

            // Correct answer
            const correctInput =
                row.querySelector(".correct-input");

            correctInput.value = letter;
        });

        // Option count
        optionCount.textContent = rows.length;

        // Add button
        updateAddButton();

        // Correct answer styles
        updateCorrectAnswerStyles();
    }

    // Add option
    addOptionButton.addEventListener("click", function () {
        createOption();
    });

    // Create new option
    function createOption() {
        const rows = getOptionRows();
        const index = rows.length;

        // Maximum 4 options
        if (index >= 4) {
            return;
        }

        const letter = letters[index];

        const isMultiple =
            document.querySelector(".question-type:checked")?.value ===
            "multiple_choice";

        const inputType = isMultiple ? "checkbox" : "radio";

        const inputName = isMultiple
            ? "correct_answers[]"
            : "correct_answer";

        const row = document.createElement("div");

        row.className = "option-row flex items-center gap-3";

        row.innerHTML = `
            <span
                class="option-letter flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-slate-100 text-sm font-bold text-slate-500">
                ${letter}
            </span>

            <input
                type="text"
                name="options[${letter}]"
                placeholder="Enter option ${letter}"
                class="option-input w-full rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/10">

            <label
                class="correct-option flex h-9 w-9 shrink-0 cursor-pointer items-center justify-center rounded-lg border border-slate-200 text-slate-400 transition hover:border-primary hover:bg-primary/5 hover:text-primary"
                title="Mark as correct answer">

                <input
                    type="${inputType}"
                    name="${inputName}"
                    value="${letter}"
                    class="correct-input sr-only">

                <i class="bi bi-check-lg"></i>

            </label>

            <button
                type="button"
                class="delete-option border border-red-100 bg-red-300/20 text-red-300 flex h-9 w-9 shrink-0 items-center justify-center rounded-lg transition hover:bg-red-50 hover:text-red-500"
                title="Delete option">

                <i class="bi bi-trash"></i>

            </button>
        `;

        optionsContainer.appendChild(row);

        reindexOptions();
    }

    // Delete option
    optionsContainer.addEventListener("click", function (event) {
        const deleteButton =
            event.target.closest(".delete-option");

        if (!deleteButton) {
            return;
        }

        if (getOptionRows().length <= 2) {
            alert("At least 2 options are required.");
            return;
        }

        deleteButton.closest(".option-row").remove();

        reindexOptions();
    });

    // Correct answer change
    optionsContainer.addEventListener("change", function (event) {
        if (!event.target.classList.contains("correct-input")) {
            return;
        }

        updateCorrectAnswerStyles();
    });

    // Initial setup
    reindexOptions();
});