<input type="hidden" name="id" id="mentor_id" value="{{ @$mentor->id }}">

<div class="row mb-3">
    <label for="name" class="col-sm-2 col-form-label">Nama Lengkap</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" id="name" name="name" placeholder="Masukkan nama lengkap"
            value="{{ @$mentor->name }}" required />
        <div class="invalid-feedback text-12">Kolom nama tidak boleh kosong.</div>
    </div>
</div>

<div class="mb-3 row">
    <label for="birthdate" class="col-md-2 col-form-label">Birthdate</label>
    <div class="col-md-10">
        <input class="form-control" type="date" id="birthdate" name="birthdate" value="{{ @$mentor->birthdate }}"
            required />
        <div class="invalid-feedback text-12">Kolom tanggal lahir tidak boleh kosong.</div>
    </div>
</div>

<div class="row mb-3">
    <label for="phone_number" class="col-sm-2 col-form-label">Phone Number</label>
    <div class="col-sm-10">
        <input type="text" inputmode="numeric" pattern="[0-9]*"
            oninput="this.value = this.value.replace(/[^0-9]/g, '');" class="form-control" id="phone_number"
            name="phone_number" placeholder="Masukkan nomor HP (boleh kosong)"
            value="{{ @$mentor->phone_number }}" />
    </div>
</div>

<div class="row mb-3">
    <label for="status" class="col-sm-2 col-form-label">Status</label>
    <div class="col-sm-10">
        <select id="status" name="status" class="form-select" required>
            @if (@$participant)
                <option value="1" {{ @$participant->is_active == 1 ? 'selected' : '' }}>Aktif</option>
                <option value="0" {{ @$participant->is_active == 0 ? 'selected' : '' }}>Tidak Aktif</option>
            @else
                <option value="1">Aktif</option>
                <option value="0">Tidak Aktif</option>
            @endif
        </select>
    </div>
</div>

<div class="row justify-content-end">
    <div class="col-sm-10">
        <button type="button" class="btn btn-primary btnSubmit me-2">{{ @$mentor ? 'Edit Data' : 'Tambah Data' }}</button>
        <a href="{{ route('apps.mentor.index') }}" class="btn btn-secondary">Batal</a>
    </div>
</div>

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}">
@endpush

@push('js')
    <script src="{{ asset('assets/js/select2.bundle.js') }}" type="text/javascript"></script>

    <script>
        $(document).on('submit', 'formMentor', function(e) {
            e.preventDefault();
        });

        $(document).on('click', '.btnSubmit', function(e) {
            e.preventDefault();

            var form = $('#formMentor');
            var formData = new FormData(document.getElementById("formMentor"));
            var actionURL = $('#formMentor').attr('action');

            if ($('#formMentor')[0].checkValidity() === false) {
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
                            title: 'Sukses',
                            icon: 'success',
                            text: res.message,
                            showConfirmButton: false,
                            timer: 2000
                        }).then(function() {
                            window.location.href = "{{ route('apps.mentor.index') }}";
                        });
                    },
                    error: function(res) {
                        setTimeout(() => {
                            $('.btnSubmit').removeAttr('disabled');
                        }, 2000);

                        Swal.fire({
                            title: 'Terjadi Kesalahan!',
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
