<?php

namespace App\Http\Controllers;

use App\Models\Guru;
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
        $guru = Guru::with('penilaian')->get();
        $kriteria = Kriteria::orderBy('id', 'ASC')->get();
        $penilaian = Penilaian::with('kriteria', 'guru')->get();

        if (count($penilaian) == 0) {
            return redirect(route('penilaian.index'));
        }

        // ** Mencari Min dan Max untuk Normalisasi **
        $minMax = [];
        foreach ($kriteria as $key_kriteria) {
            $nilaiKriteria = $penilaian->where('kriteria_id', $key_kriteria->id)->pluck('nilai');
            $minMax[$key_kriteria->id] = [
                'max' => $nilaiKriteria->max(),
                'min' => $nilaiKriteria->min()
            ];
        }

        // ** Normalisasi **
        $normalisasi = [];
        foreach ($penilaian as $key_penilaian) {
            $kriteriaId = $key_penilaian->kriteria_id;
            $guruName = $key_penilaian->guru->nama_guru;

            if (isset($minMax[$kriteriaId])) {
                if ($key_penilaian->kriteria->attribut === 'Benefit') {
                    $normalisasi[$guruName][$kriteriaId] = $key_penilaian->nilai / $minMax[$kriteriaId]['max'];
                } elseif ($key_penilaian->kriteria->attribut === 'Cost') {
                    $normalisasi[$guruName][$kriteriaId] = $minMax[$kriteriaId]['min'] / $key_penilaian->nilai;
                }
            }
        }

        // ** Perangkingan **
        $rank = [];
        foreach ($normalisasi as $guruName => $values) {
            $rank[$guruName] = 0;
            foreach ($kriteria as $key_kriteria) {
                $rank[$guruName] += ($values[$key_kriteria->id] ?? 0) * ($key_kriteria->bobot / 100);
            }
        }

        // Urutkan berdasarkan nilai tertinggi
        $sortedData = collect($rank)->sortDesc();

        return view('admin.analisa.index', compact('guru', 'kriteria', 'normalisasi', 'sortedData'));
    }
    // **Akhir Menu Perhitungan**

    // **Awal Menu Laporan**
    public function simpanLaporan(Request $request)
    {
        $request->validate([
            'periode' => 'required|date',
            'selected_data' => 'array',
        ]);
        $selectedData = $request->input('selected_data');
        $periode =  Carbon::parse($request->input('periode'))->translatedFormat('F Y'); // ** Output: "Maret 2019" **

        $guru = Guru::with('penilaian')->get();
        $kriteria = Kriteria::orderBy('id', 'ASC')->get();
        $penilaian = Penilaian::with('kriteria', 'guru')->get();

        try {

            if (count($penilaian) == 0) {
                return redirect(route('penilaian.index'));
            }

            // ** Mencari Min dan Max untuk Normalisasi **
            $minMax = [];
            foreach ($kriteria as $key_kriteria) {
                $nilaiKriteria = $penilaian->where('kriteria_id', $key_kriteria->id)->pluck('nilai');
                $minMax[$key_kriteria->id] = [
                    'max' => $nilaiKriteria->max(),
                    'min' => $nilaiKriteria->min()
                ];
            }

            // ** Normalisasi **
            $normalisasi = [];
            foreach ($penilaian as $key_penilaian) {
                $kriteriaId = $key_penilaian->kriteria_id;
                $guruName = $key_penilaian->guru->nama_guru;

                if (isset($minMax[$kriteriaId])) {
                    if ($key_penilaian->kriteria->attribut === 'Benefit') {
                        $normalisasi[$guruName][$kriteriaId] = $key_penilaian->nilai / $minMax[$kriteriaId]['max'];
                    } elseif ($key_penilaian->kriteria->attribut === 'Cost') {
                        $normalisasi[$guruName][$kriteriaId] = $minMax[$kriteriaId]['min'] / $key_penilaian->nilai;
                    }
                }
            }

            // ** Perangkingan **
            $rank = [];
            foreach ($normalisasi as $guruName => $values) {
                $rank[$guruName] = 0;
                foreach ($kriteria as $key_kriteria) {
                    $rank[$guruName] += ($values[$key_kriteria->id] ?? 0) * ($key_kriteria->bobot / 100);
                }
            }
            // Urutkan berdasarkan nilai tertinggi
            $sortedData = collect($rank)->sortDesc();

            // Validasi input
            /* $request->validate([
                'selected_data' => 'array',
            ]);
            $selectedData = $request->input('selected_data'); */

            /// Bentuk array terstruktur
            $hasilKeputusan = [];
            if (!empty($selectedData)) {
                foreach ($selectedData as $data) {
                    $decodedData = json_decode($data, true); // Decode JSON string ke array
                    $hasilKeputusan[] = [
                        'nama' => $decodedData['nama'],
                        'nilai' => $decodedData['nilai'],
                    ];
                }
            }

            // ** Simpan ke database **
            $data = [
                'guru' => $guru,
                'kriteria' => $kriteria,
                'normalisasi' => $normalisasi,
                'ranking' => $sortedData,
            ];

            // Tambahkan hasilKeputusan jika tidak kosong
            if (!empty($hasilKeputusan)) {
                $data['hasilKeputusan'] = $hasilKeputusan;
            }

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
}




// ** Fungsi Yang Gak dipake **
/* $guru = Guru::with('penilaian.crips')->get();
$kriteria = Kriteria::with('crips')->orderBy('id', 'ASC')->get();
$penilaian = Penilaian::with('crips', 'guru')->get();

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
                $normalisasi[$value_1->guru->nama_guru][$value->id] = $value_1->crips->bobot / max($minMax[$value->id]);
            } elseif ($value->attribut == 'Cost') {
                $normalisasi[$value_1->guru->nama_guru][$value->id] = min($minMax[$value->id]) / $value_1->crips->bobot;
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
 */



    /* public function downloadPDF(Request $request)
    {
        setlocale(LC_ALL, 'IND');
        $tanggal = Carbon::now()->formatLocalized(' %d %B %Y');
        $tanggalPeriode = Carbon::now()->formatLocalized(' %B %Y');
        $guru = guru::with('penilaian.crips')->get();
        $kriteria = Kriteria::with('crips')->orderBy('nama_kriteria', 'ASC')->get();
        $penilaian = Penilaian::with('crips', 'guru')->get();


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
                        $normalisasi[$value_1->guru->nama_guru][$value->id] = $value_1->crips->bobot / max($minMax[$value->id]);
                    } elseif ($value->attribut == 'Cost') {
                        $normalisasi[$value_1->guru->nama_guru][$value->id] = min($minMax[$value->id]) / $value_1->crips->bobot;
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


        $pdf = PDF::loadView('admin.perhitungan.perhitungan-pdf', compact('guru', 'kriteria', 'normalisasi', 'sortedData', 'tanggal', 'tanggalPeriode'));
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


     /* $guru = Guru::with('penilaian.crips')->get();
        $kriteria = Kriteria::with('crips')->orderBy('id', 'ASC')->get();
        $penilaian = Penilaian::with('crips', 'guru')->get();

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
                            $normalisasi[$value_1->guru->nama_guru][$value->id] = $value_1->crips->bobot / max($minMax[$value->id]);
                        } elseif ($value->attribut == 'Cost') {
                            $normalisasi[$value_1->guru->nama_guru][$value->id] = min($minMax[$value->id]) / $value_1->crips->bobot;
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
            })->toArray(); */
