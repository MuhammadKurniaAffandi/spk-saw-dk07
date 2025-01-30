@extends('layouts.app')
@section('title', 'SPK Pemilihan Guru Terbaik')
@section('content')

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
                        <button class="d-sm-inline-block btn btn-sm btn-primary shadow-sm float-left">Simpan
                            Penilaian</button>
                        <a href="{{ URL::to('download-penilaian-pdf') }}" target="_blank"
                            class="d-sm-inline-block btn btn-sm btn-success shadow-sm float-left ml-3"><i
                                class="fas fa-download fa-sm text-white-50"></i> Cetak Penilaian</a>
                        <br><br>
                        <table class="table">
                            <thead>
                                <tr class="text-center">
                                    <th>Nama Guru</th>
                                    @foreach ($kriteria as $key => $value)
                                        <th>{{ $value->nama_kriteria }}</th>
                                    @endforeach
                            </thead>
                            <tbody>
                                @forelse ($guru as $alt => $valt)
                                    <tr>
                                        <td class="text-left">{{ $valt->nama_guru }}</td>
                                        @foreach ($kriteria as $key => $value)
                                            @php
                                                // Mencari nilai dari tabel penilaian yang sesuai dengan guru dan kriteria saat ini
                                                $nilaiTersimpan = $valt->penilaian
                                                    ->where('kriteria_id', $value->id)
                                                    ->first();
                                            @endphp
                                            <td>
                                                <input type="number" name="nilai[{{ $valt->id }}][{{ $value->id }}]"
                                                    class="form-control"
                                                    value="{{ $nilaiTersimpan ? $nilaiTersimpan->nilai : '' }}" required>
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

@section('js')

    <!-- Page level plugins -->
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/sweetalert.js') }}"></script>
    {{-- <script>
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
                                            "{{ route('keputusan.index') }}"
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
    </script> --}}

@stop

{{-- ** Codingan yang gak kepake** --}}
{{-- <div class="mb-4">
        <!-- Card Header - Accordion -->
        <div class="row">
            <div class="col">
                <a href="{{ URL::to('download-penilaian-pdf') }}" target="_blank"
                    class="d-sm-inline-block btn btn-sm btn-success shadow-sm float-left"><i
                        class="fas fa-download fa-sm text-white-50"></i> Cetak Data Penilaian</a>
            </div>
        </div>
    </div> --}}
