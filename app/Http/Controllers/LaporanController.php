<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use Illuminate\Http\Request;

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

        return view('admin.laporan.show', compact('laporan'));
    }
}
