@extends('layouts.app')
@section('title', 'SPK Pemilihan Guru Terbaik')
@section('content')

    {{-- ** Awal Area Button ** --}}
    <div class="mb-4">
        <!-- Card Header - Accordion -->
        <div class="row">

            <div class="col">
                @if (Session::has('msg'))
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        <strong>{{ Session::get('msg') }}</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                <form action="{{ route('perhitungan.simpan') }}" method="POST">
                    @csrf
                    <button type="submit" class="d-sm-inline-block btn btn-sm btn-success shadow-sm float-left">
                        <i class="fas fa-save fa-sm text-white-50"></i> Simpan Perhitungan
                    </button>
                </form>
            </div>
        </div>
    </div>
    {{-- ** Akhir Area Button ** --}}

    {{-- ** Awal Tabel Rating Kecocokan ** --}}
    <div class="card shadow mb-4">
        <!-- Card Header - Accordion -->
        <a href="#listkriteria" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true"
            aria-controls="collapseCardExample">
            <h6 class="m-0 font-weight-bold text-primary text-center">RATING KECOCOKAN</h6>
        </a>

        <!-- Card Content - Collapse -->
        <div class="collapse show" id="listkriteria">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="text-align: center; padding-bottom: 35px" rowspan="2">Nama Guru</th>
                                <th class="text-center" colspan="{{ count($kriteria) }}">Kriteria</th>
                            </tr>
                            <tr>
                                @foreach ($kriteria as $key => $value)
                                    <th class="text-center">{{ $value->nama_kriteria }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($alternatif as $alt => $valt)
                                <tr>
                                    <td class="text-left">
                                        <div class="text-wrap" style="width: 6rem">{{ $valt->nama_alternatif }}
                                        </div>
                                    </td>
                                    @if (count($valt->penilaian) > 0)
                                        @foreach ($valt->penilaian as $key => $value)
                                            <td class="text-center">
                                                {{ $value->crips->bobot }}
                                            </td>
                                        @endforeach
                                    @endif
                                </tr>
                            @empty
                                <tr>
                                    <td>Tidak ada data!</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    {{-- ** Akhir Tabel Rating Kecocokan ** --}}

    {{-- ** Awal Tabel Normalisasi Matriks ** --}}
    <div class="card shadow mb-4">
        <!-- Card Header - Accordion -->
        <a href="#normalisasi" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true"
            aria-controls="collapseCardExample">
            <h6 class="m-0 font-weight-bold text-primary text-center">NORMALISASI MATRIK</h6>
        </a>

        <!-- Card Content - Collapse -->
        <div class="collapse show" id="normalisasi">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="text-align: center; padding-bottom: 35px" rowspan="2">Nama Guru</th>
                                <th class="text-center" colspan="{{ count($kriteria) }}">Kriteria</th>

                            </tr>
                            <tr>
                                @foreach ($kriteria as $key => $value)
                                    <th class="text-center">{{ $value->nama_kriteria }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($normalisasi as $key => $value)
                                <tr>
                                    <td class="text-left">
                                        <div class="text-wrap" style="width: 6rem">{{ $key }}
                                        </div>
                                    </td>
                                    @foreach ($value as $key_1 => $value_1)
                                        <td class="text-center">
                                            {{ round($value_1, 2) }}
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    {{-- ** Akhir Tabel Normalisasi Matriks ** --}}

    {{-- ** Awal Tabel Tahap Perangkingan ** --}}
    <div class="card shadow mb-4">
        <!-- Card Header - Accordion -->
        <a href="#rank" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true"
            aria-controls="collapseCardExample">
            <h6 class="m-0 font-weight-bold text-primary text-center">TAHAP PERANGKINGAN</h6>
        </a>

        <!-- Card Content - Collapse -->
        <div class="collapse show" id="rank">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="text-bold" style="text-align: center; padding-bottom: 60px" rowspan="2">Nama
                                    Guru</th>
                                <th class="text-center" colspan="{{ count($kriteria) }}">Kriteria Dan Bobot</th>
                                <th rowspan="2" style="text-align: center; padding-bottom: 60px">Nilai Akhir</th>
                                <th rowspan="2" style="text-align: center; padding-bottom: 60px">Rangking</th>
                            </tr>
                            <tr>
                                @foreach ($kriteria as $key => $value)
                                    <th class="text-center">{{ $value->nama_kriteria }}<br>{{ round($value->bobot, 2) }}%
                                    </th>
                                @endforeach

                            </tr>
                            <tr>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = 1;@endphp

                            @foreach ($sortedData as $key => $value)
                                <tr>
                                    <td class="text-left">
                                        <div class="text-wrap" style="width: 6rem">{{ $key }}
                                        </div>
                                    </td>
                                    @foreach ($value as $key_1 => $value_1)
                                        <td class="text-center">{{ round($value_1, 2) }}</td>
                                    @endforeach
                                    <td class="text-center">{{ $no++ }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    {{-- ** Akhir Tabel Tahap Perangkingan ** --}}

@stop

{{-- ** Code yang tidak terpakai ** --}}
{{-- <div class="col">
                <form method="GET">
                    @csrf
                    <div class="form-group">
                        <label for="start_date">Tanggal Awal:</label>
                        <input type="date" name="start_date" id="start_date" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="end_date">Tanggal Akhir:</label>
                        <input type="date" name="end_date" id="end_date" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Tampilkan Laporan</button>
                    <a href="{{ URL::to('download-perhitungan-pdf') }}" target="_blank" class="btn btn-primary"><i
                            class="fas fa-download fa-sm text-white-50"></i> Download Laporan</a>
                </form>
            </div> --}}
{{-- <a href="{{ URL::to('download-perhitungan-pdf') }}" target="_blank"
            class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm float-right"><i
                class="fas fa-download fa-sm text-white-50"></i> Download Laporan</a>
--}}
{{-- @if ($value[count($value) - 1] != $key_1)
            {{ $value_1 }}
    @endif
--}}

{{-- ** Muhammad Kurnia Affandi ** --}}
{{-- ** Instagram :  mk.affandi ** --}}
