<!-- {{-- ================= MODAL TAMBAH ================= --}} -->
<div class="modal fade" id="createToolModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Tambah Alat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form method="POST" enctype="multipart/form-data" action="{{ route('tools.store') }}">
                @csrf

                <div class="modal-body">
                    <div class="row g-3">
                    <!-- Nama -->
                    <div class="col-md-6">
                        <label class="form-label">Nama Alat</label>
                        <input type="text"
                            name="name"
                            value="{{ old('name') }}"
                            class="form-control @error('name') is-invalid @enderror"
                            required>
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <!-- Nomor Asset -->
                    <div class="col-md-6">
                        <label class="form-label">Nomor Asset</label>
                        <input type="text"
                            name="nomer_asset"
                            value="{{ old('nomer_asset') }}"
                            class="form-control @error('nomer_asset') is-invalid @enderror">
                        @error('nomer_asset') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <!-- Barcode -->
                    <div class="col-md-6">
                        <label class="form-label">Barcode</label>
                        <input type="text"
                            name="barcode"
                            value="{{ old('barcode') }}"
                            class="form-control @error('barcode') is-invalid @enderror">
                        @error('barcode') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <!-- Lokasi -->
                    <div class="col-md-6">
                        <label class="form-label">Lokasi Saat ini</label>
                        <select class="form-select" name="current_location_id">
                            <option value="">-</option>
                            @foreach ($areaunits as $area)
                                <option value="{{ $area->id }}" @selected(old('current_location_id') == $area->id)>
                                    {{ $area->name }} - {{ $area->unit }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Kondisi -->
                    <div class="col-md-6">
                        <label class="form-label">Kondisi</label>
                        <select class="form-select" name="condition">
                            @foreach ($conditionOptions as $value => $label)
                                <option value="{{ $value }}" @selected(old('condition') == $value)>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Status -->
                    <div class="col-md-6">
                        <label class="form-label">Status</label>
                        <select class="form-select" name="current_status">
                            @foreach ($statusOptions as $value => $label)
                                <option value="{{ $value }}" @selected(old('current_status') == $value)>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Catatan -->
                    <div class="col-12">
                        <label class="form-label">Catatan</label>
                        <textarea class="form-control" rows="3" name="notes">{{ old('notes') }}</textarea>
                    </div>


                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button class="btn btn-primary" type="submit">Simpan</button>
                </div>

            </form>

        </div>
    </div>
</div>