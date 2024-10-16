<table class="table table-striped" id="table">
    <thead>
        <th>No</th>
        <th>Name</th>
        <th>Category</th>
        <th>Birthdate</th>
        <th>Phone Number</th>
        <th>Status</th>
        <th>Action</th>
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
                    url: "{!! route('apps.participant.list') !!}",
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'id',
                        className: "text-center",
                        searchable: false
                    },
                    {
                        data: 'nama',
                        name: 'nama',
                        defaultContent: '-'
                    },
                    {
                        data: 'category.kategori',
                        name: 'category.kategori',
                        defaultContent: '-'
                    },
                    {
                        data: 'tgl_lahir',
                        name: 'tgl_lahir',
                        defaultContent: '-'
                    },
                    {
                        data: 'nomor_hp',
                        name: 'nomor_hp',
                        defaultContent: '-'
                    },
                    {
                        data: 'status',
                        name: 'status',
                        defaultContent: '-',
                        render: function(data) {
                            return data == 1 ? 'Active' : 'Not Active'; 
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
                <a href="{{ route('apps.participant.create') }}" class="btn btn-primary ms-3 me-3" title="Add New Participant">Add Data</a>
            `);

            $(document).on('click', '.btnDelete', function(e) {
                e.preventDefault()

                let uuid = $(this).data('uuid');
                let name = $(this).data('name');
                let url = "{!! route('apps.participant.destroy') !!}";

                Swal.fire({
                    title: 'Delete Participant?',
                    icon: 'warning',
                    text: `Are you sure you want to delete ${name}?`,
                    showCancelButton: true,
                    confirmButtonColor: '#DC3741',
                    cancelButtonColor: '#6C757D',
                    cancelButtonText: 'No',
                    confirmButtonText: 'Yes, delete it!',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "POST",
                            url: url,
                            data: {
                                uuid: uuid
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
