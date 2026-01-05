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
        <h2 class="fw-semibold mb-1">Peminjaman Alat</h2>
        <p class="section-subtitle">{{ $requests->total() }} total request</p>
    </div>

    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createBorrowModal">
        <i class="bi bi-plus-lg me-2"></i>Buat Request
    </button>
</div>

<div class="card card-dark">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-dark table-borderless align-middle mb-0">
                <thead>
                    <tr class="text-muted">
                        <th>No</th>
                        <th>Tanggal Permintaan</th>
                        <th>Peminjam</th>
                        <th>Area / Unit</th>
                        <th>Tanggal Pinjam</th>
                        <th>Tanggal Kembali</th>
                        <th>Jumlah Item</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                @forelse ($requests as $i => $request)
                    <tr>
                        <td>{{ $requests->firstItem() + $i }}</td>

                        <td>{{ \Carbon\Carbon::parse($request->request_date)->format('d-m-Y') }}</td>

                        <td>{{ $request->requesterUser->name ?? '-' }}</td>

                        <td>{{ $request->area->name ?? '-' }}</td>

                        <td>{{ $request->borrow_date }}</td>

                        <td>{{ $request->return_date }}</td>

                        <td>{{ $request->items->count() }}</td>

                        <td class="text-nowrap">
                            <div class="btn-group">

                                <button class="btn btn-sm btn-outline-info"
                                        data-bs-toggle="modal"
                                        data-bs-target="#detailBorrowModal-{{ $request->id }}">
                                    Detail
                                </button>

                                <button class="btn btn-sm btn-outline-warning"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editBorrowModal-{{ $request->id }}">
                                    Edit
                                </button>

                                <button class="btn btn-sm btn-outline-danger"
                                        data-bs-toggle="modal"
                                        data-bs-target="#deleteBorrowModal-{{ $request->id }}">
                                    Hapus
                                </button>

                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">
                            Belum ada request peminjaman.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $requests->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>

{{-- ================== INCLUDE SEMUA MODAL ================== --}}
@foreach ($requests as $request)
    @include('borrow.partials.detail', ['request' => $request])
    @include('borrow.partials.edit', ['request' => $request])
    @include('borrow.partials.delete', ['request' => $request])
@endforeach

@include('borrow.partials.create')

{{-- ================= JS DINAMIS (TAMBAH/HAPUS ALAT) ================= --}}
<script>
document.addEventListener('click', function (e) {

    // tambah alat (modal CREATE & EDIT)
    if (e.target.closest('#add-tool')) {
        const wrapper = document.getElementById('tool-wrapper');
        const clone = wrapper.querySelector('.tool-row').cloneNode(true);
        clone.querySelector('select').value = "";
        wrapper.appendChild(clone);
    }

    if (e.target.closest('.add-tool')) {
        const id = e.target.closest('.add-tool').dataset.target;
        const wrapper = document.getElementById('tool-wrapper-' + id);
        const clone = wrapper.querySelector('.tool-row').cloneNode(true);
        clone.querySelector('select').value = "";
        wrapper.appendChild(clone);
    }

    // hapus baris alat
    if (e.target.closest('.remove-tool')) {
        const modal = e.target.closest('.modal');
        const rows = modal.querySelectorAll('.tool-row');
        if (rows.length > 1) {
            e.target.closest('.tool-row').remove();
        }
    }
});
</script>

@endsection
