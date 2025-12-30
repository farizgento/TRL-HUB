@extends('layouts.app')

@section('content')
@section('topbar-title')
    <h6 class="mb-0">Tambah Alat</h6>
@endsection

<div class="breadcrumb-trail">
    <i class="bi bi-house"></i>
    <span>Master Alat</span>
    <span>/ Tambah</span>
</div>

<div class="card card-dark">
    <div class="card-body">
        <form method="post" action="/tools">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Asset No</label>
                    <input class="form-control soft-input" name="asset_no" value="{{ old('asset_no') }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Barcode</label>
                    <input class="form-control soft-input" name="barcode" value="{{ old('barcode') }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Nama Alat</label>
                    <input class="form-control soft-input" name="tool_name" value="{{ old('tool_name') }}" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Kategori</label>
                    <select class="form-select soft-input" name="category_id">
                        <option value="">Pilih</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>
                                {{ $category->category_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Lokasi</label>
                    <select class="form-select soft-input" name="location_id">
                        <option value="">Pilih</option>
                        @foreach ($locations as $location)
                            <option value="{{ $location->id }}" @selected(old('location_id') == $location->id)>
                                {{ $location->location_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Kondisi</label>
                    <select class="form-select soft-input" name="condition_status" required>
                        @php $defaultCondition = old('condition_status', \App\Models\Tool::CONDITION_GOOD); @endphp
                        @foreach ($conditionOptions as $value => $label)
                            <option value="{{ $value }}" @selected($defaultCondition === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Status</label>
                    <select class="form-select soft-input" name="availability_status" required>
                        @php $defaultAvailability = old('availability_status', \App\Models\Tool::AVAILABILITY_AVAILABLE); @endphp
                        @foreach ($statusOptions as $value => $label)
                            <option value="{{ $value }}" @selected($defaultAvailability === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12">
                    <label class="form-label">Catatan</label>
                    <textarea class="form-control soft-input" name="notes" rows="3">{{ old('notes') }}</textarea>
                </div>
            </div>
            <div class="d-flex justify-content-end gap-2 mt-4">
                <a class="btn btn-outline-light" href="/tools">Batal</a>
                <button class="btn btn-primary" type="submit">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection
