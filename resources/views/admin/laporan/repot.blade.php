@extends('layouts.app')
@section('title', 'SPK Pemilihan Guru Terbaik')
@section('content')

    <div class="mb-4">

        <!-- Card Header - Accordion -->
        <div class="row">
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
            <div class="col">
                <form action="{{ route('laporan.index') }}" method="GET" class="mb-4">
                    <div class="row">
                        {{-- <div class="col-md-3">
                            <label for="bulan">Bulan:</label>
                            <select name="bulan" id="bulan" class="form-control">
                                <option value="">-- Pilih Bulan --</option>
                                @foreach (range(1, 12) as $i)
                                    <option value="{{ $i }}" {{ request('bulan') == $i ? 'selected' : '' }}>
                                        {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                                    </option>
                                @endforeach
                            </select>
                        </div> --}}
                        <div class="col-md-3">
                            <label for="tahun">Tahun:</label>
                            <select name="periode" id="periode" class="form-control">
                                @foreach ($daftarPeriode as $periode)
                                    <option value="{{ $periode }}" {{ $periode == $periode ? 'selected' : '' }}>
                                        {{ $periode }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 align-self-end">
                            <button type="submit" class="btn btn-primary">Filter</button>
                            <a href="{{ route('laporan.index') }}" class="btn btn-danger">Reset</a>
                        </div>
                    </div>
                </form>
            </div>
            {{-- <div class="col">
                <a href="{{ URL::to('download-perhitungan-pdf') }}" target="_blank"
                    class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm float-right"><i
                        class="fas fa-download fa-sm text-white-50"></i> Download Laporan</a>
                <form method="GET" action="{{ route('laporan.index') }}">
                    <div class="form-group">
                        <label for="periode">Pilih Periode:</label>
                        <select name="periode" id="periode" class="form-control">
                            @foreach ($daftarPeriode as $periode)
                                <option value="{{ $periode }}" {{ $periode == $periode ? 'selected' : '' }}>
                                    {{ $periode }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Tampilkan</button>
                </form>
            </div> --}}
        </div>
    </div>
    {{ dd($laporan) }}
    @if ($laporanTerbaru)
        <div class="card shadow mb-4">
            <!-- Card Header - Accordion -->
            <a href="#listkriteria" class="d-block card-header py-3" data-toggle="collapse" role="button"
                aria-expanded="true" aria-controls="collapseCardExample">
                <h6 class="m-0 font-weight-bold text-primary text-center">RATING KECOCOKAN</h6>
            </a>

            <!-- Card Content - Collapse -->
            <div class="collapse show" id="listkriteria">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center">Nama Alternatif</th>
                                    @foreach ($laporanTerbaru->data['kriteria'] as $key => $value)
                                        <td class="text-center">{{ $value['nama_kriteria'] }}</td>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>

                                @forelse ($laporanTerbaru->data['alternatif'] as $key => $value)
                                    <tr>
                                        <td>{{ $value['nama_alternatif'] }}</td>
                                        @if (count($value['penilaian']) > 0)
                                            @foreach ($value['penilaian'] as $key => $value)
                                                <td class="text-center">
                                                    {{ $value['crips']['bobot'] }}
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

        <div class="card shadow mb-4">
            <!-- Card Header - Accordion -->
            <a href="#normalisasi" class="d-block card-header py-3" data-toggle="collapse" role="button"
                aria-expanded="true" aria-controls="collapseCardExample">
                <h6 class="m-0 font-weight-bold text-primary text-center">NORMALISASI MATRIK</h6>
            </a>

            <!-- Card Content - Collapse -->
            <div class="collapse show" id="normalisasi">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Alternatif / Kriteria</th>
                                    @foreach ($laporanTerbaru->data['kriteria'] as $key => $value)
                                        <th>{{ $value['nama_kriteria'] }}</th>
                                    @endforeach
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($laporanTerbaru->data['normalisasi'] as $key => $value)
                                    <tr>
                                        <td>{{ $key }}</td>
                                        @foreach ($value as $key_1 => $value_1)
                                            <td class="text-center">
                                                {{-- @if ($value[count($value) - 1] != $key_1)
                                                    {{ $value_1 }}
                                                @endif --}}
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
                                    <th></th>
                                    @foreach ($laporanTerbaru->data['kriteria'] as $key => $value)
                                        <th class="text-center">{{ $value['nama_kriteria'] }}</th>
                                    @endforeach
                                    <th rowspan="2" style="text-align: center; padding-bottom: 45px">Total</th>
                                    <th rowspan="2" style="text-align: center; padding-bottom: 45px">Rank</th>
                                </tr>
                                <tr>
                                    <th>Nama / Bobot</th>
                                    @foreach ($laporanTerbaru->data['kriteria'] as $key => $value)
                                        <th class="text-center">{{ round($value['bobot'], 2) }} %</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = 1;@endphp

                                @foreach ($laporanTerbaru->data['ranking'] as $key => $value)
                                    <tr>
                                        <td>{{ $key }}</td>
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
    @else
        <div class="alert alert-warning">
            Tidak ada laporan untuk periode ini.
        </div>
    @endif

@stop
