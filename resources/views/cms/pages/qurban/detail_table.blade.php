<table class="table table-striped" id="table">
    <thead>
        <th>No</th>
        <th>Name</th>
        <th>Amount</th>
        <th>Date</th>
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
                    [3, 'desc']
                ],
                ajax: {
                    url: "{!! route('apps.qurban.detail_list') !!}",
                    data: {
                        participant: "{{ Request::segment(4) }}"
                    }
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
                        data: 'amount',
                        name: 'amount',
                        defaultContent: '-',
                        render: function(data) {
                            return formatRp(data)
                        }
                    },
                    {
                        data: 'date',
                        name: 'date',
                        defaultContent: '-',
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

            $(document).on('click', '.btnDelete', function(e) {
                e.preventDefault()

                let id = $(this).data('id');
                let url = "{!! route('apps.qurban.destroy') !!}";

                Swal.fire({
                    title: 'Delete Record?',
                    icon: 'warning',
                    text: "Are you sure you want to delete this record?",
                    showCancelButton: true,
                    confirmButtonColor: '#DC3741',
                    cancelButtonColor: '#6C757D',
                    cancelButtonText: 'Batal',
                    confirmButtonText: 'Hapus',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "POST",
                            url: url,
                            data: {
                                id: id
                            },
                            success: function(res) {
                                Swal.fire({
                                    title: 'Success',
                                    icon: 'success',
                                    text: res.message,
                                    showConfirmButton: false,
                                    timer: 2000
                                })
                                table.draw()
                            },
                            error: function(res) {
                                Swal.fire({
                                    title: 'Something went wrong!',
                                    icon: 'warning',
                                    text: res.responseJSON.message
                                })
                            }
                        })
                    }
                })

            })
        });
    </script>
@endpush
