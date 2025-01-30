<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Guru;
use App\Models\Penilaian;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
//use PDF;
use Carbon\Carbon;
use Exception;

class GuruController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        $data['guru'] = Guru::latest()->paginate(10);
        return view('admin.guru.index', $data);
    }

    public function store(Request $request)
    {
        $this->validate($request, [

            'nama_guru' => 'required|string',
            'jabatan' => 'required|string',
            'kelas' => 'required|string',
            // 'tanggal_lahir' => 'required|string',

        ]);

        try {

            $guru = new Guru();
            $guru->nama_guru = $request->nama_guru;
            $guru->jabatan = $request->jabatan;
            $guru->kelas = $request->kelas;
            // $guru->tanggal_lahir = $request->tanggal_lahir;
            $guru->save();
            return back()->with('msg', 'Berhasil Menambahkan Data');
        } catch (Exception $e) {
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            die("Gagal");
        }
    }


    public function edit($id)
    {
        $data['guru'] = Guru::findOrFail($id);
        return view('admin.guru.edit', $data);
    }


    public function update(Request $request, $id)
    {

        $this->validate($request, [

            'nama_guru' => 'required|string',
            'jabatan' => 'required|string',
            'kelas' => 'required|string',
            // 'tanggal_lahir' => 'required|string',

        ]);

        try {

            $guru = Guru::findOrFail($id);
            $guru->update([
                'nama_guru' => $request->nama_guru,
                'jabatan' => $request->jabatan,
                'kelas' => $request->kelas,
                // 'tanggal_lahir' => $request->tanggal_lahir
            ]);
            return back()->with('msg', 'Berhasil Mengubah Data');
        } catch (Exception $e) {
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            die("Gagal");
        }
    }

    public function destroy($id)
    {

        try {

            $guru = Guru::findOrFail($id);
            $guru->delete();
            Penilaian::truncate();
        } catch (Exception $e) {
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            die("Gagal");
        }
    }

    public function downloadPDF()
    {
        // setlocale(LC_ALL, 'IND');
        // $tanggal = Carbon::now()->formatLocalized('%d %B %Y');
        $tanggal = Carbon::now()->translatedFormat('d F Y'); // ** Output: "01 Maret 2019" **
        $guru = Guru::with('penilaian.kriteria')->get();

        $pdf = Pdf::loadView('admin.guru.guru-pdf', compact('guru', 'tanggal'));

        $pdf->setPaper('A4', 'potrait');
        return $pdf->stream('guru.pdf');
    }
}
