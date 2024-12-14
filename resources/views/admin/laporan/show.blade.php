@extends('layouts.app')
@section('title', 'SPK Pemilihan Guru Terbaik')
@section('content')




    <div class="mb-4">
        <!-- Card Header - Accordion -->
        <div class="row">
            <div class="col">
                <a href="{{ route('laporan.index') }}"
                    class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm float-right"><i
                        class="fas fa-arrow-alt-circle-left text-black-50"></i> Kembali</a>
            </div>
        </div>
    </div>


    @if ($laporan['periode'])
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
                                    <th class="text-center">Nama Alternatif</th>
                                    @foreach ($laporan['data']['kriteria'] as $key => $value)
                                        <td class="text-center">{{ $value['nama_kriteria'] }}</td>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>

                                @forelse ($laporan['data']['alternatif'] as $key => $value)
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
                                    @foreach ($laporan['data']['kriteria'] as $key => $value)
                                        <th>{{ $value['nama_kriteria'] }}</th>
                                    @endforeach
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($laporan['data']['normalisasi'] as $key => $value)
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
                <h6 class="m-0 font-weight-bold text-primary text-center">TAHAP PERANGKINGAN
                </h6>
            </a>

            <!-- Card Content - Collapse -->
            <div class="collapse show" id="rank">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th></th>
                                    @foreach ($laporan['data']['kriteria'] as $key => $value)
                                        <th class="text-center">{{ $value['nama_kriteria'] }}</th>
                                    @endforeach
                                    <th rowspan="2" style="text-align: center; padding-bottom: 45px">Total</th>
                                    <th rowspan="2" style="text-align: center; padding-bottom: 45px">Rank</th>
                                </tr>
                                <tr>
                                    <th>Nama / Bobot</th>
                                    @foreach ($laporan['data']['kriteria'] as $key => $value)
                                        <th class="text-center">{{ round($value['bobot'], 2) }} %</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = 1;@endphp

                                @foreach ($sortedData as $key => $value)
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
                                            "{{ route('laporan.show', $laporan['id']) }}"
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
