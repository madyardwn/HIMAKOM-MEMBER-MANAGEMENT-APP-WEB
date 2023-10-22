class TemplateCRUD {
    constructor({ subject, columns, editUrl, deleteUrl, submitAddUrl, submitEditUrl, tableDataUrl, emptyImage }) {
        this.table = null;
        this.inputs = { add: [], edit: [] };
        this.tomSelects = { add: [], edit: [] };
        this.subject = subject;
        this.columns = columns;
        this.editUrl = editUrl;
        this.deleteUrl = deleteUrl;
        this.submitAddUrl = submitAddUrl;
        this.submitEditUrl = submitEditUrl;
        this.tableDataUrl = tableDataUrl;
        this.emptyImage = emptyImage;
    }

    init() {
        this.initDtTable();
        this.initInputs();
        this.initEvents();
        this.initSubmit();
    }

    // init datatable
    initDtTable() {
        const self = this;
        this.table = new DataTable(`#table-${this.subject}`, {
            processing: true,
            responsive: true,
            serverSide: true,
            ajax: self.tableDataUrl,
            columns: self.columns,
        });
    }    
    
    // get all input, tom select, and textarea
    initInputs() {
        const self = this;
        $('input, textarea, select', `#form-add-${this.subject}`).each(function() {
            self.inputs.add.push({
                name: $(this).attr('name'),
                element: $(this),
                value: $(this).val(),
            });

            if ($(this).is('select')) {
                self.tomSelects.add.push({
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

        $('input, textarea, select', `#form-edit-${this.subject}`).each(function() {
            self.inputs.edit.push({
                name: $(this).attr('name'),
                element: $(this),
                value: $(this).val(),
                variable: null,
            });

            if ($(this).is('select')) {
                self.tomSelects.edit.push({
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
    initEvents() {
        const self = this;
        this.tomSelects.add.forEach(function(item, index) {
            const options = item.element.find('option');
            if (options.length) {
                item.variable = new TomSelect(item.element, {
                    valueField: 'id',
                    labelField: 'name',
                    searchField: 'name',
                    placeholder: `Select ${item.name}`,
                    options: options.map(function() {
                        return {
                            id: $(this).val(),
                            name: $(this).text(),
                        }
                    }),
                    plugins: {
                        remove_button: {
                            title: 'Remove this item',
                        }
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
            }else {
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
            }
        });

        this.tomSelects.edit.forEach(function(item, index) {
            const options = item.element.find('option');
            if (options.length) {
                item.variable = new TomSelect(item.element, {
                    valueField: 'id',
                    labelField: 'name',
                    searchField: 'name',
                    placeholder: `Select ${item.name}`,
                    options: options.map(function() {
                        return {
                            id: $(this).val(),
                            name: $(this).text(),
                        }
                    }),
                    plugins: {
                        remove_button: {
                            title: 'Remove this item',
                        }
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
            }else {
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
            }
        });

        
        $(`#modal-add-${self.subject}`).on('hidden.bs.modal', function(e) {
            $('.is-invalid').removeClass('is-invalid');
            $('.invalid-feedback').remove();

            // restore preview image
            $(`#form-add-${self.subject} input[type="file"]`).each(function() {
                $(`#preview-add-${$(this).attr('name')}`).attr('src', self.emptyImage);
            });
            $(`#form-add-${self.subject}`)[0].reset(); // reset form
            self.tomSelects.add.forEach(function(item, index) { // clear tom select
                item.variable.clear();
            });
        });

        $(`#modal-edit-${self.subject}`).on('hidden.bs.modal', function(e) {
            $('.is-invalid').removeClass('is-invalid');
            $('.invalid-feedback').remove();

            $(`#form-edit-${self.subject} input[type="file"]`).each(function() { // restore preview image
                $(`#preview-edit-${$(this).attr('name')}`).attr('src', self.emptyImage);
            });
            $(`#form-edit-${self.subject}`)[0].reset(); // reset form
            self.tomSelects.edit.forEach(function(item, index) { // clear tom select
                item.variable.clear();
            });
        });

        self.table.on('click', '.btn-edit', function(e) {
            e.preventDefault();
            
            $(`#form-edit-${self.subject} input[name="id"]`).val($(this).attr('data-id'));
            
            $.ajax({
                url: self.editUrl.replace(':id', $(this).attr('data-id')),
                method: 'GET',
                success: function(response) {
                    if (response.status === 'success') {
                        self.inputs.edit.forEach(function(item, index) {
                            self.handleInputTypeEdit(item, response);
                        });
                        self.tomSelects.edit.forEach(function(item, index) {
                            self.handleTomSelectTypeEdit(item, response);
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

        self.table.on('click', '.btn-delete', function(e) {
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
                        url: self.deleteUrl.replace(':id', id),
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
                                    
                                    self.table.draw();

                                    $(`#card-${self.subject}`).before(`
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

                            $(`#card-${self.subject}`).before(`
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

    initSubmit() {        
        const self = this;
        $(`#submit-add-${this.subject}`).on('click', function(e) {
            e.preventDefault();

            $('.is-invalid').removeClass('is-invalid');
            $('.invalid-feedback').remove();
            $(`#submit-add-${self.subject}`).attr('disabled', true);
            $(`#submit-add-${self.subject}`).addClass('btn-loading');

            const formData = new FormData(); // Membuat objek FormData

            self.inputs.add.forEach(function(item, index) {
                self.handleInputType(item, formData)
            });
                    
            self.tomSelects.add.forEach(function(item, index) {
                self.handleTomSelectType(item, formData);
            });

            $.ajax({
                url: self.submitAddUrl,
                method: 'POST',
                data: formData, // Menggunakan objek FormData sebagai data
                contentType: false, // Mengatur contentType ke false
                processData: false, // Mengatur processData ke false
                success: function(response) {
                    $(`#submit-add-${self.subject}`).attr('disabled', false);
                    $(`#submit-add-${self.subject}`).removeClass('btn-loading');
                    if (response.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message,
                            showConfirmButton: false,
                            timer: 1500
                        })
                        .then(() => {
                            $(`#modal-add-${self.subject}`).attr('data-bs-dismiss', 'modal').trigger('click');
                            $(`#modal-add-${self.subject}`).removeAttr('data-bs-dismiss');

                            // Reload Datatable
                            self.table.draw();

                            // Show Alert
                            $(`#card-${self.subject}`).before(`
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
                    $(`#submit-add-${self.subject}`).attr('disabled', false);
                    $(`#submit-add-${self.subject}`).removeClass('btn-loading');
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

        $(`#submit-edit-${this.subject}`).on('click', function(e) {
            e.preventDefault();

            $('.is-invalid').removeClass('is-invalid');
            $('.invalid-feedback').remove();
            $(`#submit-edit-${self.subject}`).attr('disabled', true);
            $(`#submit-edit-${self.subject}`).addClass('btn-loading');

            const formData = new FormData();
            formData.append('_method', 'PUT'); // Method PUT with FormData defined in Here
            self.inputs.edit.forEach(function(item, index) {
                self.handleInputType(item, formData);
            });

            self.tomSelects.edit.forEach(function(item, index) {
                self.handleTomSelectType(item, formData);
            });

            $.ajax({
                url: self.submitEditUrl.replace(':id', formData.get('id')),
                method: 'POST', // With FormData we can't use PUT method in here
                processData: false, // Prevent jQuery from processing the data
                contentType: false, // Prevent jQuery from setting the content type
                data: formData,
                success: function(response) {
                    $(`#submit-edit-${self.subject}`).attr('disabled', false);
                    $(`#submit-edit-${self.subject}`).removeClass('btn-loading');
                    if (response.status === 'success') {
                        Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message,
                                showConfirmButton: false,
                                timer: 1500
                            })
                            .then(() => {
                                $(`#modal-edit-${self.subject}`).attr('data-bs-dismiss', 'modal').trigger('click');
                                $(`#modal-edit-${self.subject}`).removeAttr('data-bs-dismiss');

                                // Reload Datatable
                                self.table.draw();

                                // Show Alert
                                $(`#card-${self.subject}`).before(`
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
                    $(`#submit-edit-${self.subject}`).attr('disabled', false);
                    $(`#submit-edit-${self.subject}`).removeClass('btn-loading');
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



    handleInputType(item, formData) {
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

    handleInputTypeEdit(item, response) {
        switch (item.element.prop('type')) {            
            case 'file':
                const file = response.data[item.name] ? response.data[item.name] : this.emptyImage;
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


    
    handleTomSelectType(item, formData) {
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

    handleTomSelectTypeEdit(item, response) {
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
}

export default TemplateCRUD;