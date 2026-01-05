<div class="modal fade" id="editToolModal-{{ $tool->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Edit Alat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form method="POST" action="{{ route('tools.update', $tool) }}">
                @csrf
                @method('PUT')

                {{-- supaya modal terbuka jika ada error --}}
                <input type="hidden" name="edit_id" value="{{ $tool->id }}">

                <div class="modal-body">
                    <div class="row g-3">

                        {{-- NOMOR ASSET --}}
                        <div class="col-md-6">
                            <label class="form-label">Nomor Asset</label>
                            <input type="text"
                                   name="nomer_asset"
                                   class="form-control @error('nomer_asset') is-invalid @enderror"
                                   value="{{ old('nomer_asset', $tool->nomer_asset) }}">
                            @error('nomer_asset')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- BARCODE --}}
                        <div class="col-md-6">
                            <label class="form-label">Barcode</label>
                            <input type="text"
                                   name="barcode"
                                   class="form-control @error('barcode') is-invalid @enderror"
                                   value="{{ old('barcode', $tool->barcode) }}">
                            @error('barcode')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- NAMA --}}
                        <div class="col-md-6">
                            <label class="form-label">Nama Alat</label>
                            <input type="text"
                                   name="name"
                                   class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name', $tool->name) }}"
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- LOKASI --}}
                        <div class="col-md-6">
                            <label class="form-label">Lokasi Saat Ini</label>
                            <select class="form-select" name="current_location_id">
                                <option value="">-</option>
                                @foreach ($areaunits as $area)
                                    <option value="{{ $area->id }}"
                                        @selected(old('current_location_id', $tool->current_location_id) == $area->id)>
                                        {{ $area->name }} - {{ $area->unit }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- KONDISI --}}
                        <div class="col-md-6">
                            <label class="form-label">Kondisi</label>
                            <select class="form-select" name="condition">
                                @foreach ($conditionOptions as $value => $label)
                                    <option value="{{ $value }}"
                                        @selected(old('condition', $tool->condition) == $value)>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- STATUS --}}
                        <div class="col-md-6">
                            <label class="form-label">Status</label>
                            <select class="form-select" name="current_status">
                                @foreach ($statusOptions as $value => $label)
                                    <option value="{{ $value }}"
                                        @selected(old('current_status', $tool->current_status) == $value)>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- CATATAN --}}
                        <div class="col-12">
                            <label class="form-label">Catatan</label>
                            <textarea class="form-control" rows="3" name="notes">{{ old('notes', $tool->notes) }}</textarea>
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
