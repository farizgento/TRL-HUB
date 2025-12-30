@extends('layouts.app')

@section('content')
@section('topbar-title')
    <h6 class="mb-0">Master Alat</h6>
@endsection

<div class="breadcrumb-trail">
    <i class="bi bi-house"></i>
    <span>Master Alat</span>
</div>

<div class="page-header">
    <div>
        <h2 class="fw-semibold mb-1">Master Alat</h2>
        <p class="section-subtitle">{{ $tools->count() }} alat terdaftar</p>
    </div>
    <a class="btn btn-primary" href="/tools/create">
        <i class="bi bi-plus-lg me-2"></i>Tambah Alat
    </a>
</div>

<form class="filter-panel mb-4" method="get" action="/tools">
    <div class="row g-3 align-items-center">
        <div class="col-lg-5">
            <div class="input-group">
                <span class="input-group-text bg-transparent border-0 text-muted"><i class="bi bi-search"></i></span>
                <input type="text" class="form-control soft-input" name="search" value="{{ $filters['search'] }}" placeholder="Cari kode asset, barcode...">
            </div>
        </div>
        <div class="col-lg-3">
            <select class="form-select soft-input" name="status">
                <option value="">Semua Status</option>
                @foreach ($statusOptions as $value => $label)
                    <option value="{{ $value }}" @selected($filters['status'] === $value)>{{ $label }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-lg-3">
            <select class="form-select soft-input" name="condition">
                <option value="">Semua Kondisi</option>
                @foreach ($conditionOptions as $value => $label)
                    <option value="{{ $value }}" @selected($filters['condition'] === $value)>{{ $label }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-lg-1 d-grid">
            <button class="btn btn-outline-light" type="submit">
                <i class="bi bi-search me-2"></i>Filter
            </button>
        </div>
    </div>
</form>


    <div class="card card-dark">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-dark table-borderless align-middle mb-0">
                    <thead>
                        <tr class="text-muted">
                            <th>Asset</th>
                            <th>Barcode</th>
                            <th>Nama</th>
                            <th>Kategori</th>
                            <th>Lokasi</th>
                            <th>Kondisi</th>
                            <th>Availability</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($tools as $tool)
                            <tr>
                                <td><a class="text-decoration-none text-light" href="/tools/{{ $tool->id }}">{{ $tool->asset_no }}</a></td>
                                <td>{{ $tool->barcode ?? '-' }}</td>
                                <td>{{ $tool->tool_name }}</td>
                                <td>{{ $tool->category->category_name ?? '-' }}</td>
                                <td>{{ $tool->location->location_name ?? '-' }}</td>
                                <td>{{ $tool->condition_status }}</td>
                                <td>{{ $tool->availability_status }}</td>
                                <td><a class="btn btn-sm btn-outline-light" href="/tools/{{ $tool->id }}/edit">Edit</a></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted">Belum ada data alat.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
