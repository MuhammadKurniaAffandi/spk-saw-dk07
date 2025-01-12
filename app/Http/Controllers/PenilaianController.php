<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penilaian;
use App\Models\Guru;
use App\Models\Kriteria;
use App\Models\Crips;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
// use DB;
use Exception;
use Illuminate\Support\Facades\DB;
// use PDF;



class PenilaianController extends Controller
{
    public function index()
    {
        $guru = Guru::with('penilaian.crips')->get();

        $kriteria = Kriteria::with('crips')->orderBy('id', 'ASC')->get();
        // dd($kriteria);
        //return response()->json($guru);
        return view('admin.penilaian.index', compact('guru', 'kriteria'));
    }

    public function store(Request $request)
    {
        // return response()->json($request);

        try {

            DB::select("TRUNCATE penilaian");
            foreach ($request->crips_id as $key => $value) {
                foreach ($value as $key_1 => $value_1) {
                    Penilaian::create([
                        'guru_id' => $key,
                        'crips_id' => $value_1,

                    ]);
                }
            }

            return back()->with('msg', 'Berhasil Menyimpan Data');
        } catch (Exception $e) {
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            die("Gagal");
        }
    }

    public function downloadPDF()
    {
        // setlocale(LC_ALL, 'IND');
        // $tanggal = Carbon::now()->formatLocalized(' %d %B %Y');
        // $penilaian = Kriteria::get();
        // $guru = guru::with('penilaian.crips')->get();
        // $kriteria = Kriteria::with('crips')->get();
        $tanggal = Carbon::now()->translatedFormat('d F Y'); // ** Output: "01 Maret 2019" **
        $guru = Guru::with('penilaian.crips')->get();
        $kriteria = Kriteria::with('crips')->orderBy('id', 'ASC')->get();
        $penilaian = Penilaian::with('crips', 'guru')->get();

        $pdf = PDF::loadView('admin.penilaian.penilaian-pdf', compact('kriteria', 'tanggal', 'guru', 'penilaian'));
        $pdf->setPaper('A3', 'potrait');
        return $pdf->stream('penilaian.pdf');
    }
}
