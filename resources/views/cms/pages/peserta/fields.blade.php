<input type="hidden" name="id" id="peserta_id" value="{{ @$peserta->id }}">

<div class="row mb-3">
    <label class="col-sm-2 col-form-label" for="nama">Nama</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan Nama Lengkap"
            required />
    </div>
</div>

<div class="row mb-3">
    <label class="col-sm-2 col-form-label" for="kategori">Kategori</label>
    <div class="col-sm-10">
        <select class="form-control" id="kategori" name="kategori" data-placeholder="Pilih Kategori" required>
        </select>
    </div>
</div>

<div class="mb-3 row">
    <label for="tgl_lahir" class="col-md-2 col-form-label">Tanggal Lahir</label>
    <div class="col-md-10">
        <input class="form-control" type="date" id="tgl_lahir" name="tgl_lahir" required />
    </div>
</div>

<div class="row mb-3">
    <label class="col-sm-2 col-form-label" for="status">Status</label>
    <div class="col-sm-10">
        <select id="status" class="form-select" required>
            <option value="1">Aktif</option>
            <option value="0">Tidak Aktif</option>
        </select>
    </div>
</div>

<div class="row justify-content-end">
    <div class="col-sm-10">
        <button type="button" class="btn btn-primary btnSubmit me-2">{{ @$peserta ? 'Edit' : 'Tambah' }}</button>
        <a href="{{ route('apps.peserta.index') }}" class="btn btn-secondary">Batal</a>
    </div>
</div>

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}">
@endpush

@push('js')
    <script src="{{ asset('assets/js/select2.bundle.js') }}" type="text/javascript"></script>

    <script>
        $(document).ready(function() {

            $('#kategori').select2({
                ajax: {
                    url: "{!! route('data.kategori') !!}",
                    datatype: 'json',
                    data: function(params) {
                        var queryParameters = {
                            kategori: params.term
                        }
                        return queryParameters;
                    },
                    processResults: function(data) {
                        return {
                            results: $.map(data, function(item) {
                                return {
                                    text: item.kategori,
                                    id: item.id
                                }
                            })
                        };
                    }
                }
            });
        });

        $(document).on('submit', 'formPeserta', function(e) {
            e.preventDefault();
        });

        $(document).on('click', '.btnSubmit', function(e) {
            var form = $('#formPeserta');
            var formData = new FormData(document.getElementById("formPeserta"));
            var actionURL = $('#formPeserta').attr('action');

            if ($('#formPeserta')[0].checkValidity() === false) {
                e.preventDefault();
                e.stopPropagation();
                form.addClass('was-validated'); // Menambahkan feedback untuk validasi
            } else {
                e.preventDefault(); // Menambahkan e.preventDefault() di sini untuk mencegah submit default
                $.ajax({
                    type: "POST",
                    url: actionURL,
                    processData: false,
                    contentType: false,
                    data: formData,
                    beforeSend: function() {
                        $('.btnSubmit').prop('disabled', true);
                    },
                    success: function(res) {
                        setTimeout(() => {
                            $('.btnSubmit').removeAttr('disabled');
                        }, 2000);

                        Swal.fire({
                            title: 'Berhasil',
                            icon: 'success',
                            text: res.message,
                            showConfirmButton: false,
                            timer: 1500
                        }).then(function() {
                            window.location.href = "{{ route('apps.peserta.index') }}";
                        });
                    },
                    error: function(res) {
                        setTimeout(() => {
                            $('.btnSubmit').removeAttr('disabled');
                        }, 2000);

                        Swal.fire({
                            title: 'Terjadi Kesalahan',
                            icon: 'warning',
                            text: res.responseJSON.message
                        });
                    }
                });
            }
        });
    </script>
@endpush
