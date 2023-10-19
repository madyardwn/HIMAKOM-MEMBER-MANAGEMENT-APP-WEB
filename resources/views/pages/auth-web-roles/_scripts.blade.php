<script type="module">
    // DataTable, Modal, Form
    let table, formAdd, formEdit;

    // tomSelect
    let addPermissions, editPermissions;

    function initDtTable() {
        table = new DataTable('#auth-web-roles-table', {
            processing: true,
            responsive: true,
            serverSide: true,
            ajax: "{{ route('auth-web.roles.index') }}",
            columns: [{
                    title: 'No',
                    data: null,
                    orderable: false,
                    searchable: false,
                    responsivePriority: 1,
                    width: '1%',
                    className: 'dt-center',
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: 'name',
                    name: 'name',
                    title: 'Name',
                    responsivePriority: 1,
                    width: '20%'
                },
                {
                    data: 'permissions',
                    name: 'permissions.name',
                    title: 'Permissions',
                    orderable: false,
                    render: function(data, type, row) {
                        let html = '';
                        data.forEach(function(item, index) {
                            html +=`<span class="badge badge-outline text-blue m-1">${item.name}</span>`;
                        });
                        return html;
                    }
                },
                {
                    data: null,
                    title: 'Action',
                    orderable: false,
                    searchable: false,
                    responsivePriority: 1,
                    width: '1%',
                    render: function(data, type, row) {
                        let html = '';
                        if (data.id != 1) {
                            html = `
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                        Action
                                    </button>
                                    <ul class="dropdown-menu">                                    
                                        <li><a class="dropdown-item btn-edit" href="" data-id="${data.id}" data-bs-toggle="modal" data-bs-target="#modal-edit-roles"><i class="ti ti-pencil"></i>&nbsp; Edit</a></li>
                                        <li><a class="dropdown-item btn-delete" href="" data-id="${data.id}"><i class="ti ti-trash"></i>&nbsp; Delete</a></li>
                                    </ul>
                                </div>
                            `;
                        }
                        return html;
                    }
                },
            ],
        });
    }

    function initDtEvents() {
        addPermissions = new TomSelect("#add-permissions", {
            valueField: 'id',
            labelField: 'name',
            searchField: 'name',
            placeholder: 'Select permissions',
            plugins: {
                remove_button: {
                    title: 'Remove this item',
                }
            },
            load: function(query, callback) {
                if (!query.length) return callback();
                $.ajax({
                    url: "{{ route('tom-select.permissions') }}",
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        q: query,
                    },
                    error: function() {
                        callback();
                    },
                    success: function(res) {
                        callback(res);
                    }
                });
            },
            render: {
                option: function(item, escape) {
                    return `<div>
                                <span class="title">${escape(item.name)}</span>
                            </div>`;
                },
                item: function(item, escape) {                    
                    return `<div>
                                ${escape(item.name)}
                            </div>`;
                }
            },
        });

        editPermissions = new TomSelect("#edit-permissions", {
            valueField: 'id',
            labelField: 'name',
            searchField: 'name',
            placeholder: 'Select permissions',
            plugins: {
                remove_button: {
                    title: 'Remove this item',
                }
            },
            load: function(query, callback) {
                if (!query.length) return callback();
                $.ajax({
                    url: "{{ route('tom-select.permissions') }}",
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        q: query,
                    },
                    error: function() {
                        callback();
                    },
                    success: function(res) {
                        callback(res);
                    }
                });
            },
            render: {
                option: function(item, escape) {                    
                    return `<div>
                                <span class="title">${escape(item.name)}</span>
                            </div>`;
                },
                item: function(item, escape) {                    
                    return `<div>
                                ${escape(item.name)}
                            </div>`;
                }
            },
        });

        $('#modal-add-roles').on('hidden.bs.modal', function(e) {
            $('.is-invalid').removeClass('is-invalid');
            $('.invalid-feedback').remove();

            $('#add-name').val('');
            $('#add-permissions').val('');
            addPermissions.clear();
        });

        $('#modal-edit-roles').on('hidden.bs.modal', function(e) {
            $('.is-invalid').removeClass('is-invalid');
            $('.invalid-feedback').remove();

            $('#edit-name').val('');
            $('#edit-permissions').val('');
            editPermissions.clear();
        });

        table.on('click', '.btn-edit', function(e) {
            e.preventDefault();

            const id = $(this).data('id');

            $('#edit-id').val(id);

            $.ajax({
                url: "{{ route('auth-web.roles.edit', ['role' => 'id']) }}".replace('id', id),
                method: 'GET',
                success: function(response) {
                    if (response.status === 'success') {
                        $('#edit-name').val(response.data.name);
                        editPermissions.addOption(response.data.permissions);
                        editPermissions.setValue(response.data.permissions.map(function(item) {
                            return item.id;
                        }));
                    } else {
                        Swal.fire(
                            'Error!',
                            response.message,
                            'error'
                        );
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    Swal.fire(
                        'Error!',
                        thrownError,
                        'error'
                    );
                }
            });
        });

        table.on('click', '.btn-delete', function(e) {
            e.preventDefault();
            
            const id = $(this).data('id');

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('auth-web.roles.destroy', ['role' => 'id']) }}".replace('id', id),
                        method: 'DELETE',
                        success: function(response) {
                            if (response.status === 'success') {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.message,
                                    showConfirmButton: false,
                                    timer: 1500
                                })
                                .then(() => {
                                    table.draw();
                                    $('.card').before(`
                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong>Success!</strong> ${response.message}
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                    `);

                                    $('.alert').delay(3000).slideUp(300);
                                });
                            }
                        },
                        error: function(xhr, ajaxOptions, thrownError) {
                            Swal.fire(
                                'Error!',
                                thrownError,
                                'error'
                            );

                            $('.card').before(`
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong>Error!</strong> ${thrownError}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            `);

                            $('.alert').delay(3000).slideUp(300);
                        }
                    });
                }
            });
        });
    }

    function initDtSubmit() {
        $('#submit-add-role').on('click', function(e) {
            e.preventDefault();

            $('.is-invalid').removeClass('is-invalid');
            $('.invalid-feedback').remove();
            $('#submit-add-role').attr('disabled', true);
            $('#submit-add-role').addClass('btn-loading');

            const name = $('#add-name').val();
            const permissions = $('#add-permissions').val();

            $.ajax({
                url: "{{ route('auth-web.roles.store') }}",
                method: 'POST',
                data: {
                    name: name,
                    permissions: permissions,
                },
                success: function(response) {
                    $('#submit-add-role').attr('disabled', false);
                    $('#submit-add-role').removeClass('btn-loading');
                    if (response.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message,
                            showConfirmButton: false,
                            timer: 1500
                        })
                        .then(() => {
                            $('#modal-add-roles').attr('data-bs-dismiss', 'modal').trigger('click');
                            $('#modal-add-roles').removeAttr('data-bs-dismiss');

                            // Reload Datatable
                            table.draw();

                            // Show Alert
                            $('.card').before(`
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <strong>Success!</strong> ${response.message}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            `);

                            $('.alert').delay(3000).slideUp(300);
                        })
                    } else {
                        Swal.fire(
                            'Error!',
                            response.message,
                            'error'
                        );
                    }
                },
                error: function(response) {
                    $('#submit-add-role').attr('disabled', false);
                    $('#submit-add-role').removeClass('btn-loading');
                    if (response.status === 422) {
                        const errors = response.responseJSON.errors;
                        for (const key in errors) {
                            if (Object.hasOwnProperty.call(errors, key)) {
                                const element = errors[key];
                                $(`#add-${key}`).addClass('is-invalid');
                                $(`#add-${key}`).after(`<div class="invalid-feedback">${element[0]}</div>`);
                            }
                        }
                    } else {
                        Swal.fire(
                            'Error!',
                            'Something went wrong!',
                            'error'
                        );
                    }
                }
            });
        });

        $('#submit-edit-role').on('click', function(e) {
            e.preventDefault();

            $('.is-invalid').removeClass('is-invalid');
            $('.invalid-feedback').remove();
            $('#submit-edit-role').attr('disabled', true);
            $('#submit-edit-role').addClass('btn-loading');

            const id = $('#edit-id').val();
            const name = $('#edit-name').val();
            const permissions = $('#edit-permissions').val();

            $.ajax({
                url: "{{ route('auth-web.roles.update', ['role' => 'id']) }}".replace('id', id),
                method: 'PUT',
                data: {
                    name: name,
                    permissions: permissions,
                },
                success: function(response) {
                    $('#submit-edit-role').attr('disabled', false);
                    $('#submit-edit-role').removeClass('btn-loading');
                    if (response.status === 'success') {
                        Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message,
                                showConfirmButton: false,
                                timer: 1500
                            })
                            .then(() => {
                                $('#modal-edit-roles').attr('data-bs-dismiss', 'modal').trigger('click');
                                $('#modal-edit-roles').removeAttr('data-bs-dismiss');

                                // Reload Datatable
                                table.draw();

                                // Show Alert
                                $('.card').before(`
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <strong>Success!</strong> ${response.message}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                `);

                                $('.alert').delay(3000).slideUp(300);
                            })
                    } else {
                        Swal.fire(
                            'Error!',
                            response.message,
                            'error'
                        );
                    }
                },
                error: function(response) {
                    $('#submit-edit-role').attr('disabled', false);
                    $('#submit-edit-role').removeClass('btn-loading');
                    if (response.status === 422) {
                        const errors = response.responseJSON.errors;
                        for (const key in errors) {
                            if (Object.hasOwnProperty.call(errors, key)) {
                                const element = errors[key];
                                $(`#edit-${key}`).addClass('is-invalid');
                                $(`#edit-${key}`).after(`<div class="invalid-feedback">${element[0]}</div>`);
                            }
                        }
                    } else {
                        Swal.fire(
                            'Error!',
                            'Something went wrong!',
                            'error'
                        );
                    }
                }
            });
        });
    }

    // docuemnt on ready
    $(document).ready(function() {
        initDtTable();
        initDtEvents();
        initDtSubmit();
    });
</script>
