<script type="module">
    let table, formAdd, formEdit;

    function initDtTable() {
        table = new DataTable('#users-table', {
            processing: true,
            responsive: true,
            serverSide: true,
            ajax: "{{ route('users.index') }}",
            searching: false,
            lengthChange: false,
            columns: [
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'email', name: 'email'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
        });         
    }

    function initDtEvents() {
        $('#users-table').on('click', '.btn-delete', function (e) {
            e.preventDefault();
            let url = $(this).attr('href');
            Swal.fire({
                title: 'Are you sure?',
                text: "You want to delete this data?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        type: 'DELETE',
                        dataType: 'json',
                        data: {
                            _token: '{{ csrf_token() }}',
                        },
                        success: function (data) {
                            if (data.success) {
                                Swal.fire({
                                    title: 'Success!',
                                    text: data.message,
                                    icon: 'success',
                                    showCancelButton: false,
                                    confirmButtonText: 'Ok',
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        table.draw();
                                    }
                                });
                            } else {
                                Swal.fire({
                                    title: 'Error!',
                                    text: data.message,
                                    icon: 'error',
                                    showCancelButton: false,
                                    confirmButtonText: 'Ok',
                                });
                            }
                        },
                        error: function (xhr) {
                            Swal.fire({
                                title: 'Error!',
                                text: xhr.responseJSON.message,
                                icon: 'error',
                                showCancelButton: false,
                                confirmButtonText: 'Ok',
                            });
                        }
                    });
                }
            });
        });
    }

    // docuemnt on ready
    $(document).ready(function () {
        initDtTable();
        initDtEvents();

        const addCabinet = new TomSelect("#add-cabinet", {
            persist: false,
            createOnBlur: true,
            create: true
        });

        const addDepartment = new TomSelect("#add-department", {
            persist: false,
            createOnBlur: true,
            create: true
        });

        const addRole = new TomSelect("#add-role", {
            persist: false,
            createOnBlur: true,
            create: true
        });

        $('#form-add-users').parsley();
    });
</script>