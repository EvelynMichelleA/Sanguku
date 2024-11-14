<?php

namespace App\Http\Controllers;

use Carbon\Carbon;

use App\Models\Pengeluaran;
use Illuminate\Http\Request;
use App\Models\TransaksiPengeluaran;
use Illuminate\Support\Facades\View;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanPengeluaranController extends Controller
{
    public function index()
    {
        // Ambil parameter filter dari query string
        $start_date = request('start_date');
        $end_date = request('end_date');

        // Query dasar
        $query = Pengeluaran::with('user');

        // Filter berdasarkan tanggal jika parameter tersedia
        if (!empty($start_date) && !empty($end_date)) {
            $query->whereBetween('tanggal_pengeluaran', [$start_date, $end_date]);
        } elseif (!empty($start_date)) {
            $query->whereDate('tanggal_pengeluaran', '>=', $start_date);
        } elseif (!empty($end_date)) {
            $query->whereDate('tanggal_pengeluaran', '<=', $end_date);
        }

        // Ambil data hasil filter dengan pagination
        $pengeluaran = $query->orderBy('tanggal_pengeluaran', 'desc')->paginate(10);

        // Kirim data ke view
        return view('laporan_pengeluaran.index', compact('pengeluaran'));
    }
    
    public function exportPDF()
    {
        // Ambil parameter filter dari query string
        $start_date = request('start_date');
        $end_date = request('end_date');

        // Query dasar
        $query = Pengeluaran::with('user');

        // Filter berdasarkan tanggal jika parameter tersedia
        if (!empty($start_date) && !empty($end_date)) {
            $query->whereBetween('tanggal_pengeluaran', [$start_date, $end_date]);
        } elseif (!empty($start_date)) {
            $query->whereDate('tanggal_pengeluaran', '>=', $start_date);
        } elseif (!empty($end_date)) {
            $query->whereDate('tanggal_pengeluaran', '<=', $end_date);
        }

        // Ambil semua data hasil filter
        $pengeluaran = $query->orderBy('tanggal_pengeluaran', 'desc')->get();

        // Kirim data ke view PDF
        $pdf = Pdf::loadView('laporan_pengeluaran.pdf', compact('pengeluaran', 'start_date', 'end_date'));

        // Unduh file PDF
        return $pdf->download('laporan_pengeluaran.pdf');
    }
}
