document.addEventListener("DOMContentLoaded", function () {
    function openModal(modal) {
        if (!modal) {
            return;
        }

        modal.classList.remove("hidden");
        modal.classList.add("flex");

        setTimeout(function () {
            modal.classList.remove("opacity-0");
            modal.classList.add("opacity-100");
        }, 10);

        document.body.classList.add("overflow-hidden");
    }

    function closeModal(modal) {
        if (!modal) {
            return;
        }

        modal.classList.remove("opacity-100");
        modal.classList.add("opacity-0");

        setTimeout(function () {
            modal.classList.add("hidden");
            modal.classList.remove("flex");
        }, 200);

        document.body.classList.remove("overflow-hidden");
    }

    window.openExamSetCreateModal = function () {
        const modal = document.getElementById("examSetCreateModal");
        openModal(modal);
    };

    window.closeExamSetCreateModal = function () {
        const modal = document.getElementById("examSetCreateModal");
        closeModal(modal);
    };

    window.openExamSetViewModal = function (id) {
        const modal = document.getElementById(`examSetViewModal${id}`);
        openModal(modal);
    };

    window.closeExamSetViewModal = function (id) {
        const modal = document.getElementById(`examSetViewModal${id}`);
        closeModal(modal);
    };

    window.openManageQuestionsModal = function (id) {
        const modal = document.getElementById(`manageQuestionsModal${id}`);
        openModal(modal);
    };

    window.closeManageQuestionsModal = function (id) {
        const modal = document.getElementById(`manageQuestionsModal${id}`);
        closeModal(modal);
    };

    window.openExamSetEditModal = function (id) {
        const modal = document.getElementById(`examSetEditModal${id}`);
        openModal(modal);
    };

    window.closeExamSetEditModal = function (id) {
        const modal = document.getElementById(`examSetEditModal${id}`);
        closeModal(modal);
    };

    document.addEventListener("click", function (event) {
        const backdrop = event.target.closest(".exam-set-modal-backdrop");

        if (backdrop && event.target === backdrop) {
            closeModal(backdrop);
        }
    });

    document.addEventListener("keydown", function (event) {
        if (event.key !== "Escape") {
            return;
        }

        const openModals = document.querySelectorAll(
            ".exam-set-modal-backdrop:not(.hidden)",
        );

        openModals.forEach(function (modal) {
            closeModal(modal);
        });
    });

    const validationModal = document.querySelector(
        ".exam-set-modal-backdrop[data-validation-error='true']",
    );

    if (validationModal) {
        openModal(validationModal);
    }
});
