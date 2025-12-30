<?php

namespace App\Http\Controllers;

use App\Models\BorrowRequest;
use App\Models\Tool;

class DashboardController extends Controller
{
    public function index()
    {
        $totalTools = Tool::count();
        $availableTools = Tool::where('availability_status', Tool::AVAILABILITY_AVAILABLE)->count();
        $borrowedTools = Tool::where('availability_status', Tool::AVAILABILITY_BORROWED)->count();
        $maintenanceTools = Tool::where('availability_status', Tool::AVAILABILITY_MAINTENANCE)->count();
        $inactiveTools = Tool::where('availability_status', Tool::AVAILABILITY_INACTIVE)->count();

        $activeRequests = BorrowRequest::whereIn('status', [
            BorrowRequest::STATUS_SUBMITTED,
            BorrowRequest::STATUS_APPROVED_L1,
            BorrowRequest::STATUS_APPROVED_FINAL,
            BorrowRequest::STATUS_DISPATCHED,
        ])->count();

        $pendingApproval = BorrowRequest::whereIn('status', [
            BorrowRequest::STATUS_SUBMITTED,
            BorrowRequest::STATUS_APPROVED_L1,
        ])->count();

        $overdue = BorrowRequest::where('status', BorrowRequest::STATUS_DISPATCHED)
            ->whereNotNull('planned_end_date')
            ->whereDate('planned_end_date', '<', now()->toDateString())
            ->count();

        return view('dashboard.index', [
            'totalTools' => $totalTools,
            'availableTools' => $availableTools,
            'borrowedTools' => $borrowedTools,
            'maintenanceTools' => $maintenanceTools,
            'inactiveTools' => $inactiveTools,
            'activeRequests' => $activeRequests,
            'pendingApproval' => $pendingApproval,
            'overdueRequests' => $overdue,
        ]);
    }
}
