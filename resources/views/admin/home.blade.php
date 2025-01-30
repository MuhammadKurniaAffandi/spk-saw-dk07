@extends('layouts.app')
@section('title', 'SPK Pemilihan Guru Terbaik')
@section('css')
    <!-- Custom styles for this page -->
    <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@stop
@section('content')

    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Selamat Datang, {{ Auth::user()->name }}</h1>

        </div>

        <!-- Content Row -->
        <div class="row">

            <!-- List Warga Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <a href="{{ route('guru.index') }}">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Jumlah Guru</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $guru }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-users fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <a href="{{ route('kriteria.index') }}">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Jumlah Kriteria</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $kriteria }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-fw fa-list fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <a href="{{ route('penilaian.index') }}">
                    <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Jumlah Penilaian</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $penilaian }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fa fa-star fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Pending Requests Card Example -->
            {{-- <div class="col-xl-3 col-md-6 mb-4">
                <a href="{{ route('perhitungan.index') }}">
                    <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">

                                    <div class="h5 mb-0 font-weight-bold text-gray-800">Perhitungan SAW</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-book fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div> --}}
        </div>

        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Penerapan Metode <i>Simple additive Weighting</i><br>Dalam Sistem
                Pendukung
                Keputusan Pemilihan Guru Terbaik<br>Pada SDN Duri Kepa 07</h1>

        </div>
    </div>
@endsection
