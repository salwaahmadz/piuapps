<table class="table table-striped" id="table">
    <thead>
        <th>No</th>
        <th>Nama</th>
        <th>Tipe</th>
        <th>Total Tabungan</th>
        <th class="text-center">Aksi</th>
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
                    url: "{!! route('apps.kurban.list') !!}",
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'id',
                        className: "text-center",
                        searchable: false
                    },
                    {
                        data: 'peserta.nama',
                        name: 'peserta.nama',
                        defaultContent: '-'
                    },
                    {
                        data: 'type',
                        name: 'type',
                        defaultContent: '-',
                        render: function(data) {
                            return data.charAt(0).toUpperCase() + data.slice(1)
                        }
                    },
                    {
                        data: 'total_nominal',
                        name: 'total_nominal',
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
                <a href="{{ route('apps.kurban.create') }}" class="btn btn-primary ms-3 me-3" title="Tambah Peserta Baru">Tambah</a>
            `);

            $(document).on('click', '.btnDelete', function(e) {
                e.preventDefault()

                let id = $(this).data('id');
                let url = "{!! route('apps.kurban.destroy') !!}";

                Swal.fire({
                    title: 'Hapus Record?',
                    icon: 'warning',
                    text: "Apakah kamu yakin ingin menghapus record ini?",
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
