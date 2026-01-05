<div class="modal fade" id="detailBorrowModal-{{ $request->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content bg-dark border-secondary">

            <div class="modal-header">
                <h5 class="modal-title">Detail Peminjaman</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Tanggal Permintaan</strong><br>
                        {{ \Carbon\Carbon::parse($request->request_date)->format('d-m-Y') }}
                    </div>

                    <div class="col-md-6">
                        <strong>Peminjam</strong><br>
                        {{ $request->requesterUser->name ?? '-' }}
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Area / Unit</strong><br>
                        {{ $request->area->name ?? '-' }}
                    </div>

                    <div class="col-md-3">
                        <strong>Tanggal Pinjam</strong><br>
                        {{ $request->borrow_date }}
                    </div>

                    <div class="col-md-3">
                        <strong>Tanggal Kembali</strong><br>
                        {{ $request->return_date }}
                    </div>
                </div>

                <hr>

                <h6 class="mb-2">Daftar Alat</h6>

                <div class="table-responsive">
                    <table class="table table-dark table-sm">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Alat</th>
                                <th>No Asset</th>
                                <th>Kondisi Saat Ini</th>
                                <th>Status Saat Ini</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($request->items as $j => $item)
                                <tr>
                                    <td>{{ $j + 1 }}</td>
                                    <td>{{ $item->tool->name ?? '-' }}</td>
                                    <td>{{ $item->tool->nomer_asset ?? '-' }}</td>
                                    <td>{{ $item->tool->condition ?? '-' }}</td>
                                    <td>{{ $item->tool->current_status ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>

        </div>
    </div>
</div>
