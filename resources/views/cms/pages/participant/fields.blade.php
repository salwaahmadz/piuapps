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

        .text-12 {
            font-size: 12px;
        }
    </style>
@endpush

<input type="hidden" name="id" id="participant_id" value="{{ @$participant->id }}">

<div class="row mb-3">
    <label for="name" class="col-sm-2 col-form-label">Full Name</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" id="name" name="name"
            placeholder="Enter participant full name" value="{{ @$participant->name }}" required />
        <div class="invalid-feedback text-12">Column name cannot be empty.</div>
    </div>
</div>

<div class="row mb-3">
    <label for="category" class="col-sm-2 col-form-label">Category</label>
    <div class="col-sm-10">
        <select class="form-control select2" id="category" name="category" data-placeholder="Choose Category"
            style="width: 100%;" required>
        </select>
        <div class="invalid-feedback text-12">Column category cannot be empty.</div>
    </div>
</div>

<div class="mb-3 row">
    <label for="birthdate" class="col-md-2 col-form-label">Birthdate</label>
    <div class="col-md-10">
        <input class="form-control" type="date" id="birthdate" name="birthdate"
            value="{{ @$participant->birthdate }}" required />
        <div class="invalid-feedback text-12">Column birthdate cannot be empty.</div>
    </div>
</div>

<div class="row mb-3">
    <label for="phone_number" class="col-sm-2 col-form-label">Phone Number</label>
    <div class="col-sm-10">
        <input type="text" inputmode="numeric" pattern="[0-9]*"
            oninput="this.value = this.value.replace(/[^0-9]/g, '');" class="form-control" id="phone_number"
            name="phone_number" placeholder="Enter participant phone number (can be empty)"
            value="{{ @$participant->phone_number }}" />
    </div>
</div>

<div class="row mb-3">
    <label for="status" class="col-sm-2 col-form-label">Status</label>
    <div class="col-sm-10">
        <select id="status" name="status" class="form-select" required>
            @if(@$participant)
                <option value="1" {{ @$participant->is_active == 1 ? 'selected' : '' }}>Active</option>
                <option value="0" {{ @$participant->is_active == 0 ? 'selected' : '' }}>Not Active</option>
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
            class="btn btn-primary btnSubmit me-2">{{ @$participant ? 'Edit Data' : 'Add Data' }}</button>
        <a href="{{ route('apps.participant.index') }}" class="btn btn-secondary">Cancel</a>
    </div>
</div>

@push('js')
    <script src="{{ asset('assets/js/select2.bundle.js') }}" type="text/javascript"></script>

    <script>
        $(document).ready(function() {
            $('.select2').select2();

            $('#category').select2({
                ajax: {
                    url: "{!! route('data.categories') !!}",
                    datatype: 'json',
                    data: function(params) {
                        var queryParameters = {
                            name: params.term
                        }
                        return queryParameters;
                    },
                    processResults: function(data) {
                        return {
                            results: $.map(data, function(item) {
                                return {
                                    text: item.name,
                                    id: item.id
                                }
                            })
                        };
                    }
                }
            })
        });

        @if (@$participant)
            let newOptionCourse = new Option("{{ @$participant->category->name }}", "{{ @$participant->category->id }}", true, true);
            $('#category').append(newOptionCourse).trigger('change');
        @endif

        $(document).on('submit', 'formParticipant', function(e) {
            e.preventDefault();
        });

        $(document).on('click', '.btnSubmit', function(e) {
            e.preventDefault();

            var form = $('#formParticipant');
            var formData = new FormData(document.getElementById("formParticipant"));
            var actionURL = $('#formParticipant').attr('action');

            if ($('#formParticipant')[0].checkValidity() === false) {
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
                            window.location.href = "{{ route('apps.participant.index') }}";
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
