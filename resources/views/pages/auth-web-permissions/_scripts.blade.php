<script type="module">
    $(document).ready(function() {
        const authWebRoles = new TemplateCRUD({
            emptyImage: "{{ asset(config('tablar.default.preview.path')) }}",
            subject: 'auth-web-permissions',
            editUrl: "{{ route('auth-web.roles.edit', ':id') }}",
            deleteUrl: "{{ route('auth-web.roles.destroy', ':id') }}",
            submitAddUrl: "{{ route('auth-web.roles.store') }}",
            submitEditUrl: "{{ route('auth-web.roles.update', ':id') }}",
            tableDataUrl: "{{ route('auth-web.roles.index') }}",
            columns: [{
                    data: 'id',
                    name: 'id',
                    title: 'No',
                    width: '1%'
                },
                {
                    data: 'name',
                    name: 'name',
                    title: 'Name'
                },
            ],
        });

        authWebRoles.init();
    });
</script>
