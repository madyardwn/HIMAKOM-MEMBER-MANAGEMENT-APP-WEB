<script type="module">
    class Program {
        constructor() {
            // Subject & Empty Image
            this.emptyImage = "{{ asset(config('tablar.default.preview.path')) }}"
            this.subject = 'programs';

            // Modal
            this.modalAdd = new bootstrap.Modal($(`#modal-add-programs`));
            this.modalEdit = new bootstrap.Modal($(`#modal-edit-programs`));

            // Form
            this.formAdd = $(`#form-add-${this.subject}`);
            this.formEdit = $(`#form-edit-${this.subject}`);

            // Tom Select
            this.tomSelectAddLead = new TomSelect($('#add-lead'), {
                valueField: "id",
                labelField: "name",
                searchField: "name",
                placeholder: 'Select Lead',
                load: (query, callback) => {
                    if (!query.length) return callback();
                    $.ajax({
                        url: "{{ route('tom-select.users') }}",
                        type: "GET",
                        dataType: "json",
                        data: {
                            q: query,
                        },
                        error: function() {
                            callback();
                        },
                        success: function(res) {
                            callback(res);
                        },
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
                    },
                },
            });

            this.tomSelectEditLead = new TomSelect($('#edit-lead'), {
                valueField: "id",
                labelField: "name",
                searchField: "name",
                placeholder: 'Select Lead',
                load: (query, callback) => {
                    if (!query.length) return callback();
                    $.ajax({
                        url: "{{ route('tom-select.users') }}",
                        type: "GET",
                        dataType: "json",
                        data: {
                            q: query,
                        },
                        error: function() {
                            callback();
                        },
                        success: function(res) {
                            callback(res);
                        },
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
                    },
                },
            });

            this.tomSelectAddParticipants = new TomSelect($('#add-participants'), {
                valueField: "id",
                labelField: "name",
                searchField: "name",
                placeholder: 'Select Participants',
                plugins: ['remove_button'],
                load: (query, callback) => {
                    if (!query.length) return callback();
                    $.ajax({
                        url: "{{ route('tom-select.users') }}",
                        type: "GET",
                        dataType: "json",
                        data: {
                            q: query,
                        },
                        error: function() {
                            callback();
                        },
                        success: function(res) {
                            callback(res);
                        },
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
                    },
                },
            });

            this.tomSelectEditParticipants = new TomSelect($('#edit-participants'), {
                valueField: "id",
                labelField: "name",
                searchField: "name",
                placeholder: 'Select Participants',
                plugins: ['remove_button'],
                load: (query, callback) => {
                    if (!query.length) return callback();
                    $.ajax({
                        url: "{{ route('tom-select.users') }}",
                        type: "GET",
                        dataType: "json",
                        data: {
                            q: query,
                        },
                        error: function() {
                            callback();
                        },
                        success: function(res) {
                            callback(res);
                        },
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
                    },
                },
            });

            this.tomSelectAddDepartment = new TomSelect($('#add-department'), {
                placeholder: 'Select department',
            });

            this.tomSelectEditDepartment = new TomSelect($('#edit-department'), {
                placeholder: 'Select department',
            });

            // URL
            this.storeUrl = "{{ route('periodes.programs.store') }}";
            this.editUrl = "{{ route('periodes.programs.edit', ':id') }}";
            this.deleteUrl = "{{ route('periodes.programs.destroy', ':id') }}";
            this.updateUrl = "{{ route('periodes.programs.update', ':id') }}";

            // DataTable
            this.table = $('#table-programs');
            this.tableDataUrl = "{{ route('periodes.programs.index') }}";
            this.tableColumns = [{
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
                    width: '10%'
                },
                {
                    data: 'description',
                    name: 'description',
                    title: 'Description'
                },
                {
                    data: 'department.name',
                    name: 'department.name',
                    title: 'Department',
                    width: '20%'
                },
                {
                    data: 'lead.name',
                    name: 'lead.name',
                    title: 'Lead By',
                    width: '20%'
                },
                {
                    data: 'participants',
                    name: 'participants.name',
                    title: 'Participants',
                    orderable: false,
                    width: '10%',
                    render: function(data, type, row) {
                        let html = '';
                        data.forEach(function(item, index) {
                            html += `<span class="badge badge-outline text-blue m-1">${item.name}</span>`;
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
                        html = `
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                    Action
                                </button>
                                <ul class="dropdown-menu">                                    
                                    <li><a class="dropdown-item btn-edit" href="" data-id="${data.id}"><i class="ti ti-pencil"></i>&nbsp; Edit</a></li>
                                    <li><a class="dropdown-item btn-delete" href="" data-id="${data.id}"><i class="ti ti-trash"></i>&nbsp; Delete</a></li>
                                </ul>
                            </div>
                        `;
                        return html;
                    }
                },
            ];
        }

        initDtEvents() {
            $(`#modal-add-${this.subject}`).on("hidden.bs.modal", (e) => {
                $(".is-invalid").removeClass("is-invalid");
                $(".invalid-feedback").remove();

                this.formAdd[0].reset();
                this.tomSelectAddDepartment.clear();
                this.tomSelectAddLead.clear();
                this.tomSelectAddParticipants.clear();
            });

            $(`#modal-edit-${this.subject}`).on("hidden.bs.modal", (e) => {
                $(".is-invalid").removeClass("is-invalid");
                $(".invalid-feedback").remove();

                this.formEdit[0].reset();
                this.tomSelectEditDepartment.clear();
                this.tomSelectEditLead.clear();
                this.tomSelectEditParticipants.clear();
            });
        }

        initDtTable() {
            this.table.DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: this.tableDataUrl,
                columns: this.tableColumns,
                drawCallback: () => {
                    $('.btn-edit').on('click', (e) => {
                        e.preventDefault();

                        $(`#edit-id-${this.subject}`).val($(e.currentTarget).data("id"));

                        $.ajax({
                            url: this.editUrl.replace(":id", $(e.currentTarget).data("id")),
                            method: "GET",
                            success: (response) => {
                                $('#edit-name').val(response.data?.name);
                                $('#edit-description').val(response.data?.description);
                                this.tomSelectEditDepartment.setValue(response.data?.department?.id);
                                this.tomSelectEditLead.addOption(response.data?.lead);
                                this.tomSelectEditLead.setValue(response.data?.lead?.id);
                                this.tomSelectEditParticipants.addOption(response.data?.participants);
                                this.tomSelectEditParticipants.setValue(response.data?.participants.map((item) => item?.id));
                                this.modalEdit.show();
                            },
                            error: function(xhr, ajaxOptions, thrownError) {
                                Swal.fire("Error!", thrownError, "error");
                            },
                        });
                    });

                    $('.btn-delete').on('click', (e) => {
                        e.preventDefault();

                        const id = $(e.currentTarget).data("id");

                        Swal.fire({
                            title: "Are you sure?",
                            text: "You won't be able to revert this!",
                            icon: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#3085d6",
                            cancelButtonColor: "#d33",
                            confirmButtonText: "Yes, delete it!",
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $.ajax({
                                    url: this.deleteUrl.replace(":id", id),
                                    method: "DELETE",
                                    success: (response) => {
                                        if (response.status === "success") {
                                            Swal.fire({
                                                icon: "success",
                                                title: "Berhasil",
                                                text: response.message,
                                                showConfirmButton: false,
                                                timer: 1500,
                                            }).then(() => {
                                                this.table.DataTable().ajax.reload();

                                                $(`#card-${this.subject}`).before(`
                                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                        <strong>Success!</strong> ${response.message}
                                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                    </div>
                                                `);

                                                $(".alert").delay(3000).slideUp(300);
                                            });
                                        }
                                    },
                                    error: (xhr, ajaxOptions, thrownError) => {
                                        Swal.fire("Error!", thrownError, "error");

                                        $(`#card-${this.subject}`).before(`
                                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                <strong>Error!</strong> ${thrownError}
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
                                        `);

                                        $(".alert").delay(3000).slideUp(300);
                                    },
                                });
                            }
                        });
                    });
                }
            });
        }

        initDtSubmit() {
            $(`#submit-add-${this.subject}`).on("click", (e, item) => {
                e.preventDefault();

                $(".is-invalid").removeClass("is-invalid");
                $(".invalid-feedback").remove();
                $(`#submit-add-${this.subject}`).attr("disabled", true);
                $(`#submit-add-${this.subject}`).addClass("btn-loading");

                const formData = new FormData(this.formAdd[0]);

                $.ajax({
                    url: this.storeUrl,
                    method: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    complete: () => {
                        $(`#submit-add-${this.subject}`).attr("disabled", false);
                        $(`#submit-add-${this.subject}`).removeClass("btn-loading");
                    },
                    success: (response) => {
                        Swal.fire({
                            icon: "success",
                            title: "Berhasil",
                            text: response.message,
                            showConfirmButton: false,
                            timer: 1500,
                        }).then(() => {
                            this.modalAdd.hide();

                            this.table.DataTable().ajax.reload();

                            $(`#card-${this.subject}`).before(`
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <strong>Success!</strong> ${response.message}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            `);

                            $(".alert").delay(3000).slideUp(300);
                        });
                    },
                    error: (response) => {
                        if (response.status === 422) {
                            const errors = response.responseJSON.errors;
                            for (const key in errors) {
                                if (Object.hasOwnProperty.call(errors, key)) {
                                    const element = errors[key];
                                    $(`#add-${key}`).addClass("is-invalid");
                                    $(`#add-${key}`).after(`<div class="invalid-feedback">${element[0]}</div>`);
                                }
                            }
                        } else {
                            Swal.fire("Error!", "Something went wrong!", "error");
                        }
                    },
                });
            });

            $(`#submit-edit-${this.subject}`).on("click", (e, item) => {
                e.preventDefault();

                $(".is-invalid").removeClass("is-invalid");
                $(".invalid-feedback").remove();
                $(`#submit-edit-${this.subject}`).attr("disabled", true);
                $(`#submit-edit-${this.subject}`).addClass("btn-loading");

                const formData = new FormData(this.formEdit[0]);
                formData.append("_method", "PUT");

                $.ajax({
                    url: this.updateUrl.replace(":id", formData.get("id")),
                    method: "POST",
                    processData: false,
                    contentType: false,
                    data: formData,
                    complete: () => {
                        $(`#submit-edit-${this.subject}`).attr("disabled", false);
                        $(`#submit-edit-${this.subject}`).removeClass("btn-loading");
                    },
                    success: (response) => {
                        Swal.fire({
                            icon: "success",
                            title: "Berhasil",
                            text: response.message,
                            showConfirmButton: false,
                            timer: 1500,
                        }).then(() => {
                            this.modalEdit.hide();

                            this.table.DataTable().ajax.reload();


                            $(`#card-${this.subject}`).before(`
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <strong>Success!</strong> ${response.message}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                `);

                            $(".alert").delay(3000).slideUp(300);
                        });
                    },
                    error: (response) => {
                        if (response.status === 422) {
                            const errors = response.responseJSON.errors;
                            for (const key in errors) {
                                if (Object.hasOwnProperty.call(errors, key)) {
                                    const element = errors[key];
                                    $(`#edit-${key}`).addClass("is-invalid");
                                    $(`#edit-${key}`).after(`<div class="invalid-feedback">${element[0]}</div>`);
                                }
                            }
                        } else {
                            Swal.fire("Error!", "Something went wrong!", "error");
                        }
                    },
                });
            });
        }
    }

    $(document).ready(function() {
        const program = new Program();
        program.initDtEvents();
        program.initDtTable();
        program.initDtSubmit();
    });
</script>
