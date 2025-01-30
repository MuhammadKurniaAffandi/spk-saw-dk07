@extends('layouts.app')
@section('title', 'SPK Pemilihan Guru Terbaik')
@section('css')

    <!-- Custom styles for this page -->
    <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@stop
@section('content')

    <div class="row justify-content-center">
        <div class="col-lg-12">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#menu1">Tambah Guru</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#menu2">Tabel Guru</a>
                </li>
            </ul>
            <div class="tab-content">
                {{-- ** Tab Menu Penilaian** --}}
                <div id="menu1" class="tab-pane active">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Accordion -->
                                <a href="#tambahalternatif" class="d-block card-header py-3" data-toggle="collapse"
                                    role="button" aria-expanded="true" aria-controls="collapseCardExample">
                                    <h6 class="m-0 font-weight-bold text-primary">Tambah Data Guru</h6>
                                </a>

                                <!-- Card Content - Collapse -->
                                <div class="collapse show" id="tambahalternatif">
                                    <div class="card-body">
                                        @if (Session::has('msg'))
                                            <div class="alert alert-info alert-dismissible fade show" role="alert">
                                                <strong>{{ Session::get('msg') }}</strong>
                                                <button type="button" class="close" data-dismiss="alert"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                        @endif

                                        <form action="{{ route('guru.store') }}" method="post">
                                            @csrf
                                            <div class="form-group">
                                                <label for="nama">Nama Guru</label>
                                                <input type="text"
                                                    class="form-control @error('nama_guru') is-invalid @enderror"
                                                    name="nama_guru" value="{{ old('nama_guru') }}" autocomplete="off">
                                                @error('nama_guru')
                                                    <div class="invalid-feedback" role="alert">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="jabatan">Jabatan</label>
                                                <input type="text"
                                                    class="form-control @error('jabatan') is-invalid @enderror"
                                                    name="jabatan" value="{{ old('jabatan') }}" autocomplete="off">
                                                @error('jabatan')
                                                    <div class="invalid-feedback" role="alert">
                                                        {{ $message }}
                                                    </div>
                                                @enderror

                                            </div>

                                            <div class="form-group">
                                                <label for="kelas">Kelas</label>
                                                <input type="text"
                                                    class="form-control @error('kelas') is-invalid @enderror" name="kelas"
                                                    value="{{ old('kelas') }}" autocomplete="off">
                                                @error('kelas')
                                                    <div class="invalid-feedback" role="alert">
                                                        {{ $message }}
                                                    </div>
                                                @enderror

                                            </div>



                                            <button class="btn btn-primary btn-block mt-3">Simpan</button>

                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                {{-- ** Tab Menu Hasil Analisa Metode SAW** --}}

                <div id="menu2" class="tab-pane fade">
                    <div class="card shadow mb-4">
                        <!-- Card Header - Accordion -->
                        <a href="#listkriteria" class="d-block card-header py-3" data-toggle="collapse" role="button"
                            aria-expanded="true" aria-controls="collapseCardExample">
                            <h6 class="m-0 font-weight-bold text-primary">DAFTAR GURU SDN DURI KEPA 07</h6>
                        </a>

                        <!-- Card Content - Collapse -->
                        <div class="collapse show" id="listkriteria">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <a href="{{ URL::to('download-guru-pdf') }}" target="_blank"
                                        class="d-sm-inline-block btn btn-sm btn-success shadow-sm float-left"><i
                                            class="fas fa-download fa-sm text-white-50"></i> Cetak Data Guru</a>
                                    <table class="table table-striped table-hover" id="DataTable" data-paging="false">
                                        <thead>
                                            <tr class="text-center">
                                                <th>No</th>
                                                <th>Nama Guru</th>
                                                <th>Jabatan</th>
                                                <th>Kelas</th>
                                                <th>Aksi</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $no = 1; @endphp
                                            @foreach ($guru as $row)
                                                <tr class="text-center">
                                                    <td>{{ $no++ }}</td>
                                                    <td class="text-left">{{ $row->nama_guru }}</td>
                                                    <td>{{ $row->jabatan }}</td>
                                                    <td>{{ $row->kelas }}</td>
                                                    <td>
                                                        <a href="{{ route('guru.edit', $row->id) }}"
                                                            class="btn btn-sm btn-circle btn-warning">
                                                            <i class="fa fa-edit"></i>
                                                        </a>

                                                        <a href="{{ route('guru.destroy', $row->id) }}"
                                                            class="btn btn-sm btn-circle btn-danger hapus">
                                                            <i class="fa fa-trash"></i>
                                                        </a>

                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <div class="d-flex justify-content-end">
                                        {{ $guru->links() }}
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop
@section('js')

    <!-- Page level plugins -->
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/sweetalert.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#DataTable').DataTable();

            $('.hapus').on('click', function() {
                swal({
                        title: "Apa anda yakin?",
                        text: "Sekali anda menghapus data, data tidak dapat dikembalikan lagi!",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            $.ajax({
                                url: $(this).attr('href'),
                                type: 'DELETE',
                                data: {
                                    '_token': "{{ csrf_token() }}"
                                },
                                success: function() {
                                    swal("Data berhasil dihapus!", {
                                        icon: "success",
                                    }).then((willDelete) => {
                                        window.location =
                                            "{{ route('guru.index') }}"
                                    });
                                }
                            })
                        } else {
                            swal("Data Aman!");
                        }
                    });

                return false;
            })
        })
    </script>

@stop


{{-- ** Code yang tidak terpakai ** --}}
{{-- <div class="form-group">
                                <label for="jenis_kelamin">Jenis Kelamin</label>
                                <select class="form-control @error('jenis_kelamin') is-invalid @enderror"
                                    name="jenis_kelamin">
                                    <option value="">-- Pilih Jenis Kelamin --</option>
                                    <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>
                                        Laki-laki</option>
                                    <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>
                                        Perempuan</option>
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
                                    value="{{ old('tanggal_lahir') ? \Carbon\Carbon::parse(old('tanggal_lahir'))->format('d-m-Y') : '' }}"
                                    autocomplete="off">

                                @error('tanggal_lahir')
                                    <div class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div> --}}

{{-- <td>{{ \Carbon\Carbon::parse($row->tanggal_lahir)->format('d-m-Y') }}</td>
                                             --}}
