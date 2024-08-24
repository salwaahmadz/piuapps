<input type="hidden" name="id" id="pengajar_id" value="{{ @$pengajar->id }}">

<div class="row mb-3">
    <label for="nama" class="col-sm-2 col-form-label">Nama</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan Nama Lengkap"
            required />
        <div class="invalid-feedback text-12">Kolom nama tidak boleh kosong.</div>
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
        <input type="text" inputmode="numeric" pattern="[0-9]*"
            oninput="this.value = this.value.replace(/[^0-9]/g, '');" class="form-control" id="nomor_hp"
            name="nomor_hp" placeholder="Masukkan Nomor HP (Boleh kosong)" />
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
        <button type="button" class="btn btn-primary btnSubmit me-2">{{ @$pengajar ? 'Edit' : 'Tambah' }}</button>
        <a href="{{ route('apps.pengajar.index') }}" class="btn btn-secondary">Batal</a>
    </div>
</div>

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}">
@endpush

@push('js')
    <script src="{{ asset('assets/js/select2.bundle.js') }}" type="text/javascript"></script>

    <script>
        $(document).on('submit', 'formPengajar', function(e) {
            e.preventDefault();
        });

        $(document).on('click', '.btnSubmit', function(e) {
            e.preventDefault();

            var form = $('#formPengajar');
            var formData = new FormData(document.getElementById("formPengajar"));
            var actionURL = $('#formPengajar').attr('action');

            if ($('#formPengajar')[0].checkValidity() === false) {
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
                            window.location.href = "{{ route('apps.pengajar.index') }}";
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
