<table class="table table-striped" id="table">
    <thead>
        <th>No</th>
        <th>Nama</th>
        <th>Kategori</th>
        <th>Tanggal Lahir</th>
        <th>Aksi</th>
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
                // dom: '<"d-flex justify-content-between mb-3"<"col-3"><"d-flex justify-content-end"f<"div.btnModal">>>rt<"d-flex justify-content-between align-items-center mt-3 p-3"ip>',
                dom: '<"d-flex justify-content-between mb-3"<"col-lg-3"><"d-flex justify-content-end ms-4"f<"div.btnAdd">>>rt<"d-flex justify-content-between align-items-center mt-3 p-3"ip>',
                processing: true,
                serverSide: true,
                searchDelay: 1000,
                order: [
                    [0, 'asc']
                ],
                ajax: {
                    url: "{!! route('apps.peserta.list') !!}",
                    data: {
                        course: "{{ Request::get('kategori') }}"
                    }
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
                        data: 'kategori.kategori',
                        name: 'kategori.kategori',
                        defaultContent: '-'
                    },
                    {
                        data: 'tgl_lahir',
                        name: 'tgl_lahir',
                        defaultContent: '-'
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
                <a href="{{ route('apps.peserta.create') }}" class="btn btn-primary ms-3 me-3" title="Tambah Peserta Baru">Tambah</a>
            `);

            $(document).on('click', '.btnDelete', function(e) {
                e.preventDefault()

                let id = $(this).data('id');
                let url = "{!! route('apps.peserta.destroy') !!}";

                Swal.fire({
                    title: 'Hapus Peserta?',
                    icon: 'warning',
                    text: "Apakah kamu yakin ingin menghapus peserta ini?",
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
                                    timer: 1500
                                })
                                table.draw()
                            },
                            error: function(res) {
                                Swal.fire({
                                    title: 'Terjadi kesalahan',
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
