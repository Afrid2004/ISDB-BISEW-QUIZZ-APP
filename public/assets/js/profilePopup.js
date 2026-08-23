    document.addEventListener('DOMContentLoaded', function () {

        const profileToggle = document.getElementById('profileToggle');
        const profilePopup = document.getElementById('profilePopup');

        if (!profileToggle || !profilePopup) {
            return;
        }


        // Toggle popup
        profileToggle.addEventListener('click', function (event) {

            event.stopPropagation();

            profilePopup.classList.toggle('hidden');

        });


        // Close when clicking outside
        document.addEventListener('click', function (event) {

            if (
                !profilePopup.contains(event.target) &&
                !profileToggle.contains(event.target)
            ) {

                profilePopup.classList.add('hidden');

            }

        });

    });