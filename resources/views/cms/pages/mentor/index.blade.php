@extends('cms.layouts.app')
@section('content')

@section('title')
    Mentor -
@endsection

{{-- BREAD CRUMB --}}
<h4 class="fw-bold py-3 mb-4">Mentor</h4>

{{-- CONTENT START --}}
<div class="container-fluid">
    <div class="row g-3 mb-5 row-deck">
      <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="card">
            <div class="card-header">
              <h4 class="card-title m-0 fw-bold">Daftar Mentor</h4>
            </div>
            <div class="table-responsive text-nowrap">
                @include('cms.pages.mentor.table')
            </div>
          </div>
      </div>
    </div> <!-- .row end -->
  </div>

@endsection
