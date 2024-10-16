@extends('cms.layouts.app')
@section('content')

@section('title')
    Edit Participant -
@endsection

{{-- BREAD CRUMB --}}
<h4 class="fw-bold py-3 mb-4">
    <span><a class="text-muted fw-light" href="{{ route('apps.participant.index') }}">Participants</a> /</span>
    <span>Edit Participant</span>
</h4>

{{-- CONTENT START --}}
<div class="container-fluid">
    <div class="row g-3 mb-5 row-deck">
        <div class="col-xxl">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Participant Form</h5>
                    <small class="text-muted float-end">Complete the form below</small>
                </div>
                <div class="card-body">
                    <form id="formParticipant" action="{{ route('apps.participant.update') }}" method="POST">
                        @csrf
                        @include('cms.pages.participant.fields')
                    </form>
                </div>
            </div>
        </div>
    </div> <!-- .row end -->
</div>

@endsection
