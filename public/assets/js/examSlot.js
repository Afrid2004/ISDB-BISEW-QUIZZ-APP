document.addEventListener("DOMContentLoaded", function () {
    const roundSelect = document.getElementById("round_id");
    const batchSelect = document.getElementById("batch_id");
    const examSelect = document.getElementById("exam_id");
    const examSetSelect = document.getElementById("exam_set_id");

    if (roundSelect && batchSelect && examSelect && examSetSelect) {
        if (document.getElementById("start_at")) {
            flatpickr("#start_at", {
                enableTime: true,
                altInput: true,
                altFormat: "F j, Y h:i K",
                dateFormat: "Y-m-d H:i",
                time_24hr: false,
                minuteIncrement: 5,
            });
        }

        if (document.getElementById("end_at")) {
            flatpickr("#end_at", {
                enableTime: true,
                altInput: true,
                altFormat: "F j, Y h:i K",
                dateFormat: "Y-m-d H:i",
                time_24hr: false,
                minuteIncrement: 5,
            });
        }

        function resetBatch() {
            batchSelect.innerHTML = '<option value="">Select Batch</option>';
            batchSelect.disabled = true;
        }

        function resetExam() {
            examSelect.innerHTML = '<option value="">Select Exam</option>';
            examSelect.disabled = true;
        }

        function resetExamSet() {
            examSetSelect.innerHTML =
                '<option value="">Select Exam Set</option>';
            examSetSelect.disabled = true;
        }

        function showBatchLoading() {
            batchSelect.innerHTML =
                '<option value="">Loading batches...</option>';
            batchSelect.disabled = true;
        }

        function showExamLoading() {
            examSelect.innerHTML = '<option value="">Loading exams...</option>';
            examSelect.disabled = true;
        }

        function showExamSetLoading() {
            examSetSelect.innerHTML =
                '<option value="">Loading exam sets...</option>';
            examSetSelect.disabled = true;
        }

        async function loadBatches(
            roundId,
            selectedBatchId = "",
            selectedExamId = "",
            selectedExamSetId = "",
        ) {
            resetBatch();
            resetExam();
            resetExamSet();

            if (!roundId) {
                return;
            }

            showBatchLoading();

            try {
                const response = await fetch(`/exam-slots/batches/${roundId}`);

                if (!response.ok) {
                    throw new Error("Failed to load batches.");
                }

                const batches = await response.json();

                batchSelect.innerHTML =
                    '<option value="">Select Batch</option>';

                if (batches.length === 0) {
                    batchSelect.innerHTML =
                        '<option value="">No batches available</option>';
                    return;
                }

                batches.forEach(function (batch) {
                    const option = document.createElement("option");

                    option.value = batch.id;
                    option.textContent = batch.name;

                    if (String(batch.id) === String(selectedBatchId)) {
                        option.selected = true;
                    }

                    batchSelect.appendChild(option);
                });

                batchSelect.disabled = false;

                if (selectedBatchId) {
                    await loadExams(
                        selectedBatchId,
                        selectedExamId,
                        selectedExamSetId,
                    );
                }
            } catch (error) {
                batchSelect.innerHTML =
                    '<option value="">Failed to load batches</option>';

                console.error("Batch loading error:", error);
            }
        }

        async function loadExams(
            batchId,
            selectedExamId = "",
            selectedExamSetId = "",
        ) {
            resetExam();
            resetExamSet();

            if (!batchId) {
                return;
            }

            showExamLoading();

            try {
                const response = await fetch(`/exam-slots/exams/${batchId}`);

                if (!response.ok) {
                    throw new Error("Failed to load exams.");
                }

                const exams = await response.json();

                examSelect.innerHTML = '<option value="">Select Exam</option>';

                if (exams.length === 0) {
                    examSelect.innerHTML =
                        '<option value="">No exams available</option>';
                    return;
                }

                exams.forEach(function (exam) {
                    const option = document.createElement("option");

                    option.value = exam.id;
                    option.textContent = exam.title;

                    if (String(exam.id) === String(selectedExamId)) {
                        option.selected = true;
                    }

                    examSelect.appendChild(option);
                });

                examSelect.disabled = false;

                if (selectedExamId) {
                    await loadExamSets(selectedExamId, selectedExamSetId);
                }
            } catch (error) {
                examSelect.innerHTML =
                    '<option value="">Failed to load exams</option>';

                console.error("Exam loading error:", error);
            }
        }

        async function loadExamSets(examId, selectedExamSetId = "") {
            resetExamSet();

            if (!examId) {
                return;
            }

            showExamSetLoading();

            try {
                const response = await fetch(`/exam-slots/exam-sets/${examId}`);

                if (!response.ok) {
                    throw new Error("Failed to load exam sets.");
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

                    if (String(examSet.id) === String(selectedExamSetId)) {
                        option.selected = true;
                    }

                    examSetSelect.appendChild(option);
                });

                examSetSelect.disabled = false;
            } catch (error) {
                examSetSelect.innerHTML =
                    '<option value="">Failed to load exam sets</option>';

                console.error("Exam set loading error:", error);
            }
        }

        roundSelect.addEventListener("change", function () {
            loadBatches(this.value);
        });

        batchSelect.addEventListener("change", function () {
            loadExams(this.value);
        });

        examSelect.addEventListener("change", function () {
            loadExamSets(this.value);
        });

        const selectedBatchId = batchSelect.dataset.selected || "";

        const selectedExamId = examSelect.dataset.selected || "";

        const selectedExamSetId = examSetSelect.dataset.selected || "";

        if (roundSelect.value) {
            loadBatches(
                roundSelect.value,
                selectedBatchId,
                selectedExamId,
                selectedExamSetId,
            );
        }
    }

    function formatDuration(totalSeconds) {
        totalSeconds = Math.max(0, Math.floor(totalSeconds));

        const hours = Math.floor(totalSeconds / 3600);

        const minutes = Math.floor((totalSeconds % 3600) / 60);

        const seconds = totalSeconds % 60;

        return (
            String(hours).padStart(2, "0") +
            ":" +
            String(minutes).padStart(2, "0") +
            ":" +
            String(seconds).padStart(2, "0")
        );
    }

    function updateExamTimers() {
        const now = new Date();

        document.querySelectorAll(".exam-slot-row").forEach(function (row) {
            const status = row.dataset.status;

            const startAt = row.dataset.startAt
                ? new Date(row.dataset.startAt)
                : null;

            const endAt = row.dataset.endAt
                ? new Date(row.dataset.endAt)
                : null;

            const liveText = row.querySelector(".schedule-live");

            const overtimeContainer = row.querySelector(".overtime-container");

            const overtimeTimer = row.querySelector(".overtime-timer");

            if (status === "scheduled" && startAt) {
                if (now < startAt) {
                    const remainingSeconds = Math.floor(
                        (startAt.getTime() - now.getTime()) / 1000,
                    );

                    if (liveText) {
                        liveText.textContent =
                            "Starts in " + formatDuration(remainingSeconds);
                    }
                } else {
                    if (liveText) {
                        liveText.textContent = "Starting automatically...";
                    }
                }
            }

            if (status === "start" && endAt) {
                if (now > endAt) {
                    const overtimeSeconds = Math.floor(
                        (now.getTime() - endAt.getTime()) / 1000,
                    );

                    if (overtimeContainer) {
                        overtimeContainer.classList.remove("hidden");
                    }

                    if (overtimeTimer) {
                        overtimeTimer.textContent =
                            "+" + formatDuration(overtimeSeconds);
                    }
                } else {
                    if (overtimeContainer) {
                        overtimeContainer.classList.add("hidden");
                    }
                }
            }
        });
    }

    updateExamTimers();

    setInterval(updateExamTimers, 1000);

    function showConfirm(form, action) {
        let title = "";
        let text = "";
        let confirmText = "";
        let icon = "warning";

        if (action === "start") {
            title = "Start Exam?";
            text = "Are you sure you want to start this exam now?";
            confirmText = "Yes, Start Exam";
            icon = "question";
        }

        if (action === "end") {
            title = "End Exam Now?";
            text =
                "Are you sure you want to end this exam? Students will no longer be able to continue.";
            confirmText = "Yes, End Exam";
            icon = "warning";
        }

        if (action === "delete") {
            title = "Delete Exam Slot?";
            text = "Are you sure you want to delete this exam slot?";
            confirmText = "Yes, Delete";
            icon = "warning";
        }

        Swal.fire({
            title: title,
            text: text,
            icon: icon,
            showCancelButton: true,
            confirmButtonText: confirmText,
            cancelButtonText: "Cancel",
            reverseButtons: true,
            focusCancel: true,
            buttonsStyling: false,
            customClass: {
                popup: "rounded-2xl",
                title: "text-lg font-bold text-slate-800",
                htmlContainer: "text-sm text-slate-500",
                confirmButton:
                    "rounded-lg bg-primary px-4 py-2.5 text-sm font-semibold text-white ml-2",
                cancelButton:
                    "rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-600",
            },
        }).then(function (result) {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    }

    document.querySelectorAll("[data-exam-action]").forEach(function (form) {
        form.addEventListener("submit", function (event) {
            event.preventDefault();

            const action = form.dataset.examAction;

            showConfirm(form, action);
        });
    });

    let autoStartChecking = false;

    async function checkAutoStart() {
        if (autoStartChecking) {
            return;
        }

        const scheduledRows = document.querySelectorAll(
            '.exam-slot-row[data-status="scheduled"]',
        );

        if (scheduledRows.length === 0) {
            return;
        }

        autoStartChecking = true;

        try {
            const response = await fetch(window.location.href, {
                headers: {
                    Accept: "text/html",
                    "X-Requested-With": "XMLHttpRequest",
                },
                cache: "no-store",
            });

            if (!response.ok) {
                throw new Error("Failed to check exam status.");
            }

            const html = await response.text();

            const parser = new DOMParser();
            const doc = parser.parseFromString(html, "text/html");

            const startedRows = doc.querySelectorAll(
                '.exam-slot-row[data-status="start"]',
            );

            if (startedRows.length > 0) {
                window.location.reload();
            }
        } catch (error) {
            console.error("Exam status check error:", error);
        } finally {
            autoStartChecking = false;
        }
    }

    checkAutoStart();

    setInterval(checkAutoStart, 5000);
});
