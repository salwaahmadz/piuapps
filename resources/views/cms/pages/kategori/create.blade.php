@extends('cms.layouts.app')
@section('content')

@section('title')
    Tambah Kategori -
@endsection

{{-- BREAD CRUMB --}}
<h4 class="fw-bold py-3 mb-4">
    <a href="{{ route('apps.dashboard') }}"><span class="text-muted fw-light">Dashboard /</span></a>
    <a href="{{ route('apps.category.index') }}"><span class="text-muted fw-light">Kategori /</span></a> Tambah Kategori
</h4>

{{-- CONTENT START --}}
<div class="container-fluid">
    <div class="row g-3 mb-5 row-deck">
        <div class="col-xxl">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Formulir Data</h5>
                    <small class="text-muted float-end">Lengkapi formulir dibawah ini</small>
                </div>
                <div class="card-body">
                    <form id="formCategory" action="{{ route('apps.category.store') }}" method="POST">
                        @csrf
                        @include('cms.pages.kategori.fields')
                    </form>
                </div>
            </div>
        </div>
    </div> <!-- .row end -->
</div>

@endsection
