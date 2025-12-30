<?php

namespace App\Http\Controllers;

use App\Models\BorrowRequest;
use App\Models\Tool;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    public function exportRequests(): StreamedResponse
    {
        $requests = BorrowRequest::with(['borrower', 'areaUnit', 'items.tool'])->orderByDesc('created_at')->get();

        return response()->streamDownload(function () use ($requests) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, [
                'Request No',
                'Tanggal Permintaan',
                'Jenis Pekerjaan',
                'Nama Peminjam',
                'Area/Unit',
                'Status',
                'Nama Alat',
                'Kode Asset',
            ]);

            foreach ($requests as $request) {
                foreach ($request->items as $item) {
                    fputcsv($handle, [
                        $request->request_no,
                        $request->requested_at?->format('Y-m-d'),
                        $request->job_type,
                        $request->borrower?->name,
                        $request->areaUnit?->area_name,
                        $request->status,
                        $item->tool?->tool_name,
                        $item->tool?->asset_no,
                    ]);
                }
            }

            fclose($handle);
        }, 'laporan_peminjaman.csv');
    }

    public function exportTools(): StreamedResponse
    {
        $tools = Tool::with(['category', 'location'])->orderBy('tool_name')->get();

        return response()->streamDownload(function () use ($tools) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, [
                'Asset No',
                'Barcode',
                'Nama',
                'Kategori',
                'Lokasi',
                'Kondisi',
                'Status',
            ]);

            foreach ($tools as $tool) {
                fputcsv($handle, [
                    $tool->asset_no,
                    $tool->barcode,
                    $tool->tool_name,
                    $tool->category?->category_name,
                    $tool->location?->location_name,
                    $tool->condition_status,
                    $tool->availability_status,
                ]);
            }

            fclose($handle);
        }, 'master_alat.csv');
    }

    public function exportDamage(): StreamedResponse
    {
        return response()->streamDownload(function () {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, [
                'Ticket',
                'Tanggal Kerusakan',
                'Nama Alat',
                'Status',
            ]);
            fclose($handle);
        }, 'laporan_kerusakan.csv');
    }
}
