@extends('layouts.app')
@section('title', 'SPK Pemilihan Guru Terbaik')
@section('css')

    <!-- Custom styles for this page -->
    <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@stop
@section('content')



    <div class="row">
        {{-- <div class="col-md-4">
            <div class="card shadow mb-4">
                <!-- Card Header - Accordion -->
                <a href="#tambahkriteria" class="d-block card-header py-3" data-toggle="collapse" role="button"
                    aria-expanded="true" aria-controls="collapseCardExample">
                    <h6 class="m-0 font-weight-bold text-primary">Periode Laporan Perhitungan</h6>
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

                        <form action="{{ route('kriteria.store') }}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="periode">Periode</label>
                                <select name="periode" id="periode" class="form-control">
                                    @foreach ($daftarPeriode as $periode)
                                        <option value="{{ $periode }}" {{ $periode == $periode ? 'selected' : '' }}>
                                            {{ $periode }}</option>
                                    @endforeach
                                </select>

                                @error('attribut')
                                    <div class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>
                            <button class="btn btn-primary">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div> --}}

        <div class="col">
            <div class="card shadow mb-4">
                <!-- Card Header - Accordion -->
                <a href="#listkriteria" class="d-block card-header py-3" data-toggle="collapse" role="button"
                    aria-expanded="true" aria-controls="collapseCardExample">
                    <h6 class="m-0 font-weight-bold text-primary">Daftar Laporan</h6>
                </a>

                <!-- Card Content - Collapse -->
                <div class="collapse show" id="listkriteria">
                    <div class="card-body">
                        <div class="table-responsive">
                            {{-- href="{{ URL::to('download-kriteria-pdf') }}" --}}
                            <a target="_blank"
                                class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm float-left"><i
                                    class="fas fa-download fa-sm text-white-50"></i> Download Laporan</a>

                            <table class="table table-striped table-hover" id="DataTable" data-paging="false">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Periode Perhitungan</th>
                                        {{-- <th>Bobot %</th> --}}
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    {{-- {{ dd($data) }} --}}
                                    @php $no = 1; @endphp
                                    @foreach ($data as $row)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $row['periode'] }}</td>
                                            <td>
                                                <a href="{{ route('laporan.show', $row['id']) }}"
                                                    class="btn btn-sm btn-circle btn-info" target="_blank"><i
                                                        class="	fas fa-folder-plus"></i></a>
                                                {{-- <a href="{{ route('kriteria.edit', $row->id) }}"
                                                    class="btn btn-sm btn-circle btn-warning">
                                                    <i class="fa fa-edit"></i>
                                                </a> --}}

                                                {{-- <a href="{{ route('kriteria.destroy', $row->id) }}"
                                                    class="btn btn-sm btn-circle btn-danger hapus">
                                                    <i class="fa fa-trash"></i>
                                                </a> --}}

                                                {{-- <a href="{{ URL::to('download-crips-pdf', $row->id) }}" target="_blank"
                                                    class="btn btn-sm btn-circle btn-success">
                                                    <i class="fa fa-download"></i>
                                                </a> --}}

                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-end">
                                {{-- {{ dd($data) }} --}}
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
                                            "{{ route('laporan.index') }}"
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