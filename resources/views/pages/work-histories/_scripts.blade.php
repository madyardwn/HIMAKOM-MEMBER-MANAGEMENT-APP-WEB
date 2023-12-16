<script type="module">
    class WorkHistory {
        constructor() {
            // Empty & Subject
            this.subject = 'work-histories';

            // Modal
            this.modalShow = new bootstrap.Modal($(`#modal-show-work-histories`));

            // URL
            this.userDataUrl = "{{ route('users-management.work-histories.show', ':id') }}";

            // DataTable
            this.table = $('#table-work-histories');
            this.tableDataUrl = "{{ route('users-management.work-histories.index') }}";
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
                    data: 'picture',
                    name: 'picture',
                    title: 'Picture',
                    orderable: false,
                    searchable: false,
                    className: 'dt-center',
                    responsivePriority: 1,
                    width: '1%',
                    render: function(data, type, row) {
                        return `<img src="${data}" alt="picture" class="img-fluid" width="100">`;
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
                    data: 'year',
                    name: 'year',
                    title: 'Year',
                    className: 'dt-center',
                    responsivePriority: 2,
                    width: '1%'
                },
                {
                    data: 'name_bagus',
                    name: 'name_bagus',
                    title: 'Name Bagus',
                    className: 'dt-center',
                    responsivePriority: 2,
                    width: '5%'
                },
                {
                    data: null,
                    title: 'Action',
                    orderable: false,
                    searchable: false,
                    responsivePriority: 1,
                    width: '1%',
                    className: 'dt-center',
                    render: (data, type, row) => `
                        <a href="" class="btn btn-success btn-sm btn-show" data-bs-id="${row.id}">
                            <i class="fa fa-eye"></i> Show
                        </a>
                    `
                },
            ];

            this.tablePosition = $('#table-positions-work-histories');
            this.tablePositionDataUrl = "{{ route('users-management.work-histories.positions', ':id') }}";
            this.tablePositionColumns = [{
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
                    data: 'cabinet.name',
                    name: 'cabinet.name',
                    title: 'Cabinet',
                    responsivePriority: 1,
                    width: '10%'
                },
                {
                    data: 'department.name',
                    name: 'department.name',
                    title: 'Department',
                    responsivePriority: 1,
                    width: '10%'
                },
                {
                    data: 'role.name',
                    name: 'role.name',
                    title: 'Role',
                    responsivePriority: 1,
                    width: '10%'
                },
                {
                    data: 'start_date',
                    name: 'start_date',
                    title: 'Start Date',
                    className: 'dt-center',
                    responsivePriority: 1,
                    width: '1%',
                    render: (data, type, row) => moment(data).format('DD-MM-YYYY')
                }
            ];

            this.tableProgram = $('#table-programs-work-histories');
            this.tableProgramDataUrl = "{{ route('users-management.work-histories.programs', ':id') }}";
            this.tableProgramColumns = [{
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
                    title: 'Program',
                    responsivePriority: 1,
                    width: '10%'
                },
                {
                    data: 'department.name',
                    name: 'department.name',
                    title: 'Department',
                    responsivePriority: 1,
                    width: '10%'
                },
                {
                    data: 'lead.name',
                    name: 'lead.name',
                    title: 'Lead',
                    responsivePriority: 1,
                    width: '10%',
                    render: (data) => data ? `<span class="badge badge-outline text-green">${data}</span>` : ''
                },
                {
                    data: 'participants',
                    name: 'participants.name',
                    title: 'Participants',
                    responsivePriority: 1,
                    width: '10%',
                    render: (data, type, row) => {
                        let participants = '';

                        data.forEach((participant, index) => {
                            participants += `<span class="badge badge-outline text-green m-1">${participant.name}</span>`;
                        });

                        return participants;
                    }
                }
            ];
        }

        initDtEvents() {
            $(`#modal-show-${this.subject}`).on('hidden.bs.modal', (e) => {
                if ($.fn.DataTable.isDataTable(this.tablePosition)) {
                    this.tablePosition.DataTable().destroy();
                    this.tablePosition.empty();
                }

                if ($.fn.DataTable.isDataTable(this.tableProgram)) {
                    this.tableProgram.DataTable().destroy();
                    this.tableProgram.empty();
                }
            });
        }

        initDtTable() {
            this.table.DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: {
                    url: this.tableDataUrl,
                    type: 'GET',
                    dataType: 'JSON',
                },
                columns: this.tableColumns,
                drawCallback: async () => {
                    $('.btn-show').on('click', async (e) => {
                        e.preventDefault();

                        $(e.currentTarget).attr('disabled', true);
                        $(e.currentTarget).addClass('btn-loading');

                        Swal.fire({
                            title: 'Loading...',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        const id = $(e.currentTarget).data('bs-id');

                        try {
                            // Using fetch for AJAX call and wait until it's finished
                            const response = await fetch(this.userDataUrl.replace(':id', id));
                            const data = await response.json();

                            // Set user data to modal
                            $(`#modal-show-${this.subject}`).find('.modal-title').text(data.data.name);
                        } catch (error) {
                            console.error('Error fetching user data:', error);
                        }

                        try {
                            // Using fetch for AJAX call and wait until it's finished
                            await this.tablePosition.DataTable({
                                processing: true,
                                serverSide: true,
                                responsive: true,
                                ajax: this.tablePositionDataUrl.replace(':id', id),
                                columns: this.tablePositionColumns,
                            });

                            // Using fetch for AJAX call and wait until it's finished
                            await this.tableProgram.DataTable({
                                processing: true,
                                serverSide: true,
                                responsive: true,
                                ajax: this.tableProgramDataUrl.replace(':id', id),
                                columns: this.tableProgramColumns,
                            });

                            this.modalShow.show();
                        } catch (error) {
                            console.error('Error fetching position or program data:', error);
                        }

                        $(e.currentTarget).attr('disabled', false);
                        $(e.currentTarget).removeClass('btn-loading');

                        Swal.close();
                    });
                }
            });
        }
    }

    $(document).ready(function() {
        const workHistory = new WorkHistory();
        workHistory.initDtEvents();
        workHistory.initDtTable();
    });
</script>
