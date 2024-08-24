<input type="hidden" name="id" id="peserta_id" value="{{ @$peserta->id }}">

<div class="row mb-3">
    <label for="nama" class="col-sm-2 col-form-label">Nama</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan Nama Lengkap"
            required />
        <div class="invalid-feedback text-12">Kolom nama tidak boleh kosong.</div>
    </div>
</div>

<div class="row mb-3">
    <label for="kategori" class="col-sm-2 col-form-label">Kategori</label>
    <div class="col-sm-10">
        <select id="kategori" name="kategori" data-placeholder="Pilih Kategori" style="width: 100%;" required>
        </select>
        <div class="invalid-feedback text-12">Kolom kategori tidak boleh kosong.</div>
    </div>
</div>

<div class="mb-3 row">
    <label for="tgl_lahir" class="col-md-2 col-form-label">Tanggal Lahir</label>
    <div class="col-md-10">
        <input class="form-control" type="date" id="tgl_lahir" name="tgl_lahir" required />
        <div class="invalid-feedback text-12">Kolom tanggal lahir tidak boleh kosong.</div>
    </div>
</div>

<div class="row mb-3">
    <label for="nomor_hp" class="col-sm-2 col-form-label">Nomor HP</label>
    <div class="col-sm-10">
        <input type="text" inputmode="numeric" pattern="[0-9]*" oninput="this.value = this.value.replace(/[^0-9]/g, '');" class="form-control" id="nomor_hp" name="nomor_hp" placeholder="Masukkan Nomor HP (Boleh kosong)" />
    </div>
</div>

<div class="row mb-3">
    <label for="status" class="col-sm-2 col-form-label">Status</label>
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
    <style>
        /* Mengganti tampilan default Select2 */
        .select2-container--default .select2-selection--single {
            display: block;
            width: 100%;
            height: calc(2.25rem + 2px);
            padding: 0.4375rem 0.875rem;
            font-size: 0.9375rem;
            font-weight: 400;
            line-height: 1.53;
            color: #697a8d;
            background-color: #fff;
            background-position: right 0.875rem center;
            background-size: 17px 12px;
            border: 1px solid #d9dee3;
            border-radius: 0.375rem;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
        }

        /* Menyesuaikan border dan shadow */
        .select2-container--default .select2-selection--single {
            border: 1px solid #d9dee3;
            border-radius: 0.375rem;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        /* Menyesuaikan tampilan ketika opsi sedang dipilih */
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            top: 50%;
            transform: translateY(-50%);
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            display: none;
        }

        /* Menyesuaikan tampilan dropdown */
        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: #007bff;
            color: white;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #697a8d;
            line-height: 24px;
            margin-left: -8px;
        }
    </style>
@endpush

@push('js')
    <script src="{{ asset('assets/js/select2.bundle.js') }}" type="text/javascript"></script>

    <script>
        $(document).ready(function() {
            $('#kategori').select2({
                ajax: {
                    url: "{!! route('data.kategori') !!}",
                    datatype: 'json',
                    width: 'resolve',
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
            }).on('select2:open', function() {
                $('.select2-selection').addClass('form-select');
            });
        });

        $(document).on('submit', 'formPeserta', function(e) {
            e.preventDefault();
        });

        $(document).on('click', '.btnSubmit', function(e) {
            e.preventDefault();

            var form = $('#formPeserta');
            var formData = new FormData(document.getElementById("formPeserta"));
            var actionURL = $('#formPeserta').attr('action');

            if ($('#formPeserta')[0].checkValidity() === false) {
                e.preventDefault();
                e.stopPropagation();
            } else {
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

            form.addClass('was-validated');
        });
    </script>
@endpush
