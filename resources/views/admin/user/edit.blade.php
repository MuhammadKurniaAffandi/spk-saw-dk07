@extends('layouts.app')
@section('title', 'SPK Pemilihan Guru Terbaik ', $users->name)
@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card shadow mb-4">
                <!-- Card Header - Accordion -->
                <a href="#tambahkriteria" class="d-block card-header py-3" data-toggle="collapse" role="button"
                    aria-expanded="true" aria-controls="collapseCardExample">
                    <h6 class="m-0 font-weight-bold text-primary">Ubah Pengguna : {{ $users->name }}</h6>
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

                        <form action="{{ route('user.update', $users->id) }}" method="post">
                            @csrf
                            @method('put')
                            <div class="form-group">
                                <label for="name">Nama Pengguna</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    name="name" value="{{ $users->name }}" autocomplete="off">

                                @error('name')
                                    <div class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>


                            <div class="form-group">
                                <label for="keterangan">Keterangan</label>
                                <input type="text" class="form-control @error('keterangan') is-invalid @enderror"
                                    name="keterangan" value="{{ $users->keterangan }}" autocomplete="off">

                                @error('keterangan')
                                    <div class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>
                            <button class="btn btn-primary mr-2">Simpan</button>
                            <a href="{{ route('user.index') }}" class="btn btn-success">Kembali</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    @stop


    {{-- ** Code yang tidak terpakai ** --}}
    {{-- <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    name="email" value="{{ $users->email }}">

                                @error('email')
                                    <div class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div> --}}


    {{-- <div class="form-group">
                                <label for="nama">Telepon</label>
                                <input type="number" class="form-control @error('telepon') is-invalid @enderror"
                                    name="telepon" value="{{ $alternatif->telepon }}">

                                @error('telepon')
                                    <div class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div> --}}
