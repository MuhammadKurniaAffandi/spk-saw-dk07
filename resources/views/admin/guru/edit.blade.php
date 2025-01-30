@extends('layouts.app')
@section('title', 'SPK Pemilihan Guru Terbaik ', $guru->nama_guru)
@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card shadow mb-4">
                <!-- Card Header - Accordion -->
                <a href="#tambahkriteria" class="d-block card-header py-3" data-toggle="collapse" role="button"
                    aria-expanded="true" aria-controls="collapseCardExample">
                    <h6 class="m-0 font-weight-bold text-primary">Ubah Data Guru : {{ $guru->nama_guru }}</h6>
                </a>

                <!-- Card Content - Collapse -->
                <div class="collapse show" id="tambahkriteria">
                    <div class="card-body">
                        @if (Session::has('msg'))
                            <div class="alert alert-info alert-dismissible fade show" role="alert">
                                <strong>{{ Session::get('msg') }}</strong>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        <form action="{{ route('guru.update', $guru->id) }}" method="post">
                            @csrf
                            @method('put')
                            <div class="form-group">
                                <label for="nama">Nama Guru</label>
                                <input type="text" class="form-control @error('nama_guru') is-invalid @enderror"
                                    name="nama_guru" value="{{ $guru->nama_guru }}" autocomplete="off">

                                @error('nama_guru')
                                    <div class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>

                            <div class="form-group">
                                <label for="jabatan">Jabatan</label>
                                <input type="text" class="form-control @error('jabatan') is-invalid @enderror"
                                    name="jabatan" value="{{ $guru->jabatan }}">

                                @error('jabatan')
                                    <div class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>


                            <div class="form-group">
                                <label for="kelas">Kelas</label>
                                <input type="text" class="form-control @error('kelas') is-invalid @enderror"
                                    name="kelas" value="{{ $guru->kelas }}">

                                @error('kelas')
                                    <div class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>


                            <button class="btn btn-primary mr-2">Simpan</button>
                            <a href="{{ route('guru.index') }}" class="btn btn-success">Kembali</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop

{{-- ** Code yang tidak terpakai** --}}
{{-- <div class="form-group">
                                <label for="jenis_kelamin">Jenis Kelamin</label>
                                <select class="form-control @error('jenis_kelamin') is-invalid @enderror"
                                    name="jenis_kelamin">
                                    <option value="" disabled selected>Pilih Jenis Kelamin</option>
                                    <option value="Laki-laki"
                                        {{ $alternatif->jenis_kelamin == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="Perempuan"
                                        {{ $alternatif->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                </select>

                                @error('jenis_kelamin')
                                    <div class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div> --}}

{{-- <div class="form-group">
                                <label for="tanggal_lahir">Tanggal Lahir</label>
                                <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror"
                                    name="tanggal_lahir"
                                    value="{{ $alternatif->tanggal_lahir ? \Carbon\Carbon::parse($alternatif->tanggal_lahir)->format('d-m-Y') : '' }}">

                                @error('tanggal_lahir')
                                    <div class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div> --}}
