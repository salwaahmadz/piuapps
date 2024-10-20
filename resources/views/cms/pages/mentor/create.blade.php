@extends('cms.layouts.app')
@section('content')

@section('title')
    Add New Mentor -
@endsection

{{-- BREAD CRUMB --}}
<h4 class="fw-bold py-3 mb-4">
    <a href="{{ route('apps.mentor.index') }}"><span class="text-muted fw-light">Mentor /</span></a> Add New Mentor
</h4>

{{-- CONTENT START --}}
<div class="container-fluid">
    <div class="row g-3 mb-5 row-deck">
        <div class="col-xxl">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Mentor Form</h5>
                    <small class="text-muted float-end">Complete the form below</small>
                </div>
                <div class="card-body">
                    <form id="formMentor" action="{{ route('apps.mentor.store') }}" method="POST">
                        @csrf
                        @include('cms.pages.mentor.fields')
                    </form>
                </div>
            </div>
        </div>
    </div> <!-- .row end -->
</div>

@endsection
