@extends('layouts.app')

@section('content')
@section('topbar-title')
    <h6 class="mb-0">Perbaikan</h6>
@endsection

<div class="breadcrumb-trail">
    <i class="bi bi-house"></i>
    <span>Perbaikan</span>
</div>

<div class="mb-4">
    <h2 class="fw-semibold mb-1">Job Perbaikan</h2>
    <p class="section-subtitle"> total job</p>
</div>

<div class="filter-panel mb-4">
    <div class="row g-3 align-items-center">
        <div class="col-lg-8">
            <div class="input-group">
                <span class="input-group-text bg-transparent border-0 text-muted"><i class="bi bi-search"></i></span>
                <input type="text" class="form-control soft-input" placeholder="Cari job, ticket, atau alat...">
            </div>
        </div>
        <div class="col-lg-2">
            <select class="form-select soft-input">
                <option>Semua Status</option>
            </select>
        </div>
        <div class="col-lg-2 d-grid">
            <button class="btn btn-outline-light">
                <i class="bi bi-download me-2"></i>Export
            </button>
        </div>
    </div>
</div>
    <div class="card card-dark">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-dark table-borderless align-middle mb-0">
                    <thead>
                        <tr class="text-muted">
                            <th>Job No</th>
                            <th>Ticket</th>
                            <th>Vendor</th>
                            <th>Assigned</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
