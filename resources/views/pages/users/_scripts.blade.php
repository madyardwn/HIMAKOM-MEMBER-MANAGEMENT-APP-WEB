<script type="module">
    let table, formAdd, formEdit;

    function initDtTable() {
        table = new DataTable('#users-table', {
            processing: true,
            responsive: true,
            serverSide: true,
            ajax: "{{ route('users-management.users.index') }}",            
            columns: [
                {data: 'id', name: 'id', title: 'No'},
                {data: 'name', name: 'name', title: 'Name'},
                {data: 'email', name: 'email', title: 'Email'},
                {
                    data: null, 
                    title: 'Action',
                    orderable: false, 
                    searchable: false, 
                    responsivePriority: 1,
                    width: '1%',
                    render: function (data, type, row) {
                        return `
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                    Action
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item btn-edit" href="#" data-id="${data.id}"><i class="ti ti-pencil"></i>&nbsp; Edit</a></li>
                                    <li><a class="dropdown-item btn-delete" href="{{ route('users-management.users.index') }}/${data.id}"><i class="ti ti-trash"></i>&nbsp; Delete</a></li>
                                </ul>
                            </div>
                        `;
                    }
                },
            ],
        });         
    }

    // docuemnt on ready
    $(document).ready(function () {
        initDtTable();
        // initDtEvents();

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

    });
</script>