<?php

namespace App\Http\Controllers;

use App\Models\BorrowRequest;
use App\Models\Tool;

class DashboardController extends Controller
{
    public function index()
    {
        // ---- TOOLS ----
        $totalTools = Tool::count();

        $availableTools   = Tool::where('current_status', 'tersedia')->count();
        $borrowedTools    = Tool::where('current_status', 'dipinjam')->count();
        $maintenanceTools = Tool::where('current_status', 'diperbaiki')->count();
        $inactiveTools    = Tool::where('current_status', 'lost')->count();

        // ---- BORROW REQUEST ----
        $activeRequests = BorrowRequest::count();

        // sementara — menunggu status sistem selesai
        $pendingApproval = 0;
        $overdueRequests = 0;

        return view('dashboard.index', [
            'totalTools'       => $totalTools,
            'availableTools'   => $availableTools,
            'borrowedTools'    => $borrowedTools,
            'maintenanceTools' => $maintenanceTools,
            'inactiveTools'    => $inactiveTools,
            'activeRequests'   => $activeRequests,
            'pendingApproval'  => $pendingApproval,
            'overdueRequests'  => $overdueRequests,
        ]);
    }
}
