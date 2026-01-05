{{-- ================= CREATE MODAL ================= --}}
<div class="modal fade" id="createBorrowModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content bg-dark border-secondary">

            <div class="modal-header">
                <h5 class="modal-title">Buat Request Peminjaman</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <form method="POST" action="{{ route('borrow-requests.store') }}">
                @csrf

                <div class="modal-body row g-3">

                    <div class="col-md-6">
                        <label class="form-label">Tanggal Permintaan</label>
                        <input type="date" name="request_date"
                               value="{{ now()->toDateString() }}"
                               class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Area / Unit</label>
                        <select name="area_unit_id" class="form-select">
                            <option value="">-- pilih area --</option>
                            @foreach(\App\Models\AreaUnit::all() as $area)
                                <option value="{{ $area->id }}">{{ $area->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Tanggal Pinjam</label>
                        <input type="date" name="borrow_date" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Tanggal Kembali</label>
                        <input type="date" name="return_date" class="form-control">
                    </div>

                    <hr class="mt-3">

                    <h6>Daftar Alat</h6>

                    <div id="tool-wrapper">
                        <div class="row g-2 tool-row">
                            <div class="col-10">
                                <select name="tools[]" class="form-select">
                                    <option value="">-- pilih alat --</option>
                                    @foreach (\App\Models\Tool::where('current_status','tersedia')->get() as $tool)
                                        <option value="{{ $tool->id }}">
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
                    </div>

                    <div class="mt-2">
                        <button type="button" class="btn btn-outline-primary" id="add-tool">
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