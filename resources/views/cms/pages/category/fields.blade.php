<input type="hidden" name="id" id="category_id" value="{{ @$category->id }}">

<div class="row mb-3">
    <label for="name" class="col-sm-2 col-form-label">Category Name</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" id="name" name="name" placeholder="Enter category name"
            value="{{ @$category->name }}" required />
        <div class="invalid-feedback text-12">Column category cannot be empty.</div>
    </div>
</div>

<div class="row mb-3">
    <label for="description" class="col-sm-2 col-form-label">Description</label>
    <div class="col-sm-10">
        <textarea class="form-control" id="description" name="description" placeholder="Enter description (Can be empty)">{{ @$category->description }}</textarea>
        <div class="invalid-feedback text-12">Column category cannot be empty.</div>
    </div>
</div>

<div class="row mb-3">
    <label for="status" class="col-sm-2 col-form-label">Status</label>
    <div class="col-sm-10">
        <select id="status" name="status" class="form-select" required>
            @if (@$category)
                <option value="1" {{ @$category->is_active == 1 ? 'selected' : '' }}>Active</option>
                <option value="0" {{ @$category->is_active == 0 ? 'selected' : '' }}>Not Active</option>
            @else
                <option value="1">Active</option>
                <option value="0">Not Active</option>
            @endif
        </select>
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
