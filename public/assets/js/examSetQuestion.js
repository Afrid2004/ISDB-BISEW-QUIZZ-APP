document.addEventListener("DOMContentLoaded", function () {
    const batchSelect = document.getElementById("batch_id");
    const examSelect = document.getElementById("exam_id");
    const examSetSelect = document.getElementById("exam_set_id");

    const questionSummary = document.getElementById("questionSummary");
    const loadingMessage = document.getElementById("loadingMessage");
    const noAssignmentMessage = document.getElementById(
        "noAssignmentMessage",
    );
    const assignmentList = document.getElementById("assignmentList");
    const assignmentRows = document.getElementById("assignmentRows");
    const totalQuestionBadge = document.getElementById(
        "totalQuestionBadge",
    );
    const generateButton = document.getElementById(
        "generateQuestionsButton",
    );

    function resetQuestionSummary() {
        questionSummary.classList.add("hidden");
        loadingMessage.classList.add("hidden");
        noAssignmentMessage.classList.add("hidden");
        assignmentList.classList.add("hidden");

        assignmentRows.innerHTML = "";

        totalQuestionBadge.textContent = "0 Questions";

        generateButton.disabled = true;
    }

    function resetExamSet() {
        examSetSelect.innerHTML =
            '<option value="">Select Exam Set</option>';

        examSetSelect.disabled = true;

        resetQuestionSummary();
    }

    function resetExam() {
        examSelect.innerHTML =
            '<option value="">Select Exam</option>';

        examSelect.disabled = true;

        resetExamSet();
    }

    function showLoading() {
        questionSummary.classList.remove("hidden");

        loadingMessage.classList.remove("hidden");
        noAssignmentMessage.classList.add("hidden");
        assignmentList.classList.add("hidden");

        assignmentRows.innerHTML = "";

        totalQuestionBadge.textContent = "0 Questions";

        generateButton.disabled = true;
    }

    batchSelect.addEventListener("change", async function () {
        const batchId = this.value;

        resetExam();

        if (!batchId) {
            return;
        }

        examSelect.disabled = true;

        examSelect.innerHTML =
            '<option value="">Loading exams...</option>';

        try {
            const response = await fetch(
                `${window.location.origin}/exam-set-questions/exams?batch_id=${batchId}`,
                {
                    headers: {
                        Accept: "application/json",
                    },
                },
            );

            if (!response.ok) {
                throw new Error("Failed to load exams.");
            }

            const exams = await response.json();

            examSelect.innerHTML =
                '<option value="">Select Exam</option>';

            if (exams.length === 0) {
                examSelect.innerHTML =
                    '<option value="">No exam available</option>';

                return;
            }

            exams.forEach((exam) => {
                const option = document.createElement("option");

                option.value = exam.id;
                option.textContent = exam.title;

                examSelect.appendChild(option);
            });

            examSelect.disabled = false;
        } catch (error) {
            console.error(error);

            examSelect.innerHTML =
                '<option value="">Failed to load exams</option>';
        }
    });

    examSelect.addEventListener("change", async function () {
        const examId = this.value;

        resetExamSet();

        if (!examId) {
            return;
        }

        examSetSelect.disabled = true;

        examSetSelect.innerHTML =
            '<option value="">Loading exam sets...</option>';

        try {
            const response = await fetch(
                `${window.location.origin}/exam-set-questions/exam-sets/${examId}`,
                {
                    headers: {
                        Accept: "application/json",
                    },
                },
            );

            if (!response.ok) {
                throw new Error("Failed to load exam sets.");
            }

            const examSets = await response.json();

            examSetSelect.innerHTML =
                '<option value="">Select Exam Set</option>';

            if (examSets.length === 0) {
                examSetSelect.innerHTML =
                    '<option value="">No exam set available</option>';

                return;
            }

            examSets.forEach((examSet) => {
                const option = document.createElement("option");

                option.value = examSet.id;

                option.textContent =
                    `${examSet.name} - Set ${examSet.set_number}`;

                examSetSelect.appendChild(option);
            });

            examSetSelect.disabled = false;
        } catch (error) {
            console.error(error);

            examSetSelect.innerHTML =
                '<option value="">Failed to load exam sets</option>';
        }
    });

    examSetSelect.addEventListener("change", async function () {
        const examSetId = this.value;

        resetQuestionSummary();

        if (!examSetId) {
            return;
        }

        showLoading();

        try {
            const response = await fetch(
                `${window.location.origin}/exam-set-questions/${examSetId}/questions`,
                {
                    headers: {
                        Accept: "application/json",
                    },
                },
            );

            if (!response.ok) {
                throw new Error(
                    "Failed to load question distribution.",
                );
            }

            const data = await response.json();

            loadingMessage.classList.add("hidden");

            if (
                !data.assignments ||
                data.assignments.length === 0
            ) {
                noAssignmentMessage.textContent =
                    "No competency units are assigned to this exam set.";

                noAssignmentMessage.classList.remove("hidden");

                return;
            }

            let totalQuestions = 0;

            assignmentRows.innerHTML = "";

            data.assignments.forEach((assignment) => {
                const requiredCount = Number(
                    assignment.required_count,
                );

                totalQuestions += requiredCount;

                const row = document.createElement("div");

                row.className =
                    "grid grid-cols-12 items-center border-t border-slate-200 px-4 py-3";

                const editUrl =
                    `${window.location.origin}/exam-set-competency-units/${assignment.id}/edit`;

                row.innerHTML = `
                    <div class="col-span-2 text-sm font-medium text-slate-700">
                        ${escapeHtml(
                            assignment.competency_unit?.code ?? "-",
                        )}
                    </div>

                    <div class="col-span-6 text-sm text-slate-600">
                        Competency Unit
                    </div>

                    <div class="col-span-2 flex justify-center">
                        <span
                            class="inline-flex min-w-10 justify-center rounded-md bg-indigo-50 px-3 py-1.5 text-sm font-semibold text-indigo-600">

                            ${requiredCount}

                        </span>
                    </div>

                    <div class="col-span-2 flex justify-center">

                        <a
                            href="${editUrl}"
                            class="inline-flex items-center gap-1 rounded-md bg-amber-50 px-3 py-1.5 text-xs font-semibold text-amber-600 transition hover:bg-amber-100">

                            <i class="bi bi-pencil"></i>

                            Edit

                        </a>

                    </div>
                `;

                assignmentRows.appendChild(row);
            });

            totalQuestionBadge.textContent =
                `${totalQuestions} Questions`;

            assignmentList.classList.remove("hidden");

            generateButton.disabled = false;
        } catch (error) {
            console.error(error);

            loadingMessage.classList.add("hidden");

            noAssignmentMessage.textContent =
                "Failed to load question distribution.";

            noAssignmentMessage.classList.remove("hidden");
        }
    });

    function escapeHtml(value) {
        const div = document.createElement("div");

        div.textContent = value;

        return div.innerHTML;
    }
});