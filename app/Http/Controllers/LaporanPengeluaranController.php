<?php

namespace App\Http\Controllers;

use App\Models\Pengeluaran;
use Illuminate\Http\Request;
use Barryvdh\Snappy\Facades\SnappyPdf;
use Carbon\Carbon;

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

    public function exportPdf()
    {
        $pengeluaran = Pengeluaran::all(); // Ambil data dari database

        $pdf = SnappyPdf::loadView('laporan_pengeluaran.exportPDF', compact('pengeluaran'))
            ->setPaper('a4')
            ->setOption('orientation', 'landscape');

        return $pdf->download('laporan_pengeluaran.pdf');
    }
}
