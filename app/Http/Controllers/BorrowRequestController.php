<?php

namespace App\Http\Controllers;

use App\Models\AreaUnit;
use App\Models\BorrowRequest;
use App\Models\Tool;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\Models\BorrowRequestItem;


class BorrowRequestController extends Controller
{
    /**
     * Tampilkan daftar permintaan peminjaman
     */
    public function index()
    {
    $requests = BorrowRequest::with('items.tool', 'area', 'requesterUser')
        ->latest()
        ->paginate(10);   // <—— PAGINATION

    return view('borrow.index', compact('requests'));
    }

    /**
     * Form tambah peminjaman
     */
    public function create()
    {
        $areas = AreaUnit::all();
        $tools = Tool::where('current_status', 'tersedia')->get();

        return view('borrow.create', compact('areas', 'tools'));
    }

    /**
     * Simpan peminjaman baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'request_date'   => 'required|date',
            'area_unit_id'   => 'required|exists:area_units,id',
            'borrow_date'    => 'required|date',
            'return_date'    => 'required|date|after_or_equal:borrow_date',
            'tools'          => 'required|array'   // daftar alat
        ]);

        DB::transaction(function () use ($request) {

            // 1️⃣ simpan request utama
            $borrow = BorrowRequest::create([
                'request_date'   => $request->request_date,
                'area_unit_id'   => $request->area_unit_id,
                'requester'      => auth()->id(),
                'borrow_date'    => $request->borrow_date,
                'return_date'    => $request->return_date,
            ]);

            // 2️⃣ simpan item alat yang diminta
            foreach ($request->tools as $toolId) {
                BorrowRequestItem::create([
                    'borrow_request_id' => $borrow->id,
                    'tool_id'           => $toolId
                ]);
            }
        });

        return redirect()->route('borrow-requests.index')
            ->with('success', 'Permintaan peminjaman berhasil diajukan.');
    }

    /**
     * Detail 1 request
     */
    public function show($id)
    {
        $requestData = BorrowRequest::with('items.tool', 'area', 'requesterUser')
            ->findOrFail($id);

        return view('borrow.show', compact('requestData'));
    }

    public function destroy($id){

    }
    public function update($id){

    }
}
