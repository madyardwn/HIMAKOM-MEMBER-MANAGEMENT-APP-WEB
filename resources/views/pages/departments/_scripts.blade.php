<script type="module">
    // Datatable Variables
    let table, editId;
    let tableId, tableDataUrl, tableColumns;
    let submitAddUrl, submitEditUrl;
    let editUrl, deleteUrl;
    let inputs = { add: [], edit: [], };
    let tomSelects = { add: [], edit: [], };
    let subject = 'departments'; // subject variable    
    
    editUrl = "{{ route('periodes.departments.edit', ':id') }}"; // url for edit data
    deleteUrl = "{{ route('periodes.departments.destroy', ':id') }}"; // url for delete data
    submitAddUrl = "{{ route('periodes.departments.store') }}"; // url for submit add
    submitEditUrl = "{{ route('periodes.departments.update', ':id') }}"; // url for submit edit
    tableDataUrl = "{{ route('periodes.departments.index') }}"; // url get datatable
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
            data: 'logo',
            name: 'logo',
            title: 'Logo',
            orderable: false,
            searchable: false,
            responsivePriority: 2,
            width: '10%',
            render: function(data, type, row) {
                return `<img src="${data}" alt="Logo" class="img-fluid" width="100">`;
            }
        },
        { data: 'name', name: 'name', title: 'Name', responsivePriority: 3, width: '10%' },
        { data: 'short_name', name: 'short_name', title: 'Short Name', responsivePriority: 1, width: '10%' },
        { data: 'description', name: 'description', title: 'Description' },
        {
            data: 'is_active',
            name: 'is_active',
            title: 'Status',
            width: '5%',
            render: function(data, type, row) {
                return data == 1 ? `<span class="badge bg-blue-lt">Active</span>` : `<span class="badge bg-red-lt">Inactive</span>`;
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
                html = `
                    <div class="btn-group">
                        <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            Action
                        </button>
                        <ul class="dropdown-menu">                                    
                            <li><a class="dropdown-item btn-edit" href="" data-id="${data.id}" data-bs-toggle="modal" data-bs-target="#modal-edit-${subject}"><i class="ti ti-pencil"></i>&nbsp; Edit</a></li>
                            <li><a class="dropdown-item btn-delete" href="" data-id="${data.id}"><i class="ti ti-trash"></i>&nbsp; Delete</a></li>
                        </ul>
                    </div>
                `;
                return html;
            }
        },
    ];


    // init datatable
    function initDtTable() {
        table = new DataTable(`#table-${subject}`, {
            processing: true,
            responsive: true,
            serverSide: true,
            ajax: tableDataUrl,
            columns: tableColumns,
        });
    }    
    
    // get all input, tom select, and textarea
    function initInputs() {
        $('input, textarea, select', `#form-add-${subject}`).each(function() {
            inputs.add.push({
                name: $(this).attr('name'),
                element: $(this),
                value: $(this).val(),
            });

            if ($(this).is('select')) {
                tomSelects.add.push({
                    name: $(this).attr('name'),
                    element: $(this),
                    url: $(this).attr('data-url'),
                    variable: null,
                });
            } else if ($(this).is('input[type="file"]')) {
                $(this).on('change', function() {
                    const file = $(this)[0].files[0] // get file
                    const name = $(this)[0].name // name of input file
                    const reader = new FileReader() // create reader

                    reader.onload = function(e) {
                        // set image source to preview image name
                        $(`#preview-add-${name}`).attr('src', e.target.result)
                    }
                    reader.readAsDataURL(file)
                });
            }
        });

        $('input, textarea, select', `#form-edit-${subject}`).each(function() {
            inputs.edit.push({
                name: $(this).attr('name'),
                element: $(this),
                value: $(this).val(),
            });

            if ($(this).is('select')) {
                tomSelects.edit.push({
                    element: $(this),
                    url: $(this).attr('data-url'),
                    variable: null,
                    name: $(this).attr('name'),
                });
            }else if ($(this).is('input[type="file"]')) {
                $(this).on('change', function() {
                    const file = $(this)[0].files[0] // get file
                    const name = $(this)[0].name // name of input file
                    const reader = new FileReader() // create reader

                    reader.onload = function(e) {
                        // set image source to preview image name
                        $(`#preview-edit-${name}`).attr('src', e.target.result)
                    }
                    reader.readAsDataURL(file)
                });
            }
        });
    }

    // button events
    function initEvents() {
        tomSelects.add.forEach(function(item, index) {
            item.variable = new TomSelect(item.element, {
                valueField: 'id',
                labelField: 'name',
                searchField: 'name',
                placeholder: `Select ${item.name}`,
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
                placeholder: `Select ${item.name}`,
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

        
        $(`#modal-add-${subject}`).on('hidden.bs.modal', function(e) {
            $('.is-invalid').removeClass('is-invalid');
            $('.invalid-feedback').remove();

            // restore preview image
            $(`#form-add-${subject} input[type="file"]`).each(function() {
                $(`#preview-add-${$(this).attr('name')}`).attr('src', '{{ asset(config('tablar.default.preview.path')) }}');
            });
            $(`#form-add-${subject}`)[0].reset(); // reset form
            tomSelects.add.forEach(function(item, index) { // clear tom select
                item.variable.clear();
            });
        });

        $(`#modal-edit-${subject}`).on('hidden.bs.modal', function(e) {
            $('.is-invalid').removeClass('is-invalid');
            $('.invalid-feedback').remove();

            $(`#form-edit-${subject} input[type="file"]`).each(function() { // restore preview image
                $(`#preview-edit-${$(this).attr('name')}`).attr('src', '{{ asset(config('tablar.default.preview.path')) }}');
            });
            $(`#form-edit-${subject}`)[0].reset(); // reset form
            tomSelects.edit.forEach(function(item, index) { // clear tom select
                item.variable.clear();
            });
        });

        table.on('click', '.btn-edit', function(e) {
            e.preventDefault();
            
            $(`#form-edit-${subject} input[name="id"]`).val($(this).attr('data-id'));
            
            $.ajax({
                url: editUrl.replace(':id', $(this).attr('data-id')),
                method: 'GET',
                success: function(response) {
                    if (response.status === 'success') {
                        inputs.edit.forEach(function(item, index) {
                            handleInputTypeEdit(item, response);
                        });
                        tomSelects.edit.forEach(function(item, index) {
                            handleTomSelectTypeEdit(item, response);
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

                                    $(`#card-${subject}`).before(`
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

                            $(`#card-${subject}`).before(`
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

    function initSubmit() {        
        $(`#submit-add-${subject}`).on('click', function(e) {
            e.preventDefault();

            $('.is-invalid').removeClass('is-invalid');
            $('.invalid-feedback').remove();
            $(`#submit-add-${subject}`).attr('disabled', true);
            $(`#submit-add-${subject}`).addClass('btn-loading');

            const formData = new FormData(); // Membuat objek FormData

            inputs.add.forEach(function(item, index) {
                handleInputType(item, formData)
            });
                    
            tomSelects.add.forEach(function(item, index) {
                handleTomSelectType(item, formData);
            });

            $.ajax({
                url: submitAddUrl,
                method: 'POST',
                data: formData, // Menggunakan objek FormData sebagai data
                contentType: false, // Mengatur contentType ke false
                processData: false, // Mengatur processData ke false
                success: function(response) {
                    $(`#submit-add-${subject}`).attr('disabled', false);
                    $(`#submit-add-${subject}`).removeClass('btn-loading');
                    if (response.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message,
                            showConfirmButton: false,
                            timer: 1500
                        })
                        .then(() => {
                            $(`#modal-add-${subject}`).attr('data-bs-dismiss', 'modal').trigger('click');
                            $(`#modal-add-${subject}`).removeAttr('data-bs-dismiss');

                            // Reload Datatable
                            table.draw();

                            // Show Alert
                            $(`#card-${subject}`).before(`
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
                    $(`#submit-add-${subject}`).attr('disabled', false);
                    $(`#submit-add-${subject}`).removeClass('btn-loading');
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

        $(`#submit-edit-${subject}`).on('click', function(e) {
            e.preventDefault();

            $('.is-invalid').removeClass('is-invalid');
            $('.invalid-feedback').remove();
            $(`#submit-edit-${subject}`).attr('disabled', true);
            $(`#submit-edit-${subject}`).addClass('btn-loading');

            const formData = new FormData();
            formData.append('_method', 'PUT'); // Method PUT with FormData defined in Here
            inputs.edit.forEach(function(item, index) {
                handleInputType(item, formData);
            });

            tomSelects.edit.forEach(function(item, index) {
                handleTomSelectType(item, formData);
            });

            $.ajax({
                url: submitEditUrl.replace(':id', formData.get('id')),
                method: 'POST', // With FormData we can't use PUT method in here
                processData: false, // Prevent jQuery from processing the data
                contentType: false, // Prevent jQuery from setting the content type
                data: formData,
                success: function(response) {
                    $(`#submit-edit-${subject}`).attr('disabled', false);
                    $(`#submit-edit-${subject}`).removeClass('btn-loading');
                    if (response.status === 'success') {
                        Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message,
                                showConfirmButton: false,
                                timer: 1500
                            })
                            .then(() => {
                                $(`#modal-edit-${subject}`).attr('data-bs-dismiss', 'modal').trigger('click');
                                $(`#modal-edit-${subject}`).removeAttr('data-bs-dismiss');

                                // Reload Datatable
                                table.draw();

                                // Show Alert
                                $(`#card-${subject}`).before(`
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
                    $(`#submit-edit-${subject}`).attr('disabled', false);
                    $(`#submit-edit-${subject}`).removeClass('btn-loading');
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

    function handleInputType(item, formData) {
        switch (item.element.prop('type')) {
            case 'file':
                formData.append(item.name, $(item.element)[0].files[0]);
                break;
            case 'checkbox':
            case 'radio':
                formData.append(item.name, $(item.element).prop('checked') ? 1 : 0);
                break;
            default: // text, textarea, select, etc
                formData.append(item.name, $(item.element).val());
                break;
        }
    }

    function handleInputTypeEdit(item, response) {
        switch (item.element.prop('type')) {            
            case 'file':
                const file = response.data[item.name] ? response.data[item.name] : `{{ asset(config('tablar.default.preview.path')) }}`;                
                $(`#preview-edit-${item.name}`).attr('src', file);
                break;
            case 'checkbox':
            case 'radio':
                $(item.element).prop('checked', response.data[item.name]);
                break;
            default: // text, textarea, select, etc
                $(item.element).val(response.data[item.name]);
                break;
        }
    }

    function handleTomSelectType(item, formData) {
        const values = item.variable.getValue();
        if (typeof values === 'string') { // single select
            formData.append(item.name, parseInt(values));
        } else if (values.length >= 1) { // multiple select
            const itemName = item.name.concat('[]');
            values.forEach(function(value, index) { 
                formData.append(itemName, value);
            });
        }
    }

    function handleTomSelectTypeEdit(item, response) {
        if (Array.isArray(response.data[item.name])) { // multiple select
            item.variable.addOption(response.data[item.name]);
            item.variable.setValue(response.data[item.name].map(function(item) {
                return item.id;
            }));
        } else { // single select
            item.variable.addOption(response.data[item.name]);
            item.variable.setValue(response.data[item.name].id);
        }
    }

    // docuemnt on ready
    $(document).ready(function() {
        initDtTable();
        initInputs();
        initEvents();
        initSubmit();
    });
</script>