
document.addEventListener("DOMContentLoaded", function () {
    const batchSelect = document.getElementById("batch_id");
    const examSelect = document.getElementById("exam_id");
    const examSetSelect = document.getElementById("exam_set_id");

    if (!batchSelect || !examSelect || !examSetSelect) {
        return;
    }

    flatpickr("#start_at", {
        enableTime: true,
        altInput: true,
        altFormat: "F j, Y h:i K",
        dateFormat: "Y-m-d H:i",
        time_24hr: false,
        minuteIncrement: 5,
    });

    flatpickr("#end_at", {
        enableTime: true,
        altInput: true,
        altFormat: "F j, Y h:i K",
        dateFormat: "Y-m-d H:i",
        time_24hr: false,
        minuteIncrement: 5,
    });

    function showExamLoading() {
        examSelect.innerHTML = `
            <option value="">Loading exams...</option>
        `;

        examSelect.disabled = true;
    }

    function showExamSetLoading() {
        examSetSelect.innerHTML = `
            <option value="">Loading exam sets...</option>
        `;

        examSetSelect.disabled = true;
    }

    async function loadExams(
        batchId,
        selectedExamId = "",
        selectedExamSetId = ""
    ) {
        examSelect.innerHTML =
            '<option value="">Select Exam</option>';

        examSetSelect.innerHTML =
            '<option value="">Select Exam Set</option>';

        examSelect.disabled = true;
        examSetSelect.disabled = true;

        if (!batchId) {
            return;
        }

        showExamLoading();

        try {
            const response = await fetch(
                `/exam-slots/exams/${batchId}`
            );

            if (!response.ok) {
                throw new Error("Failed to load exams.");
            }

            const exams = await response.json();

            examSelect.innerHTML =
                '<option value="">Select Exam</option>';

            if (exams.length === 0) {
                examSelect.innerHTML =
                    '<option value="">No exams available</option>';

                return;
            }

            exams.forEach(function (exam) {
                const option = document.createElement("option");

                option.value = exam.id;
                option.textContent = exam.title;

                if (
                    String(exam.id) ===
                    String(selectedExamId)
                ) {
                    option.selected = true;
                }

                examSelect.appendChild(option);
            });

            examSelect.disabled = false;

            if (selectedExamId) {
                await loadExamSets(
                    selectedExamId,
                    selectedExamSetId
                );
            }
        } catch (error) {
            examSelect.innerHTML =
                '<option value="">Failed to load exams</option>';

            console.error(
                "Exam loading error:",
                error
            );
        }
    }

    async function loadExamSets(
        examId,
        selectedExamSetId = ""
    ) {
        examSetSelect.innerHTML =
            '<option value="">Select Exam Set</option>';

        examSetSelect.disabled = true;

        if (!examId) {
            return;
        }

        showExamSetLoading();

        try {
            const response = await fetch(
                `/exam-slots/exam-sets/${examId}`
            );

            if (!response.ok) {
                throw new Error(
                    "Failed to load exam sets."
                );
            }

            const examSets = await response.json();

            examSetSelect.innerHTML =
                '<option value="">Select Exam Set</option>';

            if (examSets.length === 0) {
                examSetSelect.innerHTML =
                    '<option value="">No exam sets available</option>';

                return;
            }

            examSets.forEach(function (examSet) {
                const option = document.createElement("option");

                option.value = examSet.id;
                option.textContent = examSet.name;

                if (
                    String(examSet.id) ===
                    String(selectedExamSetId)
                ) {
                    option.selected = true;
                }

                examSetSelect.appendChild(option);
            });

            examSetSelect.disabled = false;
        } catch (error) {
            examSetSelect.innerHTML =
                '<option value="">Failed to load exam sets</option>';

            console.error(
                "Exam set loading error:",
                error
            );
        }
    }

    batchSelect.addEventListener("change", function () {
        loadExams(this.value);
    });

    examSelect.addEventListener("change", function () {
        loadExamSets(this.value);
    });

    const editData = window.examSlotEdit;

    if (editData && batchSelect.value) {
        loadExams(
            batchSelect.value,
            editData.examId,
            editData.examSetId
        );
    }
});

