    document.addEventListener('DOMContentLoaded', function () {

        document.querySelectorAll('.delete-form').forEach(function (form) {

            form.addEventListener('submit', function (e) {

                e.preventDefault();

                Swal.fire({
                    title: 'Delete Round?',
                    text: 'Are you sure you want to delete this round? This action cannot be undone.',
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