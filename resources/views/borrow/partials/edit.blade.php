<div class="modal fade" id="editBorrowModal-{{ $request->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content bg-dark border-secondary">

            <div class="modal-header">
                <h5 class="modal-title">Edit Request</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <form method="POST" action="{{ route('borrow-requests.update', $request->id) }}">
                @csrf
                @method('PUT')

                <div class="modal-body row g-3">

                    <div class="col-md-6">
                        <label class="form-label">Tanggal Pinjam</label>
                        <input type="date" name="borrow_date" class="form-control"
                               value="{{ $request->borrow_date }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Tanggal Kembali</label>
                        <input type="date" name="return_date" class="form-control"
                               value="{{ $request->return_date }}">
                    </div>

                    <hr class="mt-3">

                    <h6>Edit Daftar Alat</h6>

                    <div id="tool-wrapper-{{ $request->id }}">
                        @foreach ($request->items as $item)
                            <div class="row g-2 tool-row">
                                <div class="col-10">
                                    <select name="tools[]" class="form-select">
                                        @foreach (\App\Models\Tool::where('current_status','tersedia')
                                            ->orWhere('id',$item->tool_id)
                                            ->get() as $tool)

                                            <option value="{{ $tool->id }}"
                                                @selected($tool->id == $item->tool_id)>
                                                {{ $tool->name }} — {{ $tool->nomer_asset }}
                                            </option>

                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-2 d-grid">
                                    <button type="button" class="btn btn-outline-danger remove-tool">
                                        <i class="bi bi-dash-lg"></i>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-2">
                        <button type="button" class="btn btn-outline-primary add-tool"
                                data-target="{{ $request->id }}">
                            <i class="bi bi-plus-lg"></i> Tambah Alat
                        </button>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button class="btn btn-primary">Simpan</button>
                </div>

            </form>

        </div>
    </div>
</div>
