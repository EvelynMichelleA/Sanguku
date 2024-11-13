<?php

namespace App\Http\Controllers;

use App\Models\Pengeluaran;
use Illuminate\Http\Request;
use Barryvdh\Snappy\Facades\SnappyPdf;
use Carbon\Carbon;
use App\Models\TransaksiPengeluaran;
use Illuminate\Support\Facades\View;

class LaporanPengeluaranController extends Controller
{
    public function index()
    {
        // Ambil parameter start_date dan end_date dari query string
        $start_date = request()->query('start_date');
        $end_date = request()->query('end_date');

        $query = Pengeluaran::with('user')->orderBy('tanggal', 'desc');

        // Cek apakah filter diterapkan
        if (!empty($start_date) && !empty($end_date)) {
            try {
                // Konversi tanggal dari dd/mm/yyyy ke yyyy-mm-dd
                $start_date = Carbon::createFromFormat('d/m/Y', $start_date)->format('Y-m-d');
                $end_date = Carbon::createFromFormat('d/m/Y', $end_date)->format('Y-m-d');

                // Filter berdasarkan tanggal
                $query->whereBetween('tanggal', [$start_date, $end_date]);
            } catch (\Exception $e) {
                return back()->withErrors(['message' => 'Format tanggal tidak valid. Pastikan format dd/mm/yyyy.']);
            }
        }

        $pengeluaran = $query->get();

        return view('laporan_pengeluaran.index', compact('pengeluaran'));
    }

    public function export(Request $request)
    {
        // Ambil filter tanggal dari request
        $start_date = $request->input('start_date', now()->startOfMonth()->format('Y-m-d'));
        $end_date = $request->input('end_date', now()->format('Y-m-d'));

        // Ambil data berdasarkan filter tanggal
        $pengeluaran = Pengeluaran::whereBetween('tanggal_pengeluaran', [$start_date, $end_date])->get();

        // Generate HTML laporan
        $html = View::make('laporan_pengeluaran.export', [
            'pengeluaran' => $pengeluaran,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'totalPengeluaran' => $pengeluaran->sum('total_pengeluaran'),
        ])->render();

        // Cetak ke browser (tanpa library tambahan)
        return response($html)
            ->header('Content-Type', 'application/vnd.ms-excel')
            ->header('Content-Disposition', 'attachment;filename="laporan_pengeluaran.xls"');
    }
}
