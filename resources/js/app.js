
/* =========================================
   CERTTRACK - INTERACTIVE FEATURES
   ========================================= */

document.addEventListener("DOMContentLoaded", function () {

    // CONFIRMATION + DOUBLE SUBMISSION PROTECTION
    document.querySelectorAll("form").forEach(function (form) {

        form.addEventListener("submit", function (event) {

            // Ask for confirmation when the form requires it.
            const message = form.dataset.confirm;

            if (message && !window.confirm(message)) {
                event.preventDefault();
                return;
            }

            // Prevent accidental repeated submissions.
            if (form.dataset.submitting === "true") {
                event.preventDefault();
                return;
            }

            form.dataset.submitting = "true";

            const button = form.querySelector(
                'button[type="submit"], input[type="submit"]'
            );

            if (button) {
                button.disabled = true;

                if (button.tagName === "BUTTON") {
                    button.textContent = "Processing...";
                }
            }
        });
    });

    // FORM VALIDATION FEEDBACK
    document.querySelectorAll("input, select, textarea").forEach(function (field) {

        field.addEventListener("invalid", function () {
            field.classList.add("is-invalid");
        });

        field.addEventListener("input", function () {
            if (field.checkValidity()) {
                field.classList.remove("is-invalid");
            }
        });
    });

    // AUTOMATICALLY HIDE SUCCESS MESSAGES
    document.querySelectorAll(".success, .alert-success").forEach(function (message) {

        window.setTimeout(function () {
            message.style.transition = "opacity 0.4s ease";
            message.style.opacity = "0";

            window.setTimeout(function () {
                message.style.display = "none";
            }, 450);

        }, 6000);
    });

    // LIVE TABLE SEARCH
    const searchInput = document.getElementById("tableSearch");

    if (searchInput) {
        searchInput.addEventListener("input", function () {

            const searchText = searchInput.value.toLowerCase();

            document.querySelectorAll("table tbody tr").forEach(function (row) {
                row.style.display = row.textContent.toLowerCase().includes(searchText)
                    ? ""
                    : "none";
            });
        });
    }

    // CERTIFICATE DATE VALIDATION
    const issueDate = document.querySelector('input[name="issue_date"]');
    const inspectionDate = document.querySelector('input[name="next_inspection_date"]');

    if (issueDate && inspectionDate) {

        function validateDates() {

            inspectionDate.setCustomValidity("");

            if (
                issueDate.value &&
                inspectionDate.value &&
                inspectionDate.value < issueDate.value
            ) {
                inspectionDate.setCustomValidity(
                    "Next inspection date cannot be before issue date."
                );
            }
        }

        issueDate.addEventListener("change", validateDates);
        inspectionDate.addEventListener("change", validateDates);
    }

    console.log("CertTrack JavaScript loaded successfully.");
});
