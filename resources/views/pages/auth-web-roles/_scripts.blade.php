<script type="module">
    // Datatable Variables
    let table
    let tableId, tableDataUrl, tableColumns;
    tableId = '#auth-web-roles-table'; // id tabel for datatable
    tableDataUrl = "{{ route('auth-web.roles.index') }}"; // url get datatable
    tableColumns = [{ // datatable columns configuration
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
    ];

    // Events Variables
    let modalAdd, modalEdit;
    let formAdd, formEdit;
    let inputs, tomSelects;
    let editUrl;
    let deleteUrl;
    modalAdd = '#modal-add-roles'; // id modal add
    modalEdit = '#modal-edit-roles'; // id modal edit
    formAdd = '#form-add-roles'; // id form add, for reset form
    formEdit = '#form-edit-roles'; // id form edit, for reset form
    tomSelects = { // tom select configuration for add and edit with ajax search
        add: [{
                element: '#add-permissions',
                url: "{{ route('tom-select.permissions') }}",
                variable: null,
                name: 'permissions',
        }],
        edit: [{
                element: '#edit-permissions',
                url: "{{ route('tom-select.permissions') }}",
                variable: null,
                name: 'permissions',
        }]
    }
    inputs = { // input configuration for add and edit, standard input: text, number, textarea, select, checkbox, radio
        add: [{ // add have many input
            element: '#add-name',
            type: 'text',
            name: 'name',
            variable: '',
        }],
        edit: [{ // edit have many input
            element: '#edit-name',
            type: 'text',
            name: 'name',
            variable: '',
        }]
    };
    editUrl = "{{ route('auth-web.roles.edit', ':id') }}"; // url for edit data
    deleteUrl = "{{ route('auth-web.roles.destroy', ':id') }}"; // url for delete data

    // Submit Variables
    let submitAdd, submitEdit;
    let submitAddUrl, submitEditUrl;
    submitAdd = '#submit-add-roles'; // id submit add
    submitEdit = '#submit-edit-roles'; // id submit edit
    submitAddUrl = "{{ route('auth-web.roles.store') }}"; // url for submit add
    submitEditUrl = "{{ route('auth-web.roles.update', ':id') }}"; // url for submit edit
    
    function initDtTable() {
        table = new DataTable(tableId, {
            processing: true,
            responsive: true,
            serverSide: true,
            ajax: tableDataUrl,
            columns: tableColumns,
        });
    }    

    function initDtEvents() {
        tomSelects.add.forEach(function(item, index) {
            item.variable = new TomSelect(item.element, {
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
                        url: item.url,
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
        });

        tomSelects.edit.forEach(function(item, index) {
            item.variable = new TomSelect(item.element, {
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
                        url: item.url,
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
        });

        
        $(modalAdd).on('hidden.bs.modal', function(e) {
            $('.is-invalid').removeClass('is-invalid');
            $('.invalid-feedback').remove();

            $(formAdd)[0].reset();
            tomSelects.add.forEach(function(item, index) {
                item.variable.clear();
            });
        });

        $(modalEdit).on('hidden.bs.modal', function(e) {
            $('.is-invalid').removeClass('is-invalid');
            $('.invalid-feedback').remove();

            $(formEdit)[0].reset();
            tomSelects.edit.forEach(function(item, index) {
                item.variable.clear();
            });
        });

        table.on('click', '.btn-edit', function(e) {
            e.preventDefault();

            $('#edit-id').val($(this).data('id'));

            $.ajax({
                url: editUrl.replace(':id', $('#edit-id').val()),
                method: 'GET',
                success: function(response) {
                    if (response.status === 'success') {
                        inputs.edit.forEach(function(item, index) {
                            // $(item.element).val(response.data[item.name]);
                            switch (item.type) {
                                case 'text':
                                    $(item.element).val(response.data[item.name]);
                                    break;
                                case 'checkbox':
                                    $(item.element).prop('checked', response.data[item.name]);
                                    break;
                                case 'radio':
                                    $(item.element).prop('checked', response.data[item.name]);
                                    break;
                                default:
                                    $(item.element).val(response.data[item.name]);
                                    break;
                            }
                        });
                        tomSelects.edit.forEach(function(item, index) {
                            item.variable.addOption(response.data[item.name]);
                            item.variable.setValue(response.data[item.name].map(function(item) {
                                return item.id;
                            }));
                        });
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
                        url: deleteUrl.replace(':id', id),
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
        $(submitAdd).on('click', function(e) {
            e.preventDefault();

            $('.is-invalid').removeClass('is-invalid');
            $('.invalid-feedback').remove();
            $(submitAdd).attr('disabled', true);
            $(submitAdd).addClass('btn-loading');

            const data = {};

            inputs.add.forEach(function(item, index) {
                switch (item.type) {
                    case 'text':
                        data[item.name] = $(item.element).val();
                        break;
                    case 'checkbox':
                        data[item.name] = $(item.element).prop('checked');
                        break;
                    case 'radio':
                        data[item.name] = $(item.element).prop('checked');
                        break;
                    default:
                        data[item.name] = $(item.element).val();
                        break;
                }
            });

            tomSelects.add.forEach(function(item, index) {
                data[item.name] = item.variable.getValue();
            });

            $.ajax({
                url: submitAddUrl,
                method: 'POST',
                data: data,
                success: function(response) {
                    $(submitAdd).attr('disabled', false);
                    $(submitAdd).removeClass('btn-loading');
                    if (response.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message,
                            showConfirmButton: false,
                            timer: 1500
                        })
                        .then(() => {
                            $(modalAdd).attr('data-bs-dismiss', 'modal').trigger('click');
                            $(modalAdd).removeAttr('data-bs-dismiss');

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
                    $(submitAdd).attr('disabled', false);
                    $(submitAdd).removeClass('btn-loading');
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

        $(submitEdit).on('click', function(e) {
            e.preventDefault();

            $('.is-invalid').removeClass('is-invalid');
            $('.invalid-feedback').remove();
            $(submitEdit).attr('disabled', true);
            $(submitEdit).addClass('btn-loading');

            const id = $('#edit-id').val();

            const data = {};

            inputs.edit.forEach(function(item, index) {
                switch (item.type) {
                    case 'text':
                        data[item.name] = $(item.element).val();
                        break;
                    case 'checkbox':
                        data[item.name] = $(item.element).prop('checked');
                        break;
                    case 'radio':
                        data[item.name] = $(item.element).prop('checked');
                        break;
                    default:
                        data[item.name] = $(item.element).val();
                        break;
                }
            });

            tomSelects.edit.forEach(function(item, index) {
                data[item.name] = item.variable.getValue();
            });

            $.ajax({
                url: submitEditUrl.replace(':id', id),
                method: 'PUT',
                data: data,
                success: function(response) {
                    $(submitEdit).attr('disabled', false);
                    $(submitEdit).removeClass('btn-loading');
                    if (response.status === 'success') {
                        Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message,
                                showConfirmButton: false,
                                timer: 1500
                            })
                            .then(() => {
                                $(modalEdit).attr('data-bs-dismiss', 'modal').trigger('click');
                                $(modalEdit).removeAttr('data-bs-dismiss');

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
                    $(submitEdit).attr('disabled', false);
                    $(submitEdit).removeClass('btn-loading');
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
