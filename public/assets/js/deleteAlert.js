document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('.delete-form').forEach(function (form) {

        form.addEventListener('submit', function (e) {

            e.preventDefault();

            const item = form.dataset.item || 'item';

            const itemName = item.charAt(0).toUpperCase() + item.slice(1);

            Swal.fire({
                title: `Delete ${itemName}?`,

                text: `Are you sure you want to delete this ${item}? This action cannot be undone.`,

                icon: 'warning',

                showCancelButton: true,

                confirmButtonText: 'Yes, Delete',

                cancelButtonText: 'Cancel',

                confirmButtonColor: '#ef4444',

                cancelButtonColor: '#64748b',

                reverseButtons: true,

                customClass: {
                    popup: 'rounded-xl',
                    confirmButton: 'rounded-lg px-4 py-2',
                    cancelButton: 'rounded-lg px-4 py-2'
                }

            }).then((result) => {

                if (result.isConfirmed) {
                    form.submit();
                }

            });

        });

    });

});