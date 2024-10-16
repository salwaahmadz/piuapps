<input type="hidden" name="id" id="mentor_id" value="{{ @$mentor->id }}">

<div class="row mb-3">
    <label for="name" class="col-sm-2 col-form-label">Full Name</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" id="name" name="name" placeholder="Enter mentor full name"
            value="{{ @$mentor->nama }}" required />
        <div class="invalid-feedback text-12">Column name cannot be empty.</div>
    </div>
</div>

<div class="mb-3 row">
    <label for="birthdate" class="col-md-2 col-form-label">Birthdate</label>
    <div class="col-md-10">
        <input class="form-control" type="date" id="birthdate" name="birthdate" value="{{ @$mentor->tgl_lahir }}"
            required />
        <div class="invalid-feedback text-12">Column birthdate cannot be empty.</div>
    </div>
</div>

<div class="row mb-3">
    <label for="phone_number" class="col-sm-2 col-form-label">Phone Number</label>
    <div class="col-sm-10">
        <input type="text" inputmode="numeric" pattern="[0-9]*"
            oninput="this.value = this.value.replace(/[^0-9]/g, '');" class="form-control" id="phone_number"
            name="phone_number" placeholder="Enter mentor phone number (can be empty)"
            value="{{ @$mentor->nomor_hp }}" />
    </div>
</div>

<div class="row mb-3">
    <label for="status" class="col-sm-2 col-form-label">Status</label>
    <div class="col-sm-10">
        <select id="status" name="status" class="form-select" required>
            @if (@$participant)
                <option value="1" {{ @$participant->status == 1 ? 'selected' : '' }}>Active</option>
                <option value="0" {{ @$participant->status == 0 ? 'selected' : '' }}>Not Active</option>
            @else
                <option value="1">Active</option>
                <option value="0">Not Active</option>
            @endif
        </select>
    </div>
</div>

<div class="row justify-content-end">
    <div class="col-sm-10">
        <button type="button" class="btn btn-primary btnSubmit me-2">{{ @$mentor ? 'Edit Data' : 'Add Data' }}</button>
        <a href="{{ route('apps.mentor.index') }}" class="btn btn-secondary">Cancel</a>
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
                            title: 'Success',
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
