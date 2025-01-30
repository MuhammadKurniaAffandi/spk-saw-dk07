@extends('layouts.app')
@section('title', 'SPK Pemilihan Guru Terbaik')
@section('content')



    {{-- ** Awal Area Button ** --}}
    <div class="mb-4">
        <!-- Card Header - Accordion -->
        <div class="row">
            <div class="col">
                <a href="{{ route('laporan.index') }}"
                    class="d-sm-inline-block btn btn-sm btn-primary shadow-sm float-left"><i
                        class="fas fa-arrow-alt-circle-left text-white-50"></i> Kembali</a>
            </div>
        </div>
    </div>
    {{-- ** Akhir Area Button ** --}}


    @if ($laporan['periode'])
        {{-- ** Awal Tabel Rating Kecocokan ** --}}
        <div class="card shadow mb-4">
            <!-- Card Header - Accordion -->
            <a href="#listkriteria" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true"
                aria-controls="collapseCardExample">
                <h6 class="m-0 font-weight-bold text-primary text-center">MATRIKS KEPUTUSAN</h6>
            </a>

            <!-- Card Content - Collapse -->
            <div class="collapse show" id="listkriteria">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th style="text-align: center; padding-bottom: 35px" rowspan="2">Nama Guru</th>
                                    <th class="text-center" colspan="{{ count($laporan['data']['kriteria']) }}">Kriteria
                                    </th>
                                </tr>
                                <tr>
                                    @foreach ($laporan['data']['kriteria'] as $key => $value)
                                        <td class="text-center">{{ $value['nama_kriteria'] }}</td>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>

                                @forelse ($laporan['data']['guru'] as $key => $value)
                                    <tr>
                                        <td class="text-left">{{ $value['nama_guru'] }}</td>
                                        @if (count($value['penilaian']) > 0)
                                            @foreach ($value['penilaian'] as $key => $value)
                                                <td class="text-center">
                                                    {{ $value['nilai'] }}
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
            <a href="#normalisasi" class="d-block card-header py-3" data-toggle="collapse" role="button"
                aria-expanded="true" aria-controls="collapseCardExample">
                <h6 class="m-0 font-weight-bold text-primary text-center">NORMALISASI MATRIKS</h6>
            </a>

            <!-- Card Content - Collapse -->
            <div class="collapse show" id="normalisasi">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th style="text-align: center; padding-bottom: 35px" rowspan="2">Nama Guru</th>
                                    <th class="text-center" colspan="{{ count($laporan['data']['kriteria']) }}">Kriteria
                                    </th>
                                </tr>
                                <tr>
                                    @foreach ($laporan['data']['kriteria'] as $key => $value)
                                        <th>{{ $value['nama_kriteria'] }}</th>
                                    @endforeach
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($laporan['data']['normalisasi'] as $key => $value)
                                    <tr>
                                        <td class="text-left">{{ $key }}</td>
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
        {{-- ** Akhir Tabel Normalisasi Matriks ** --}}

        {{-- ** Awal Tabel Tahap Perangkingan ** --}}
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

                                    <th class="text-bold text-center">
                                        Nama
                                        Guru</th>
                                    <th class="text-center text-center">Nilai Preferensi</th>
                                    <th class="text-center text-center">Rangking</th>
                                </tr>
                                {{-- <tr>
                                    @foreach ($laporan['data']['kriteria'] as $key => $value)
                                        <th class="text-center">
                                            {{ $value['nama_kriteria'] }}<br>{{ round($value['bobot'], 2) }}%</th>
                                    @endforeach
                                </tr> --}}
                            </thead>
                            <tbody>
                                @php $no = 1;@endphp

                                @foreach ($sortedData as $key => $value)
                                    <tr>
                                        <td class="text-left">{{ $key }}</td>
                                        <td class="text-center">{{ round($value, 2) }}</td>
                                        {{-- @foreach ($value as $key_1 => $value_1)
                                        <td class="text-center">{{ round($value_1, 2) }}</td>
                                        @endforeach --}}
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
                                            "{{ route('rekomendasi.show', $laporan['id']) }}"
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


{{-- ** Muhammad Kurnia Affandi ** --}}
{{-- ** Instagram :  mk.affandi ** --}}
