<script type="module" src="{{ asset('plugins/DataTables/datatables.min.js') }}"></script>
<script type="module" src="{{ asset('plugins/TomSelect/tom-select-complete.js') }}"></script>
<script type="module" src="{{ asset('plugins/Parsley/parsley.min.js') }}"></script>
<script type="module">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>