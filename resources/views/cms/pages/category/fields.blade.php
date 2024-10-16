<input type="hidden" name="id" id="category_id" value="{{ @$category->id }}">

<div class="row mb-3">
    <label for="category" class="col-sm-2 col-form-label">Category Name</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" id="category" name="category" placeholder="Enter category name"
            value="{{ @$category->kategori }}" required />
        <div class="invalid-feedback text-12">Column category cannot be empty.</div>
    </div>
</div>

<div class="row justify-content-end">
    <div class="col-sm-10">
        <button type="button"
            class="btn btn-primary btnSubmit me-2">{{ @$category ? 'Edit Data' : 'Add Data' }}</button>
        <a href="{{ route('apps.category.index') }}" class="btn btn-secondary">Cancel</a>
    </div>
</div>

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}">
    <style>
        .text-12 {
            font-size: 12px;
        }
    </style>
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
                            title: 'Success',
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
                            title: 'Something went wrong!',
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
