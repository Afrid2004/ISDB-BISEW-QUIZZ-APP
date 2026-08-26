const updateDateTime = () => {
            const now = new Date();
            // Date
            const date = now.toLocaleDateString('en-GB', {
                day: '2-digit',
                month: 'short',
                year: 'numeric'
            });
            // Time
            const time = now.toLocaleTimeString('en-US', {
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit',
                hour12: true
            });
            const dateElement = document.getElementById('currentDate');
            const timeElement = document.getElementById('currentTime');
            if (dateElement) {
                dateElement.textContent = date;
            }
            if (timeElement) {
                timeElement.textContent = time;
            }
        };

        // Initial update
        updateDateTime();
        // Update every second
        setInterval(updateDateTime, 1000);