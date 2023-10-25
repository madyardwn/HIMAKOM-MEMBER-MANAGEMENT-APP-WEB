<script type="module">
    $(document).ready(function() {
        const cabinet = new TemplateCRUD({
            emptyImage: "{{ asset(config('tablar.default.preview.path')) }}",
            modalAdd: new bootstrap.Modal($(`#modal-add-cabinets`)),
            modalEdit: new bootstrap.Modal($(`#modal-edit-cabinets`)),
            editUrl: "{{ route('periodes.cabinets.edit', ':id') }}",
            deleteUrl: "{{ route('periodes.cabinets.destroy', ':id') }}",
            submitAddUrl: "{{ route('periodes.cabinets.store') }}",
            submitEditUrl: "{{ route('periodes.cabinets.update', ':id') }}",
            tableDataUrl: "{{ route('periodes.cabinets.index') }}",
            subject: 'cabinets',
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
                    data: 'logo',
                    name: 'logo',
                    title: 'Logo',
                    orderable: false,
                    searchable: false,
                    responsivePriority: 1,
                    width: '20%',
                    render: function(data, type, row) {
                        return `<img src="${data}" alt="Logo" class="img-fluid" width="100">`;
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
                    data: 'description',
                    name: 'description',
                    title: 'Description',
                    width: '20%'
                },
                {
                    data: 'visi',
                    name: 'visi',
                    title: 'Visi',
                    width: '20%'
                },
                {
                    data: 'misi',
                    name: 'misi',
                    title: 'Misi',
                    width: '20%'
                },
                {
                    data: 'year',
                    name: 'year',
                    title: 'Year',
                    width: '20%'
                },
                {
                    data: 'is_active',
                    name: 'is_active',
                    title: 'Status',
                    width: '20%',
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
                                    <li><a class="dropdown-item btn-edit" href="" data-id="${data.id}"><i class="ti ti-pencil"></i>&nbsp; Edit</a></li>
                                    <li><a class="dropdown-item btn-delete" href="" data-id="${data.id}"><i class="ti ti-trash"></i>&nbsp; Delete</a></li>
                                </ul>
                            </div>
                        `;
                        return html;
                    }
                },
            ]
        });

        cabinet.init();
    });
</script>
