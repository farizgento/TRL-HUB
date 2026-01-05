@extends('layouts.app')

@section('content')
@section('topbar-title')
    <h6 class="mb-0">Peminjaman</h6>
@endsection

<div class="breadcrumb-trail">
    <i class="bi bi-house"></i>
    <span>Peminjaman</span>
</div>

<div class="page-header">
    <div>
        <h2 class="fw-semibold mb-1">Peminjaman Alat Pengendalian</h2>
        <p class="section-subtitle">{{ $requests->count() }} total request</p>
    </div>
    @php
        $role = auth()->user()?->role?->slug;
    @endphp
    @if (in_array($role, ['peminjam', 'admin'], true))
        <a class="btn btn-primary" href="/borrow/create">
            <i class="bi bi-plus-lg me-2"></i>Buat Request
        </a>
    @endif
</div>

<ul class="nav pill-tabs mb-3 gap-2">
    <li class="nav-item"><span class="nav-link active">Semua</span></li>
    <li class="nav-item"><span class="nav-link">Menunggu Approval</span></li>
    <li class="nav-item"><span class="nav-link">Aktif (0)</span></li>
    <li class="nav-item"><span class="nav-link">Overdue</span></li>
    <li class="nav-item"><span class="nav-link">Selesai</span></li>
</ul>

<form class="filter-panel mb-4" method="get" action="/borrow">
    <div class="row g-3 align-items-center">
        <div class="col-lg-6">
            <div class="input-group">
                <span class="input-group-text bg-transparent border-0 text-muted"><i class="bi bi-search"></i></span>
                <input type="text" class="form-control soft-input" name="search" value="{{ $filters['search'] }}" placeholder="Cari no. request atau nama peminjam...">
            </div>
        </div>
        <div class="col-lg-4">
            <select class="form-select soft-input" name="status">
                <option value="">Semua Status</option>
                @foreach ($statusOptions as $value => $label)
                    <option value="{{ $value }}" @selected($filters['status'] === $value)>{{ $label }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-lg-2 d-grid">
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
                            <th>No</th>
                            <th>Tanggal Permintaan</th>
                            <th>Jenis Pekerjaan</th>
                            <th>Nama Peminjam</th>
                            <th>Area/Unit</th>
                            <th>No Item</th>
                            <th>Permintaan Alat</th>
                            <th>Rencana Peminjaman</th>
                            <th>Rencana Kembali</th>
                            <th>Nama Alat</th>
                            <th>Kode Asset</th>
                            <th>Tanggal Kirim</th>
                            <th>Surat Jalan Kirim</th>
                            <th>Tanggal Kembali</th>
                            <th>Surat Jalan Kembali</th>
                            <th>Kondisi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $row = 1; @endphp
                        @forelse ($requests as $request)
                            @forelse ($request->items as $item)
                                <tr>
                                    <td>{{ $row++ }}</td>
                                    <td>{{ $request->requested_at?->format('d-m-Y') ?? '-' }}</td>
                                    <td>{{ $request->job_type ?? '-' }}</td>
                                    <td>{{ $request->borrower->name ?? '-' }}</td>
                                    <td>{{ $request->areaUnit->area_name ?? '-' }}</td>
                                    <td>{{ $item->item_no ?? '-' }}</td>
                                    <td>
                                        <a class="text-decoration-none text-light" href="/borrow/{{ $request->id }}">
                                            {{ $item->permintaan_alat }}
                                        </a>
                                    </td>
                                    <td>{{ $request->planned_start_date?->format('d-m-Y') ?? '-' }}</td>
                                    <td>{{ $request->planned_end_date?->format('d-m-Y') ?? '-' }}</td>
                                    <td>{{ $item->tool->tool_name ?? '-' }}</td>
                                    <td>{{ $item->tool->asset_no ?? '-' }}</td>
                                    <td>{{ $request->dispatched_at?->format('d-m-Y') ?? '-' }}</td>
                                    <td>{{ $request->dispatch_note ?? '-' }}</td>
                                    <td>{{ $request->returned_at?->format('d-m-Y') ?? '-' }}</td>
                                    <td>{{ $request->return_note ?? '-' }}</td>
                                    <td>{{ $item->return_condition ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td>{{ $row++ }}</td>
                                    <td>{{ $request->requested_at?->format('d-m-Y') ?? '-' }}</td>
                                    <td>{{ $request->job_type ?? '-' }}</td>
                                    <td>{{ $request->borrower->name ?? '-' }}</td>
                                    <td>{{ $request->areaUnit->area_name ?? '-' }}</td>
                                    <td colspan="11" class="text-muted">Belum ada item.</td>
                                </tr>
                            @endforelse
                        @empty
                            <tr>
                                <td colspan="16" class="text-center text-muted">Belum ada request peminjaman.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
