@extends('cms.layouts.app')
@section('content')

@section('title')
    Add New Qurban Savings -
@endsection

{{-- BREAD CRUMB --}}
<h4 class="fw-bold py-3 mb-4">
    <a href="{{ route('apps.qurban.index') }}"><span class="text-muted fw-light">Qurban /</span></a> Add New Qurban Savings
</h4>

{{-- CONTENT START --}}
<div class="container-fluid">
    <div class="row g-3 mb-5 row-deck">
        <div class="col-xxl">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Savings Form</h5>
                    <small class="text-muted float-end">Complete the form below</small>
                </div>
                <div class="card-body">
                    <form id="formQurban" action="{{ route('apps.qurban.store') }}" method="POST">
                        @csrf
                        @include('cms.pages.qurban.fields')
                    </form>
                </div>
            </div>
        </div>
    </div> <!-- .row end -->
</div>
@endsection
