<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LaporanController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    }

    public function index(Request $request)
    {

        // Ambil periode terbaru
        // $laporanTerbaru = Laporan::latest()->first();
        // $periodeTerpilih = $laporanTerbaru ? $laporanTerbaru->periode : null;

        // Semua periode untuk dropdown
        // $daftarPeriode = Laporan::orderBy('periode', 'desc')->pluck('periode')->unique();

        // return view('admin.laporan.index', compact('laporanTerbaru', 'daftarPeriode', 'periodeTerpilih'));

        $data = Laporan::orderBy('id', 'DESC')->paginate(10);
        return view('admin.laporan.index', compact('data'));
    }

    public function show($id)
    {
        // $laporan = Laporan::where('periode', $periode)->get();

        // Semua periode untuk dropdown
        // $daftarPeriode = Laporan::orderBy('periode', 'desc')->pluck('periode')->unique();
        // return view('admin.laporan.repot', compact('laporan', 'daftarPeriode', 'periode'));
        // $data['crips'] = Crips::where('kriteria_id', $id)->paginate(10);
        $laporan = Laporan::findOrFail($id);
        $sortedData = collect($laporan['data']['ranking'])->sortByDesc(function ($value) {
            return array_sum($value);
        })->toArray();

        return view('admin.laporan.show', compact('laporan', 'sortedData'));
    }

    public function destroy($id)
    {

        try {

            $laporan = Laporan::findOrFail($id);

            $laporan->delete();
        } catch (Exception $e) {
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            die("Gagal");
        }
    }

    public function cetakLaporan($id)
    {
        setlocale(LC_ALL, 'IND');
        $tanggal = Carbon::now()->formatLocalized(' %d %B %Y');
        $tanggalPeriode = Carbon::now()->formatLocalized(' %B %Y');
        $laporan = Laporan::findOrFail($id);
        $sortedData = collect($laporan['data']['ranking'])->sortByDesc(function ($value) {
            return array_sum($value);
        })->toArray();
        // dd($laporan['data'], $laporan['data']['kriteria'], $laporan['data']['ranking'], $sortedData);

        $pdf = PDF::loadView('admin.laporan.laporan-pdf', compact('laporan', 'tanggal', 'tanggalPeriode', 'sortedData'));
        $pdf->setPaper('A3', 'potrait');
        return $pdf->stream('laporan.pdf');
    }
}
