class TemplateCRUD {
    constructor({ subject, columns, editUrl, deleteUrl, submitAddUrl, submitEditUrl, tableDataUrl, emptyImage, tomSelects }) {
        this.table = null;
        this.inputs = { add: [], edit: [] };
        this.tomSelectsInputs = { add: [], edit: [] };
        this.modalAdd = new bootstrap.Modal(document.getElementById(`modal-add-${subject}`));
        this.modalEdit = new bootstrap.Modal(document.getElementById(`modal-edit-${subject}`));
        this.subject = subject;
        this.columns = columns;
        this.editUrl = editUrl;
        this.deleteUrl = deleteUrl;
        this.submitAddUrl = submitAddUrl;
        this.submitEditUrl = submitEditUrl;
        this.tableDataUrl = tableDataUrl;
        this.emptyImage = emptyImage;
        this.tomSelects = tomSelects;
    }

    init() {
        this.initDtTable();
        this.initInputs();
        this.initEvents();
        this.initSubmit();
    }

    // init datatable
    initDtTable() {
        this.table = new DataTable(`#table-${this.subject}`, {
            processing: true,
            responsive: true,
            serverSide: true,
            ajax: this.tableDataUrl,
            columns: this.columns,
        });
    }

    getTomSelectSetting(element) {
        const name = element.attr("name");
        const tomSelectItem = this.tomSelects.find((item) => item.name === name);
        return tomSelectItem?.settings ? Object.assign({}, tomSelectItem.settings) : null;
    }

    // get all input, tom select, and textarea
    initInputs() {
        $("input, textarea, select", `#form-add-${this.subject}`).each((index, item) => {
            this.inputs.add.push($(item));
            if ($(item).is("select")) {
                this.tomSelectsInputs.add.push({
                    element: $(item),
                    variable: new TomSelect($(item), this.getTomSelectSetting($(item))),
                });
            } else if ($(item).is('input[type="file"]')) {
                $(item).on("change", () => {
                    const file = $(item)[0].files[0]; // get file
                    const name = $(item)[0].name; // name of input file
                    const reader = new FileReader(); // create reader

                    reader.onload = function (e) {
                        // set image source to preview image name
                        $(`#preview-add-${name}`).attr("src", e.target.result);
                    };
                    reader.readAsDataURL(file);
                });
            }
        });

        $("input, textarea, select", `#form-edit-${this.subject}`).each((index, item) => {
            this.inputs.edit.push($(item));
            if ($(item).is("select")) {
                this.tomSelectsInputs.edit.push({
                    element: $(item),
                    variable: new TomSelect($(item), this.getTomSelectSetting($(item))),
                });
            } else if ($(item).is('input[type="file"]')) {
                $(item).on("change", () => {
                    const file = $(item)[0].files[0]; // get file
                    const name = $(item)[0].name; // name of input file
                    const reader = new FileReader(); // create reader

                    reader.onload = function (e) {
                        // set image source to preview image name
                        $(`#preview-edit-${name}`).attr("src", e.target.result);
                    };
                    reader.readAsDataURL(file);
                });
            }
        });
    }

