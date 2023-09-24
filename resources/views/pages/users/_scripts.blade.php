<script type="module">
    $(function () {
        let table = new DataTable('#users-table', {
            processing: true,
            responsive: true,
            serverSide: true,
            ajax: "{{ route('users.index') }}",
            columns: [
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'email', name: 'email'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
        });         
    });
</script>