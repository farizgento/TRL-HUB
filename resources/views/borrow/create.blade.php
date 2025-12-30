@extends('layouts.app')

@section('content')
@section('topbar-title')
    <h6 class="mb-0">Buat Request</h6>
@endsection

<div class="breadcrumb-trail">
    <i class="bi bi-house"></i>
    <span>Peminjaman</span>
    <span>/ Request</span>
</div>

<div class="card card-dark">
    <div class="card-body">
        <form method="post" action="/borrow">
            @csrf
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Jenis Pekerjaan</label>
                    <input class="form-control soft-input" name="job_type" value="{{ old('job_type') }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Area/Unit</label>
                    <select class="form-select soft-input" name="area_unit_id">
                        <option value="">Pilih</option>
                        @foreach ($areaUnits as $area)
                            <option value="{{ $area->id }}" @selected(old('area_unit_id') == $area->id)>
                                {{ $area->area_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Lokasi Pekerjaan</label>
                    <input class="form-control soft-input" name="work_location" value="{{ old('work_location') }}" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Tanggal Peminjaman</label>
                    <input class="form-control soft-input" type="date" name="planned_start_date" value="{{ old('planned_start_date') }}" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Tanggal Kembali</label>
                    <input class="form-control soft-input" type="date" name="planned_end_date" value="{{ old('planned_end_date') }}" required>
                </div>
            </div>

            <hr class="border-secondary my-4">

            <div class="d-flex justify-content-between align-items-center mb-2">
                <h6 class="mb-0">Item Peminjaman</h6>
                <button class="btn btn-outline-light btn-sm" type="button" id="add-item">
                    <i class="bi bi-plus-lg me-1"></i>Tambah Item
                </button>
            </div>

            <div class="table-responsive">
                <table class="table table-dark table-borderless align-middle">
                    <thead>
                        <tr class="text-muted">
                            <th>No Item</th>
                            <th>Permintaan Alat</th>
                            <th>Tool (Opsional)</th>
                        </tr>
                    </thead>
                    <tbody id="items-body">
                        <tr>
                            <td>
                                <input class="form-control soft-input" name="items[0][item_no]" value="{{ old('items.0.item_no') }}">
                            </td>
                            <td>
                                <input class="form-control soft-input" name="items[0][permintaan_alat]" value="{{ old('items.0.permintaan_alat') }}" required>
                            </td>
                            <td>
                                <select class="form-select soft-input" name="items[0][tool_id]">
                                    <option value="">Belum ditentukan</option>
                                    @foreach ($tools as $tool)
                                        <option value="{{ $tool->id }}" @selected(old('items.0.tool_id') == $tool->id)>
                                            {{ $tool->tool_name }} ({{ $tool->asset_no }})
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-4">
                <a class="btn btn-outline-light" href="/borrow">Batal</a>
                <button class="btn btn-primary" type="submit">Simpan Request</button>
            </div>
        </form>
    </div>
</div>

<template id="item-template">
    <tr>
        <td>
            <input class="form-control soft-input" name="items[__INDEX__][item_no]">
        </td>
        <td>
            <input class="form-control soft-input" name="items[__INDEX__][permintaan_alat]" required>
        </td>
        <td>
            <select class="form-select soft-input" name="items[__INDEX__][tool_id]">
                <option value="">Belum ditentukan</option>
                @foreach ($tools as $tool)
                    <option value="{{ $tool->id }}">{{ $tool->tool_name }} ({{ $tool->asset_no }})</option>
                @endforeach
            </select>
        </td>
    </tr>
</template>

<script>
    const itemsBody = document.getElementById('items-body');
    const template = document.getElementById('item-template').innerHTML;
    document.getElementById('add-item').addEventListener('click', () => {
        const index = itemsBody.children.length;
        itemsBody.insertAdjacentHTML('beforeend', template.replace(/__INDEX__/g, index));
    });
</script>
@endsection
