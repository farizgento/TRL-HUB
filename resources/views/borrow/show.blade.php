@extends('layouts.app')

@section('content')
<h4>Detail Request {{ $request->request_no }}</h4>
<div class="card shadow-sm mb-3">
    <div class="card-body">
        <p>Status: <strong>{{ \App\Models\BorrowRequest::statusLabels()[$request->status] ?? $request->status }}</strong></p>
        <p>Requester: {{ $request->peminjam_display_name }}</p>
        <p>Area: {{ $request->areaUnit->area_name ?? '-' }}</p>
        <p>Periode: {{ $request->planned_start_date?->format('d-m-Y') ?? '-' }} - {{ $request->planned_end_date?->format('d-m-Y') ?? '-' }}</p>
    </div>
</div>
<div class="card shadow-sm mb-3">
    <div class="card-body">
        <h6>Items</h6>
        <ul>
            @foreach ($request->items as $item)
                <li>{{ $item->permintaan_alat }} - {{ $item->tool->tool_name ?? 'Belum dipilih' }}</li>
            @endforeach
        </ul>
    </div>
</div>
<div class="card shadow-sm">
    <div class="card-body">
        <h6>Action Panel</h6>
        @php
            $role = auth()->user()?->role?->slug;
        @endphp
        <div class="d-flex flex-wrap gap-2">
            @if (in_array($role, ['peminjam', 'admin'], true) && $request->status === \App\Models\BorrowRequest::STATUS_DRAFT)
                <form method="post" action="/borrow/{{ $request->id }}/action/submit">
                    @csrf
                    <button class="btn btn-primary btn-sm">Submit</button>
                </form>
            @endif
            @if (in_array($role, ['staff', 'admin'], true) && $request->status === \App\Models\BorrowRequest::STATUS_SUBMITTED)
                <form method="post" action="/borrow/{{ $request->id }}/action/approve-l1" class="d-flex gap-2">
                    @csrf
                    <input type="text" name="remark" placeholder="Remark" class="form-control form-control-sm">
                    <button class="btn btn-success btn-sm">Approve L1</button>
                </form>
            @endif
            @if (in_array($role, ['approval', 'admin'], true) && $request->status === \App\Models\BorrowRequest::STATUS_APPROVED_L1)
                <form method="post" action="/borrow/{{ $request->id }}/action/approve-final" class="d-flex gap-2">
                    @csrf
                    <input type="text" name="remark" placeholder="Remark" class="form-control form-control-sm">
                    <button class="btn btn-success btn-sm">Approve Final</button>
                </form>
            @endif
            @if (in_array($role, ['staff', 'admin'], true) && $request->status === \App\Models\BorrowRequest::STATUS_APPROVED_FINAL)
                <form method="post" action="/borrow/{{ $request->id }}/action/dispatch" class="d-flex gap-2">
                    @csrf
                    <input type="text" name="remark" placeholder="Surat Jalan Kirim" class="form-control form-control-sm">
                    <button class="btn btn-warning btn-sm">Dispatch</button>
                </form>
            @endif
            @if (in_array($role, ['staff', 'admin'], true) && $request->status === \App\Models\BorrowRequest::STATUS_DISPATCHED)
                <form method="post" action="/borrow/{{ $request->id }}/action/return" class="d-flex gap-2">
                    @csrf
                    <input type="text" name="remark" placeholder="Surat Jalan Kembali" class="form-control form-control-sm">
                    <button class="btn btn-warning btn-sm">Return</button>
                </form>
            @endif
            @if (in_array($role, ['staff', 'admin'], true))
                <a class="btn btn-outline-light btn-sm" href="/borrow/{{ $request->id }}/edit">Edit Request</a>
            @endif
        </div>
    </div>
</div>
@endsection
