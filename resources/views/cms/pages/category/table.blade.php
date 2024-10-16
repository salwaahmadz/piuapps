<table class="table table-striped" id="table">
    <thead>
        <th>No</th>
        <th>Category</th>
        <th>Created At</th>
        <th>Updated At</th>
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
                    url: "{!! route('apps.category.list') !!}",
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'id',
                        className: "text-center",
                        searchable: false
                    },
                    {
                        data: 'kategori',
                        name: 'kategori',
                        defaultContent: '-'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                        defaultContent: '-',
                    },
                    {
                        data: 'updated_at',
                        name: 'updated_at',
                        defaultContent: '-'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        className: "text-center",
                        searchable: false,
                        orderable: false
                    },
                ],
                columnDefs: [{
                    targets: [2, 3],
                    render: function(data) {
                        return moment(data).format('DD/MM/YYYY');
                    }
                }]
            });

            $("div.btnAdd").html(`
                <a href="{{ route('apps.category.create') }}" class="btn btn-primary ms-3 me-3" title="Add New Category">Add Data</a>
            `);

            $(document).on('click', '.btnDelete', function(e) {
                e.preventDefault()

                let id = $(this).data('id');
                let name = $(this).data('name');
                let url = "{!! route('apps.category.destroy') !!}";

                Swal.fire({
                    title: 'Delete Category?',
                    icon: 'warning',
                    text: `Are you sure you want to delete this ${name}?`,
                    showCancelButton: true,
                    confirmButtonColor: '#DC3741',
                    cancelButtonColor: '#6C757D',
                    cancelButtonText: 'Cancel',
                    confirmButtonText: 'Yes, delete it!',
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
                                    timer: 1500
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
