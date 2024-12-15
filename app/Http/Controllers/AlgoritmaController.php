<?php

namespace App\Http\Controllers;

use App\Models\Alternatif;
use App\Models\Kriteria;
use App\Models\Laporan;
use App\Models\Penilaian;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AlgoritmaController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    }

    // **Awal Menu Perhitungan**
    public function index(Request $request)
    {

        // **Ambil data alternatif dan kriteria**
        $alternatif = Alternatif::with('penilaian.crips')->get();
        $kriteria = Kriteria::with('crips')->orderBy('id', 'ASC')->get();
        $penilaian = Penilaian::with('crips', 'alternatif')->get();

        if (count($penilaian) == 0) {
            return redirect(route('penilaian.index'));
        }


        // ** Mencari min max normalisasi **
        foreach ($kriteria as $key => $value) {
            foreach ($penilaian as $key_1 => $value_1) {
                if ($value->id == $value_1->crips->kriteria_id) {
                    if ($value->attribut == 'Benefit') {
                        $minMax[$value->id][] = $value_1->crips->bobot;
                    } elseif ($value->attribut == 'Cost') {
                        $minMax[$value->id][] = $value_1->crips->bobot;
                    }
                }
            }
        }

        // ** Normalisasi **
        foreach ($penilaian as $key_1 => $value_1) {
            foreach ($kriteria as $key => $value) {
                if ($value->id == $value_1->crips->kriteria_id) {
                    if ($value->attribut == 'Benefit') {
                        $normalisasi[$value_1->alternatif->nama_alternatif][$value->id] = $value_1->crips->bobot / max($minMax[$value->id]);
                    } elseif ($value->attribut == 'Cost') {
                        $normalisasi[$value_1->alternatif->nama_alternatif][$value->id] = min($minMax[$value->id]) / $value_1->crips->bobot;
                    }
                }
            }
        }


        // ** Perangkingan **
        foreach ($normalisasi as $key => $value) {
            foreach ($kriteria as $key_1 => $value_1) {
                $rank[$key][] = ($value[$value_1->id] * $value_1->bobot);
            }
        }


        $ranking = $normalisasi;
        foreach ($normalisasi as $key => $value) {
            $ranking[$key][] = array_sum($rank[$key]) / 100;
        }
        $sortedData = collect($ranking)->sortByDesc(function ($value) {
            return array_sum($value);
        })->toArray();

        return view('admin.perhitungan.index', compact('alternatif', 'kriteria', 'normalisasi', 'sortedData'));
    }
    // **Akhir Menu Perhitungan**

    // **Awal Menu Laporan**
    public function simpanLaporan()
    {
        setlocale(LC_ALL, 'IND');
        $periode = Carbon::now()->formatLocalized('%B %Y');
        // $periode = Carbon::now()->format('d-m-Y'); // Menggunakan format YYYY-MM
        $alternatif = Alternatif::with('penilaian.crips')->get();
        $kriteria = Kriteria::with('crips')->orderBy('id', 'ASC')->get();
        $penilaian = Penilaian::with('crips', 'alternatif')->get();

        if (count($penilaian) == 0) {
            return redirect(route('penilaian.index'));
        }

        try {
            // ** Mencari min max normalisasi
            foreach ($kriteria as $key => $value) {
                foreach ($penilaian as $key_1 => $value_1) {
                    if ($value->id == $value_1->crips->kriteria_id) {
                        if ($value->attribut == 'Benefit') {
                            $minMax[$value->id][] = $value_1->crips->bobot;
                        } elseif ($value->attribut == 'Cost') {
                            $minMax[$value->id][] = $value_1->crips->bobot;
                        }
                    }
                }
            }


            // ** Normalisasi
            foreach ($penilaian as $key_1 => $value_1) {
                foreach ($kriteria as $key => $value) {
                    if ($value->id == $value_1->crips->kriteria_id) {
                        if ($value->attribut == 'Benefit') {
                            $normalisasi[$value_1->alternatif->nama_alternatif][$value->id] = $value_1->crips->bobot / max($minMax[$value->id]);
                        } elseif ($value->attribut == 'Cost') {
                            $normalisasi[$value_1->alternatif->nama_alternatif][$value->id] = min($minMax[$value->id]) / $value_1->crips->bobot;
                        }
                    }
                }
            }


            // ** Perangkingan
            foreach ($normalisasi as $key => $value) {
                foreach ($kriteria as $key_1 => $value_1) {
                    $rank[$key][] = ($value[$value_1->id] * $value_1->bobot);
                }
            }


            $ranking = $normalisasi;
            foreach ($normalisasi as $key => $value) {
                $ranking[$key][] = array_sum($rank[$key]) / 100;
            }
            $sortedData = collect($ranking)->sortByDesc(function ($value) {
                return array_sum($value);
            })->toArray();

            // ** Simpan ke database **
            $data = [
                'alternatif' => $alternatif,
                'kriteria' => $kriteria,
                'normalisasi' => $normalisasi,
                'ranking' => $sortedData,
            ];

            Laporan::create([
                'periode' => $periode,
                'data' => $data,
            ]);
            return back()->with('msg', 'Data Perhitungan Berhasil Disimpan!');
        } catch (Exception $e) {
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            die("Gagal");
        }
    }

    // **Akhir Menu Laporan**


    // ** Fungsi Yang Gak dipake **
    /* public function downloadPDF(Request $request)
    {
        setlocale(LC_ALL, 'IND');
        $tanggal = Carbon::now()->formatLocalized(' %d %B %Y');
        $tanggalPeriode = Carbon::now()->formatLocalized(' %B %Y');
        $alternatif = Alternatif::with('penilaian.crips')->get();
        $kriteria = Kriteria::with('crips')->orderBy('nama_kriteria', 'ASC')->get();
        $penilaian = Penilaian::with('crips', 'alternatif')->get();


        if (count($penilaian) == 0) {
            return redirect(route('penilaian.index'));
        }
        //mencari min max normalisasi
        foreach ($kriteria as $key => $value) {
            foreach ($penilaian as $key_1 => $value_1) {
                if ($value->id == $value_1->crips->kriteria_id) {
                    if ($value->attribut == 'Benefit') {
                        $minMax[$value->id][] = $value_1->crips->bobot;
                    } elseif ($value->attribut == 'Cost') {
                        $minMax[$value->id][] = $value_1->crips->bobot;
                    }
                }
            }
        }

        //Normalisasi

        foreach ($penilaian as $key_1 => $value_1) {
            foreach ($kriteria as $key => $value) {
                if ($value->id == $value_1->crips->kriteria_id) {
                    if ($value->attribut == 'Benefit') {
                        $normalisasi[$value_1->alternatif->nama_alternatif][$value->id] = $value_1->crips->bobot / max($minMax[$value->id]);
                    } elseif ($value->attribut == 'Cost') {
                        $normalisasi[$value_1->alternatif->nama_alternatif][$value->id] = min($minMax[$value->id]) / $value_1->crips->bobot;
                    }
                }
            }
        }


        // Perangkingan
        foreach ($normalisasi as $key => $value) {
            foreach ($kriteria as $key_1 => $value_1) {
                $rank[$key][] = $value[$value_1->id] * $value_1->bobot;
            }
        }
        $ranking = $normalisasi;
        foreach ($normalisasi as $key => $value) {
            $ranking[$key][] = array_sum($rank[$key]) / 100;
        }

        //   arsort($ranking);

        $sortedData = collect($ranking)->sortByDesc(function ($value) {
            return array_sum($value);
        })->toArray();


        $pdf = PDF::loadView('admin.perhitungan.perhitungan-pdf', compact('alternatif', 'kriteria', 'normalisasi', 'sortedData', 'tanggal', 'tanggalPeriode'));
        $pdf->setPaper('A3', 'potrait');
        return $pdf->stream('perhitungan.pdf');
    } */

    // Simpan ke database
    /* Laporan::updateOrCreate(
        [
            'periode' => $periode,
        ],
        [
            'data' => $data,
        ]
    ); */
}
