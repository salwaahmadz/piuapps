@extends('cms.layouts.app')
@section('content')

@section('title')
    Participants -
@endsection

{{-- BREAD CRUMB --}}
<h4 class="fw-bold py-3 mb-4">Participants</h4>

{{-- CONTENT START --}}
<div class="container-fluid">
    <div class="row g-3 mb-5 row-deck">
      <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title m-0 fw-bold">List of Participants</h4>
            </div>
            <div class="table-responsive text-nowrap">
                @include('cms.pages.participant.table')
            </div>
          </div>
      </div>
    </div> <!-- .row end -->
  </div>

@endsection
