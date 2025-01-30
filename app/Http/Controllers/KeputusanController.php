<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class KeputusanController extends Controller
{
    //
    public function __construct()
    {
        return $this->middleware('auth');
    }

    // *** dihandle dari LaporanController**
    /* public function index(Request $request)
    {
        $data = Laporan::orderBy('id', 'DESC')->paginate(10);
        $keputusan = Laporan::all();
        return view('admin.keputusan.index', compact('data', 'keputusan'));
    } */

    public function show($id)
    {
        $laporan = Laporan::findOrFail($id);
        $hasilKeputusan = $laporan['data']['hasilKeputusan'] ?? [];
        return view('admin.keputusan.show', compact('laporan',  'hasilKeputusan'));
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

    public function cetakPDF($id)
    {
        // setlocale(LC_ALL, 'IND');
        // $tanggal = Carbon::now()->formatLocalized(' %d %B %Y');
        $tanggal = Carbon::now()->translatedFormat('d F Y'); // ** Output: "01 Maret 2019" **
        $laporan = Laporan::findOrFail($id);
        $hasilKeputusan = $laporan['data']['hasilKeputusan'] ?? [];
        $pdf = PDF::loadView('admin.keputusan.keputusan-pdf', compact('laporan', 'tanggal', 'hasilKeputusan'));
        $pdf->setPaper('A4', 'potrait');
        return $pdf->stream('keputusan.pdf');
    }
}
