@extends('cms.layouts.app')
@section('content')

@section('title')
    Detail Qurban Savings -
@endsection

{{-- BREAD CRUMB --}}
<h4 class="fw-bold py-3 mb-4">
    <a href="{{ route('apps.qurban.index') }}"><span class="text-muted fw-light">Qurban /</span></a> Detail Qurban
    Savings
</h4>

{{-- CONTENT START --}}
<div class="container-fluid">
    <div class="row g-3 mb-5 row-deck">
        <div class="col-xl-12 col-lg-12 col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title m-0">Detail Savings</h4>
                    <div class="d-flex mt-2">
                        <h6 class="card-title m-0 me-3">Name: {{ @$participant->name }}</h6>
                        <h6 class="card-title m-0">Category: {{ @$participant->category->name }}</h6>
                    </div>
                </div>
                <div class="table-responsive text-nowrap">
                    @include('cms.pages.qurban.detail_table')
                </div>
            </div>
        </div>
    </div> <!-- .row end -->
</div>

@endsection
