@extends('layouts.app')
@section('title', 'SPK Pemilihan Guru Terbaik')
@section('content')



    <div class="mb-4">
        <!-- Card Header - Accordion -->
        <div class="row">
            <div class="col">
                <a href="{{ URL::to('download-penilaian-pdf') }}" target="_blank"
                    class="d-sm-inline-block btn btn-sm btn-success shadow-sm float-left"><i
                        class="fas fa-download fa-sm text-white-50"></i> Cetak Data Penilaian</a>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <!-- Card Header - Accordion -->
        <a href="#listkriteria" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true"
            aria-controls="collapseCardExample">
            <h6 class="m-0 font-weight-bold text-primary">Penilaian Guru</h6>
        </a>

        <!-- Card Content - Collapse -->
        <div class="collapse show" id="listkriteria">
            <div class="card-body">
                @if (Session::has('msg'))
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        <strong>{{ Session::get('msg') }}</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                <div class="table-responsive">

                    <form action="{{ route('penilaian.store') }}" method="post">
                        @csrf
                        <button class="d-sm-inline-block btn btn-sm btn-primary shadow-sm float-left">Proses
                            Perhitungan</button>
                        <br><br>
                        <table class="table">
                            <thead>
                                <tr class="text-center">
                                    <th>Nama Guru</th>
                                    @foreach ($kriteria as $key => $value)
                                        <th>{{ $value->nama_kriteria }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($guru as $alt => $valt)
                                    <tr>
                                        <td>
                                            <div class="text-wrap" style="width: 6rem">{{ $valt->nama_guru }}
                                            </div>
                                        </td>
                                        @foreach ($kriteria as $key => $value)
                                            <td>
                                                <select name="crips_id[{{ $valt->id }}][]" class="form-control">
                                                    <option value="">-- Pilih --</option>
                                                    @foreach ($value->crips as $k_1 => $v_1)
                                                        <option value="{{ $v_1->id }}"
                                                            {{ isset($valt->penilaian[$key]) && $v_1->id == $valt->penilaian[$key]->crips_id ? 'selected' : '' }}>
                                                            {{ $v_1->nama_crips }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                        @endforeach
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="{{ count($kriteria) + 1 }}">Tidak ada data!</td>
                                    </tr>


                                @endforelse
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>

@stop