    // button events
    initEvents() {
        this.modalAdd.on("hidden.bs.modal", (e) => {
            $(".is-invalid").removeClass("is-invalid");
            $(".invalid-feedback").remove();

            // restore preview image
            $(`#form-add-${this.subject} input[type="file"]`).each((index, item) => {
                $(`#preview-add-${$(item).attr("name")}`).attr("src", this.emptyImage);
            });
            $(`#form-add-${this.subject}`)[0].reset(); // reset form
            this.tomSelectsInputs.add.forEach(function (item, index) {
                item.variable.clear();
            });
        });

        this.modalEdit.on("hidden.bs.modal", (e) => {
            $(".is-invalid").removeClass("is-invalid");
            $(".invalid-feedback").remove();

            // restore preview image
            $(`#form-edit-${this.subject} input[type="file"]`).each((index, item) => {
                $(`#preview-edit-${$(item).attr("name")}`).attr("src", this.emptyImage);
            });
            $(`#form-edit-${this.subject}`)[0].reset(); // reset form
            this.tomSelectsInputs.edit.forEach(function (item, index) {
                item.variable.clear();
            });
        });

        this.table.on("click", ".btn-edit", (e) => {
            e.preventDefault();

            $(`#form-edit-${this.subject} input[name="id"]`).val($(e.currentTarget).data("id"));

            $.ajax({
                url: this.editUrl.replace(":id", $(e.currentTarget).data("id")),
                method: "GET",
                success: (response) => {
                    if (response.status === "success") {
                        this.inputs.edit.forEach((item, index) => {
                            this.handleInputTypeEdit($(item), response);
                        });
                        this.tomSelectsInputs.edit.forEach((item, index) => {
                            this.handleTomSelectTypeEdit(item, response);
                        });

                        this.modalEdit.show();
                    } else {
                        Swal.fire("Error!", response.message, "error");
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    Swal.fire("Error!", thrownError, "error");
                },
            });
        });

        this.table.on("click", ".btn-delete", (e, item) => {
            e.preventDefault();

            const id = $(this).data("id");

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
                        success: function (response) {
                            if (response.status === "success") {
                                Swal.fire({
                                    icon: "success",
                                    title: "Berhasil",
                                    text: response.message,
                                    showConfirmButton: false,
                                    timer: 1500,
                                }).then(() => {
                                    this.table.draw();

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
                        error: function (xhr, ajaxOptions, thrownError) {
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

    initSubmit() {
        $(`#submit-add-${this.subject}`).on("click", (e, item) => {
            e.preventDefault();

            $(".is-invalid").removeClass("is-invalid");
            $(".invalid-feedback").remove();
            $(`#submit-add-${this.subject}`).attr("disabled", true);
            $(`#submit-add-${this.subject}`).addClass("btn-loading");

            const formData = new FormData(); // Membuat objek FormData

            this.inputs.add.forEach((item, index) => {
                this.handleInputType($(item), formData);
            });

            this.tomSelectsInputs.add.forEach((item, index) => {
                this.handleTomSelectType(item, formData);
            });

            $.ajax({
                url: this.submitAddUrl,
                method: "POST",
                data: formData, // Menggunakan objek FormData sebagai data
                contentType: false, // Mengatur contentType ke false
                processData: false, // Mengatur processData ke false
                success: (response) => {
                    $(`#submit-add-${this.subject}`).attr("disabled", false);
                    $(`#submit-add-${this.subject}`).removeClass("btn-loading");
                    if (response.status === "success") {
                        Swal.fire({
                            icon: "success",
                            title: "Berhasil",
                            text: response.message,
                            showConfirmButton: false,
                            timer: 1500,
                        }).then(() => {
                            this.modalAdd.hide();

                            // Reload Datatable
                            this.table.draw();

                            // Show Alert
                            $(`#card-${this.subject}`).before(`
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <strong>Success!</strong> ${response.message}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            `);

                            $(".alert").delay(3000).slideUp(300);
                        });
                    } else {
                        Swal.fire("Error!", response.message, "error");
                    }
                },
                error: (response) => {
                    $(`#submit-add-${this.subject}`).attr("disabled", false);
                    $(`#submit-add-${this.subject}`).removeClass("btn-loading");
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

            const formData = new FormData();
            formData.append("_method", "PUT"); // Method PUT with FormData defined in Here
            this.inputs.edit.forEach((item, index) => {
                this.handleInputType($(item), formData);
            });

            this.tomSelectsInputs.edit.forEach((item, index) => {
                this.handleTomSelectType(item, formData);
            });

            $.ajax({
                url: this.submitEditUrl.replace(":id", formData.get("id")),
                method: "POST", // With FormData we can't use PUT method in here
                processData: false, // Prevent jQuery from processing the data
                contentType: false, // Prevent jQuery from setting the content type
                data: formData,
                success: (response) => {
                    $(`#submit-edit-${this.subject}`).attr("disabled", false);
                    $(`#submit-edit-${this.subject}`).removeClass("btn-loading");
                    if (response.status === "success") {
                        Swal.fire({
                            icon: "success",
                            title: "Berhasil",
                            text: response.message,
                            showConfirmButton: false,
                            timer: 1500,
                        }).then(() => {
                            this.modalEdit.hide();

                            // Reload Datatable
                            this.table.draw();

                            // Show Alert
                            $(`#card-${this.subject}`).before(`
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <strong>Success!</strong> ${response.message}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                `);

                            $(".alert").delay(3000).slideUp(300);
                        });
                    } else {
                        Swal.fire("Error!", response.message, "error");
                    }
                },
                error: (response) => {
                    $(`#submit-edit-${this.subject}`).attr("disabled", false);
                    $(`#submit-edit-${this.subject}`).removeClass("btn-loading");
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

    handleInputType(item, formData) {
        switch (item.prop("type")) {
            case "file":
                formData.append(item.prop("name"), $(item)[0].files[0]);
                break;
            case "checkbox":
            case "radio":
                formData.append(item.prop("name"), $(item).prop("checked") ? 1 : 0);
                break;
            default: // text, textarea, select, etc
                formData.append(item.prop("name"), $(item).val());
                break;
        }
    }

    handleInputTypeEdit(item, response) {
        switch (item.prop("type")) {
            case "file":
                const file = response.data[item.prop("name")] ? response.data[item.prop("name")] : this.emptyImage;
                $(`#preview-edit-${item.prop("name")}`).attr("src", file);
                break;
            case "checkbox":
            case "radio":
                item.prop("checked", response.data[item.prop("name")]);
                break;
            default: // text, textarea, select, etc
                item.val(response.data[item.prop("name")]);
                break;
        }
    }

    handleTomSelectType(item, formData) {
        const values = item.variable.getValue();
        if (typeof values === "string") {
            // single select
            formData.append(item.element.prop("name"), parseInt(values));
        } else if (values.length >= 1) {
            // multiple select
            const itemName = item.element.prop("name").concat("[]");
            values.forEach(function (value, index) {
                formData.append(itemName, value);
            });
        }
    }

    handleTomSelectTypeEdit(item, response) {
        if (Array.isArray(response.data[item.element.prop("name")])) {
            // multiple select
            item.variable.addOption(response.data[item.element.prop("name")]);
            item.variable.setValue(
                response.data[item.element.prop("name")].map(function (item) {
                    return item.id;
                }),
            );
        } else {
            // single select
            item.variable.addOption(response.data[item.element.prop("name")]);
            item.variable.setValue(response.data[item.element.prop("name")].id);
        }
    }
}

export default TemplateCRUD;
