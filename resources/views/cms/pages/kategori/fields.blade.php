<input type="hidden" name="id" id="kategori_id" value="{{ @$kategori->id }}">

<div class="row mb-3">
    <label for="kategori" class="col-sm-2 col-form-label">Kategori</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" id="kategori" name="kategori" placeholder="Masukkan Kategori Lengkap"
            required />
        <div class="invalid-feedback text-12">Kolom kategori tidak boleh kosong.</div>
    </div>
</div>

<div class="row justify-content-end">
    <div class="col-sm-10">
        <button type="button" class="btn btn-primary btnSubmit me-2">{{ @$kategori ? 'Edit' : 'Tambah' }}</button>
        <a href="{{ route('apps.category.index') }}" class="btn btn-secondary">Batal</a>
    </div>
</div>

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}">
@endpush

@push('js')
    <script src="{{ asset('assets/js/select2.bundle.js') }}" type="text/javascript"></script>

    <script>
        $(document).on('submit', 'formCategory', function(e) {
            e.preventDefault();
        });

        $(document).on('click', '.btnSubmit', function(e) {
            e.preventDefault();

            var form = $('#formCategory');
            var formData = new FormData(document.getElementById("formCategory"));
            var actionURL = $('#formCategory').attr('action');

            if ($('#formCategory')[0].checkValidity() === false) {
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
                            window.location.href = "{{ route('apps.category.index') }}";
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
