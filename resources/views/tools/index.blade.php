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
        <p class="section-subtitle">{{ $tools->total() }} Alat terdaftar</p>
    </div>

    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createToolModal">
        <i class="bi bi-plus-lg me-2"></i>Tambah Alat
    </button>
</div>

<form class="filter-panel mb-4" method="get" action="/tools">
    <div class="row g-3 align-items-center">

        <div class="col-lg-5">
            <div class="input-group">
                <span class="input-group-text bg-transparent border-0 text-muted">
                    <i class="bi bi-search"></i>
                </span>
                <input type="text"
                       name="search"
                       value="{{ $filters['search'] }}"
                       class="form-control soft-input"
                       placeholder="Cari nama, nomor asset, barcode...">
            </div>
        </div>

        <div class="col-lg-3">
            <select class="form-select soft-input" name="status">
                <option value="">Semua Status</option>
                @foreach ($statusOptions as $value => $label)
                    <option value="{{ $value }}" @selected($filters['status'] === $value)>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-lg-3">
            <select class="form-select soft-input" name="condition">
                <option value="">Semua Kondisi</option>
                @foreach ($conditionOptions as $value => $label)
                    <option value="{{ $value }}" @selected($filters['condition'] === $value)>
                        {{ $label }}
                    </option>
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
                    <th>No Asset</th>
                    <th>Barcode</th>
                    <th>Nama</th>
                    <th>Lokasi Saat Ini</th>
                    <th>Kondisi</th>
                    <th>Status</th>
                    <th class="text-nowrap">Aksi</th>
                </tr>
                </thead>

                <tbody>
                @forelse ($tools as $tool)
                    <tr>
                        <td>{{ $tool->nomer_asset ?? '-' }}</td>
                        <td>{{ $tool->barcode ?? '-' }}</td>
                        <td>{{ $tool->name }}</td>

                        <td>
                            {{ $tool->location 
                                ? $tool->location->name . ' - ' . $tool->location->unit 
                                : '-' 
                            }}
                        </td>

                        <td>{{ $tool->condition }}</td>

                        <td>{{ $tool->current_status }}</td>

                        <td class="text-nowrap">
                            <div class="btn-group">
                                <button class="btn btn-sm btn-outline-warning"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editToolModal-{{ $tool->id }}">
                                    Edit
                                </button>

                                <button class="btn btn-sm btn-outline-danger"
                                        data-bs-toggle="modal"
                                        data-bs-target="#deleteToolModal-{{ $tool->id }}">
                                    Hapus
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">
                            Belum ada data alat.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>

            <div class="mt-3">
                {{ $tools->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>

{{-- ========= INCLUDE SEMUA MODAL ========= --}}
@foreach ($tools as $tool)
    @include('tools.partials.edit', ['tool' => $tool])
    @include('tools.partials.delete', ['tool' => $tool])
@endforeach

@include('tools.partials.create')

{{-- ========= AUTOSHOW MODAL KETIKA ERROR ========= --}}
@if ($errors->any() && !old('edit_id'))
<script>
    new bootstrap.Modal('#createToolModal').show();
</script>
@endif

@if ($errors->any() && old('edit_id'))
<script>
    new bootstrap.Modal('#editToolModal-' + @json(old('edit_id'))).show();
</script>
@endif

@endsection
