<?php

namespace App\Http\Controllers;

use App\Models\AreaUnit;
use App\Models\BorrowRequest;
use App\Models\Tool;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class BorrowRequestController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $search = $request->query('search');
        $status = $request->query('status');

        $query = BorrowRequest::with(['borrower', 'areaUnit', 'items.tool'])
            ->visibleTo($user)
            ->when($status, fn ($q) => $q->where('status', $status))
            ->when($search, function ($q) use ($search) {
                $q->where(function ($inner) use ($search) {
                    $inner->where('request_no', 'like', "%{$search}%")
                        ->orWhereHas('borrower', function ($sub) use ($search) {
                            $sub->where('name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%");
                        });
                });
            })
            ->orderByDesc('created_at');

        $requests = $query->get();

        return view('borrow.index', [
            'requests' => $requests,
            'statusOptions' => BorrowRequest::statusLabels(),
            'filters' => [
                'search' => $search,
                'status' => $status,
            ],
        ]);
    }

    public function create(Request $request)
    {
        $this->authorizeRole($request, ['peminjam', 'admin']);

        return view('borrow.create', [
            'areaUnits' => AreaUnit::orderBy('area_name')->get(),
            'tools' => Tool::where('availability_status', Tool::AVAILABILITY_AVAILABLE)
                ->orderBy('tool_name')
                ->get(),
        ]);
    }

    public function store(Request $request)
    {
        $this->authorizeRole($request, ['peminjam', 'admin']);

        $data = $request->validate([
            'job_type' => ['required', 'string', 'max:255'],
            'work_location' => ['required', 'string', 'max:255'],
            'area_unit_id' => ['nullable', 'exists:area_units,id'],
            'planned_start_date' => ['required', 'date'],
            'planned_end_date' => ['required', 'date', 'after_or_equal:planned_start_date'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.item_no' => ['nullable', 'string', 'max:50'],
            'items.*.permintaan_alat' => ['required', 'string', 'max:255'],
            'items.*.tool_id' => ['nullable', 'exists:tools,id'],
        ]);

        $borrowRequest = BorrowRequest::create([
            'request_no' => BorrowRequest::generateRequestNo(),
            'user_id' => $request->user()->id,
            'area_unit_id' => $data['area_unit_id'] ?? null,
            'job_type' => $data['job_type'],
            'work_location' => $data['work_location'],
            'planned_start_date' => $data['planned_start_date'],
            'planned_end_date' => $data['planned_end_date'],
            'status' => BorrowRequest::STATUS_DRAFT,
        ]);

        foreach ($data['items'] as $item) {
            $borrowRequest->items()->create([
                'item_no' => $item['item_no'] ?? null,
                'permintaan_alat' => $item['permintaan_alat'],
                'tool_id' => $item['tool_id'] ?? null,
            ]);
        }

        return redirect("/borrow/{$borrowRequest->id}")
            ->with('status', 'Request berhasil dibuat. Silakan submit untuk proses approval.');
    }

    public function show(Request $request, BorrowRequest $borrowRequest)
    {
        $this->authorizeRequestAccess($request, $borrowRequest);

        return view('borrow.show', [
            'request' => $borrowRequest->load(['borrower', 'areaUnit', 'items.tool']),
        ]);
    }

    public function edit(Request $request, BorrowRequest $borrowRequest)
    {
        $this->authorizeRole($request, ['staff', 'admin']);

        return view('borrow.edit', [
            'request' => $borrowRequest->load(['items.tool', 'borrower', 'areaUnit']),
            'areaUnits' => AreaUnit::orderBy('area_name')->get(),
            'tools' => Tool::orderBy('tool_name')->get(),
            'statusOptions' => BorrowRequest::statusLabels(),
        ]);
    }

    public function update(Request $request, BorrowRequest $borrowRequest)
    {
        $this->authorizeRole($request, ['staff', 'admin']);

        if (in_array($borrowRequest->status, [BorrowRequest::STATUS_RETURNED, BorrowRequest::STATUS_REJECTED], true)) {
            return back()->withErrors(['status' => 'Request sudah selesai dan tidak bisa diubah.']);
        }

        $data = $request->validate([
            'job_type' => ['required', 'string', 'max:255'],
            'work_location' => ['required', 'string', 'max:255'],
            'area_unit_id' => ['nullable', 'exists:area_units,id'],
            'planned_start_date' => ['required', 'date'],
            'planned_end_date' => ['required', 'date', 'after_or_equal:planned_start_date'],
            'status' => ['required', Rule::in(array_keys(BorrowRequest::statusLabels()))],
            'items' => ['required', 'array', 'min:1'],
            'items.*.item_no' => ['nullable', 'string', 'max:50'],
            'items.*.permintaan_alat' => ['required', 'string', 'max:255'],
            'items.*.tool_id' => ['nullable', 'exists:tools,id'],
        ]);

        DB::transaction(function () use ($borrowRequest, $data) {
            $borrowRequest->update([
                'job_type' => $data['job_type'],
                'work_location' => $data['work_location'],
                'area_unit_id' => $data['area_unit_id'] ?? null,
                'planned_start_date' => $data['planned_start_date'],
                'planned_end_date' => $data['planned_end_date'],
                'status' => $data['status'],
            ]);

            $borrowRequest->items()->delete();

            foreach ($data['items'] as $item) {
                $borrowRequest->items()->create([
                    'item_no' => $item['item_no'] ?? null,
                    'permintaan_alat' => $item['permintaan_alat'],
                    'tool_id' => $item['tool_id'] ?? null,
                ]);
            }
        });

        return redirect("/borrow/{$borrowRequest->id}")->with('status', 'Request berhasil diperbarui.');
    }

    public function submit(Request $request, BorrowRequest $borrowRequest)
    {
        $this->authorizeRequestAccess($request, $borrowRequest);

        if ($borrowRequest->status !== BorrowRequest::STATUS_DRAFT) {
            return back()->withErrors(['status' => 'Request sudah disubmit.']);
        }

        $borrowRequest->update([
            'status' => BorrowRequest::STATUS_SUBMITTED,
            'submitted_at' => now(),
            'requested_at' => now()->toDateString(),
        ]);

        return back()->with('status', 'Request berhasil disubmit.');
    }

    public function approveL1(Request $request, BorrowRequest $borrowRequest)
    {
        $this->authorizeRole($request, ['staff', 'admin']);

        if ($borrowRequest->status !== BorrowRequest::STATUS_SUBMITTED) {
            return back()->withErrors(['status' => 'Status request tidak sesuai untuk approve L1.']);
        }

        $borrowRequest->update([
            'status' => BorrowRequest::STATUS_APPROVED_L1,
            'approved_l1_by' => $request->user()->id,
            'approved_l1_at' => now(),
            'approved_l1_note' => $request->input('remark'),
        ]);

        return back()->with('status', 'Approve L1 berhasil.');
    }

    public function approveFinal(Request $request, BorrowRequest $borrowRequest)
    {
        $this->authorizeRole($request, ['approval', 'admin']);

        if ($borrowRequest->status !== BorrowRequest::STATUS_APPROVED_L1) {
            return back()->withErrors(['status' => 'Status request tidak sesuai untuk approve final.']);
        }

        $borrowRequest->update([
            'status' => BorrowRequest::STATUS_APPROVED_FINAL,
            'approved_final_by' => $request->user()->id,
            'approved_final_at' => now(),
            'approved_final_note' => $request->input('remark'),
        ]);

        return back()->with('status', 'Approve final berhasil.');
    }

    public function dispatch(Request $request, BorrowRequest $borrowRequest)
    {
        $this->authorizeRole($request, ['staff', 'admin']);

        if ($borrowRequest->status !== BorrowRequest::STATUS_APPROVED_FINAL) {
            return back()->withErrors(['status' => 'Request belum siap untuk dikirim.']);
        }

        $items = $borrowRequest->items()->with('tool')->get();
        if ($items->isEmpty()) {
            return back()->withErrors(['items' => 'Request belum memiliki item.']);
        }

        foreach ($items as $item) {
            if (!$item->tool) {
                return back()->withErrors(['items' => 'Semua item harus memiliki alat sebelum dikirim.']);
            }
            if ($item->tool->availability_status !== Tool::AVAILABILITY_AVAILABLE) {
                return back()->withErrors(['items' => "Alat {$item->tool->tool_name} tidak tersedia."]);
            }
        }

        DB::transaction(function () use ($borrowRequest, $request, $items) {
            foreach ($items as $item) {
                $item->tool->update(['availability_status' => Tool::AVAILABILITY_BORROWED]);
            }

            $borrowRequest->update([
                'status' => BorrowRequest::STATUS_DISPATCHED,
                'dispatched_by' => $request->user()->id,
                'dispatched_at' => now(),
                'dispatch_note' => $request->input('remark'),
            ]);
        });

        return back()->with('status', 'Pengiriman alat berhasil.');
    }

    public function markReturned(Request $request, BorrowRequest $borrowRequest)
    {
        $this->authorizeRole($request, ['staff', 'admin']);

        if ($borrowRequest->status !== BorrowRequest::STATUS_DISPATCHED) {
            return back()->withErrors(['status' => 'Request belum dikirim atau sudah selesai.']);
        }

        $items = $borrowRequest->items()->with('tool')->get();

        DB::transaction(function () use ($borrowRequest, $request, $items) {
            foreach ($items as $item) {
                if ($item->tool) {
                    $item->tool->update(['availability_status' => Tool::AVAILABILITY_AVAILABLE]);
                    $item->update(['return_condition' => $item->tool->condition_status]);
                }
            }

            $borrowRequest->update([
                'status' => BorrowRequest::STATUS_RETURNED,
                'returned_by' => $request->user()->id,
                'returned_at' => now(),
                'return_note' => $request->input('remark'),
            ]);
        });

        return back()->with('status', 'Pengembalian berhasil dicatat.');
    }

    private function authorizeRole(Request $request, array $roles): void
    {
        $user = $request->user();

        if (!$user || ($user->hasRole('admin') === false && !$user->hasAnyRole($roles))) {
            abort(403);
        }
    }

    private function authorizeRequestAccess(Request $request, BorrowRequest $borrowRequest): void
    {
        $user = $request->user();

        if (!$user) {
            abort(403);
        }

        if ($user->hasRole('admin') || $user->hasRole('staff') || $user->hasRole('approval')) {
            return;
        }

        if ($borrowRequest->user_id !== $user->id) {
            abort(403);
        }
    }
}
