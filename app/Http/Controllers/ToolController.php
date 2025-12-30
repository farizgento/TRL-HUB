<?php

namespace App\Http\Controllers;

use App\Models\Tool;
use App\Models\ToolCategory;
use App\Models\ToolLocation;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ToolController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $status = $request->query('status');
        $condition = $request->query('condition');

        $tools = Tool::with(['category', 'location'])
            ->when($search, function ($query) use ($search) {
                $query->where(function ($inner) use ($search) {
                    $inner->where('asset_no', 'like', "%{$search}%")
                        ->orWhere('barcode', 'like', "%{$search}%")
                        ->orWhere('tool_name', 'like', "%{$search}%");
                });
            })
            ->when($status, fn ($query) => $query->where('availability_status', $status))
            ->when($condition, fn ($query) => $query->where('condition_status', $condition))
            ->orderBy('tool_name')
            ->get();

        return view('tools.index', [
            'tools' => $tools,
            'statusOptions' => Tool::availabilityOptions(),
            'conditionOptions' => Tool::conditionOptions(),
            'filters' => [
                'search' => $search,
                'status' => $status,
                'condition' => $condition,
            ],
        ]);
    }

    public function create()
    {
        return view('tools.create', [
            'categories' => ToolCategory::orderBy('category_name')->get(),
            'locations' => ToolLocation::orderBy('location_name')->get(),
            'statusOptions' => Tool::availabilityOptions(),
            'conditionOptions' => Tool::conditionOptions(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'asset_no' => ['required', 'string', 'max:255', 'unique:tools,asset_no'],
            'barcode' => ['nullable', 'string', 'max:255', 'unique:tools,barcode'],
            'tool_name' => ['required', 'string', 'max:255'],
            'category_id' => ['nullable', 'exists:tool_categories,id'],
            'location_id' => ['nullable', 'exists:tool_locations,id'],
            'condition_status' => ['required', Rule::in(array_keys(Tool::conditionOptions()))],
            'availability_status' => ['required', Rule::in(array_keys(Tool::availabilityOptions()))],
            'notes' => ['nullable', 'string'],
        ]);

        Tool::create($data);

        return redirect('/tools')->with('status', 'Alat berhasil ditambahkan.');
    }

    public function show(Tool $tool)
    {
        return view('tools.show', ['tool' => $tool->load(['category', 'location'])]);
    }

    public function edit(Tool $tool)
    {
        return view('tools.edit', [
            'tool' => $tool,
            'categories' => ToolCategory::orderBy('category_name')->get(),
            'locations' => ToolLocation::orderBy('location_name')->get(),
            'statusOptions' => Tool::availabilityOptions(),
            'conditionOptions' => Tool::conditionOptions(),
        ]);
    }

    public function update(Request $request, Tool $tool)
    {
        $data = $request->validate([
            'asset_no' => ['required', 'string', 'max:255', Rule::unique('tools', 'asset_no')->ignore($tool->id)],
            'barcode' => ['nullable', 'string', 'max:255', Rule::unique('tools', 'barcode')->ignore($tool->id)],
            'tool_name' => ['required', 'string', 'max:255'],
            'category_id' => ['nullable', 'exists:tool_categories,id'],
            'location_id' => ['nullable', 'exists:tool_locations,id'],
            'condition_status' => ['required', Rule::in(array_keys(Tool::conditionOptions()))],
            'availability_status' => ['required', Rule::in(array_keys(Tool::availabilityOptions()))],
            'notes' => ['nullable', 'string'],
        ]);

        $tool->update($data);

        return redirect('/tools')->with('status', 'Alat berhasil diperbarui.');
    }
}
