<table class="table table-striped" id="table">
    <thead>
    </thead>
    <tbody>
    </tbody>
</table>

@push('css')
    @include('cms.layouts.datatables_css')
@endpush

@push('js')
    @include('cms.layouts.datatables_js')

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
                        title: 'No',
                        className: "text-center",
                        searchable: false
                    },
                    {
                        data: 'name',
                        name: 'name',
                        title: 'Nama',
                        defaultContent: '-'
                    },
                    {
                        data: 'category.name',
                        name: 'category.name',
                        title: 'Kategori',
                        defaultContent: '-'
                    },
                    {
                        data: 'birthdate',
                        name: 'birthdate',
                        title: 'Tanggal Lahir',
                        defaultContent: '-'
                    },
                    {
                        data: 'phone_number',
                        name: 'phone_number',
                        title: 'Nomor HP',
                        defaultContent: '-'
                    },
                    {
                        data: 'is_active',
                        name: 'is_active',
                        title: 'Status',
                        defaultContent: '-',
                        render: function(data) {
                            return data == 1 ? 'Aktif' : 'Tidak Aktif';
                        }
                    },
                    {
                        data: 'action',
                        name: 'action',
                        title: 'Aksi',
                        className: "text-center",
                        searchable: false,
                        orderable: false
                    },
                ]
            });

            $("div.btnAdd").html(`
                <a href="{{ route('apps.participant.create') }}" class="btn btn-primary ms-3 me-3" title="Tambah Peserta Baru">+ Peserta</a>
            `);

            $(document).on('click', '.btnDelete', function(e) {
                e.preventDefault()

                let uuid = $(this).data('uuid');
                let name = $(this).data('name');
                let url = "{!! route('apps.participant.destroy') !!}";

                Swal.fire({
                    title: 'Hapus Peserta?',
                    icon: 'warning',
                    text: `Apakah kamu yakin ingin menghapus ${name}?`,
                    showCancelButton: true,
                    confirmButtonColor: '#DC3741',
                    cancelButtonColor: '#6C757D',
                    cancelButtonText: 'Tidak',
                    confirmButtonText: 'Ya, hapus!',
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
                                    title: 'Sukses',
                                    icon: 'success',
                                    text: res.message,
                                    showConfirmButton: false,
                                    timer: 2000
                                })
                                table.draw()
                            },
                            error: function(res) {
                                Swal.fire({
                                    title: 'Terjadi kesalahan!',
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
