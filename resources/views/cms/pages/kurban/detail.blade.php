@extends('cms.layouts.app')
@section('content')

@section('title')
    Kurban -
@endsection

{{-- Modal --}}
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Nominal Nabung</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="recipient-name" class="col-form-label">Nama:</label>
                        <input type="text" class="form-control" id="recipient-name" value="{{ @$peserta->nama }}"
                            aria-disabled="true" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="recipient-name" class="col-form-label">Nominal Nabung:</label>
                        <input type="text" inputmode="numeric" pattern="[0-9]*"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '');" class="form-control"
                            id="recipient-name" name="nominal" value="{{ @$peserta->keuangan->nominal }}">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary">Edit</button>
            </div>
        </div>
    </div>
</div>

{{-- BREAD CRUMB --}}
<h4 class="fw-bold py-3 mb-4"><a href="{{ route('apps.dashboard') }}">
        <span class="text-muted fw-light">Dashboard /</span></a>
    <span class="text-muted fw-light">Keuangan /</span>
    <a href="{{ route('apps.kurban.index') }}"><span class="text-muted fw-light">Kurban /</span></a> Detail Tabungan
</h4>

{{-- CONTENT START --}}
<div class="container-fluid">
    <div class="row g-3 mb-5 row-deck">
        <div class="col-xl-12 col-lg-12 col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title m-0">Detail Tabungan</h4>
                    <div class="d-flex mt-2">
                        <h6 class="card-title m-0 me-3">Nama: {{ @$peserta->nama }}</h6>
                        <h6 class="card-title m-0">Kategori: {{ @$peserta->kategori->kategori }}</h6>
                    </div>
                </div>
                <div class="table-responsive text-nowrap">
                    @include('cms.pages.kurban.detail_table')
                </div>
            </div>
        </div>
    </div> <!-- .row end -->
</div>

@endsection
