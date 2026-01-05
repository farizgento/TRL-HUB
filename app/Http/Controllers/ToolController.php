<?php

namespace App\Http\Controllers;

use App\Models\Tool;
use App\Models\AreaUnit;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ToolController extends Controller
{
    public function index(Request $request)
    {
        $search     = $request->query('search');
        $status     = $request->query('status');
        $condition  = $request->query('condition');

        $tools = Tool::with('location')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nomer_asset', 'like', "%{$search}%")
                      ->orWhere('barcode', 'like', "%{$search}%")
                      ->orWhere('name', 'like', "%{$search}%");
                });
            })
            ->when($status, fn ($q) => $q->where('current_status', $status))
            ->when($condition, fn ($q) => $q->where('condition', $condition))
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('tools.index', [
            'tools' => $tools,
            'statusOptions' => [
                'tersedia'   => 'Tersedia',
                'rusak'      => 'Rusak',
                'dipinjam'   => 'Dipinjam',
                'diperbaiki' => 'Diperbaiki',
            ],
            'conditionOptions' => [
                'baik'          => 'Baik',
                'rusak ringan'  => 'Rusak Ringan',
                'rusak berat'   => 'Rusak Berat',
                'hilang'        => 'Hilang',
            ],
            'areaunits' => AreaUnit::orderBy('name')->get(),
            'filters' => compact('search','status','condition'),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'                => ['required','string','max:255'],
            'nomer_asset'         => ['nullable','string','max:255'],
            'barcode'             => ['nullable','string','max:255','unique:tools,barcode'],
            'current_location_id' => ['nullable','exists:area_units,id'],
            'current_status'      => ['required', Rule::in(['tersedia','rusak','dipinjam','diperbaiki'])],
            'condition'           => ['required', Rule::in(['baik','rusak ringan','rusak berat','hilang'])],
            'notes'               => ['nullable','string'],
        ]);

        Tool::create($data);

        return redirect()->route('tools.index')
            ->with('created', 'Alat berhasil ditambahkan.');
    }

    public function update(Request $request, Tool $tool)
    {
        $data = $request->validate([
            'name' => ['required','string','max:255'],

            'nomer_asset' => [
                'nullable','string','max:255',
            ],

            'barcode' => [
                'nullable','string','max:255',
                Rule::unique('tools','barcode')->ignore($tool->id),
            ],

            'current_location_id' => ['nullable','exists:area_units,id'],

            'current_status' => [
                'required',
                Rule::in(['tersedia','rusak','dipinjam','diperbaiki']),
            ],

            'condition' => [
                'required',
                Rule::in(['baik','rusak ringan','rusak berat','hilang']),
            ],

            'notes' => ['nullable','string'],
        ]);

        $tool->update($data);

        return redirect()->route('tools.index')
            ->with('updated', 'Alat berhasil diperbarui.');
    }

    public function destroy(Tool $tool)
    {
        $tool->delete();

        return redirect()->route('tools.index')
            ->with('deleted', 'Alat berhasil dihapus.');
    }
}
