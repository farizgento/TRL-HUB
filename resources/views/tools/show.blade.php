@extends('layouts.app')

@section('content')
<h4>Detail Tool</h4>
<div class="card shadow-sm">
    <div class="card-body">
        <dl class="row">
            <dt class="col-sm-3">Asset No</dt>
            <dd class="col-sm-9">{{ $tool->asset_no }}</dd>
            <dt class="col-sm-3">Barcode</dt>
            <dd class="col-sm-9">{{ $tool->barcode }}</dd>
            <dt class="col-sm-3">Nama</dt>
            <dd class="col-sm-9">{{ $tool->tool_name }}</dd>
            <dt class="col-sm-3">Kategori</dt>
            <dd class="col-sm-9">{{ $tool->category->category_name ?? '-' }}</dd>
            <dt class="col-sm-3">Lokasi</dt>
            <dd class="col-sm-9">{{ $tool->location->location_name ?? '-' }}</dd>
            <dt class="col-sm-3">Status Kondisi</dt>
            <dd class="col-sm-9">{{ $tool->condition_status }}</dd>
            <dt class="col-sm-3">Availability</dt>
            <dd class="col-sm-9">{{ $tool->availability_status }}</dd>
        </dl>
        <div class="d-flex justify-content-end gap-2">
            <a class="btn btn-outline-secondary" href="/tools">Kembali</a>
            <a class="btn btn-primary" href="/tools/{{ $tool->id }}/edit">Edit</a>
        </div>
    </div>
</div>
@endsection
