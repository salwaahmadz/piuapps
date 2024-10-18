<table class="table table-striped" id="table">
    <thead>
        <th>No</th>
        <th>Name</th>
        <th>Total Savings</th>
        <th class="text-center">Action</th>
    </thead>
    <tbody>
    </tbody>
</table>

@push('css')
    @include('CMS.layouts.datatables_css')
@endpush

@push('js')
    @include('CMS.layouts.datatables_js')

    <script>
        $(document).ready(function() {
            var table = $('#table').DataTable({
                dom: '<"d-flex justify-content-between mb-3"<"col-lg-3"><"d-flex justify-content-end ms-4"f<"div.btnAdd">>>rt<"d-flex justify-content-between align-items-center mt-3 p-3"ip>',
                processing: true,
                serverSide: true,
                searchDelay: 1000,
                order: [
                    [1, 'asc']
                ],
                ajax: {
                    url: "{!! route('apps.qurban.list') !!}",
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'id',
                        className: "text-center",
                        searchable: false
                    },
                    {
                        data: 'participant.name',
                        name: 'participant.name',
                        defaultContent: '-'
                    },
                    {
                        data: 'total_amount',
                        name: 'total_amount',
                        defaultContent: '-',
                        render: function(data) {
                            return formatRp(data)
                        }
                    },
                    {
                        data: 'action',
                        name: 'action',
                        className: "text-center",
                        searchable: false,
                        orderable: false
                    },
                ]
            });

            $("div.btnAdd").html(`
                <a href="{{ route('apps.qurban.create') }}" class="btn btn-primary ms-3 me-3" title="Add New Qurban Savings">Add Data</a>
            `);
        });
    </script>
@endpush
