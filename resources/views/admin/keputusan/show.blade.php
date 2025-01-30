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


        {{-- ** Awal Tabel Hasil Keputusan Pemilihan Guru Terbaik ** --}}
        <div class="card shadow mb-4">
            <!-- Card Header - Accordion -->
            <a href="#rank" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true"
                aria-controls="collapseCardExample">
                <h6 class="m-0 font-weight-bold text-primary text-center">Hasil Keputusan Pemilihan Guru Terbaik
                </h6>
            </a>

            <!-- Card Content - Collapse -->
            <div class="collapse show" id="rank">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>

                                    <th class="text-center text-center">No</th>
                                    <th class="text-bold text-center">
                                        Nama
                                        Guru</th>
                                    <th class="text-center text-center">Nilai Preferensi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = 1;@endphp
                                {{-- @foreach ($hasilKeputusan as $key => $value)
                                    <tr>
                                        <td class="text-center">{{ $no++ }}</td>
                                        <td class="text-left">{{ $value['nama'] }}</td>
                                        <td class="text-center">{{ $value['nilai'] }}</td>
                                    </tr>
                                @endforeach --}}
                                @if (!empty($hasilKeputusan) && count($hasilKeputusan) > 0)
                                    @foreach ($hasilKeputusan as $key => $value)
                                        <tr>
                                            <td class="text-center">{{ $no++ }}</td>
                                            <td class="text-left">{{ $value['nama'] }}</td>
                                            <td class="text-center">{{ $value['nilai'] }}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="3" class="text-center">Tidak ada data hasil keputusan!</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        {{-- ** Akhir Tabel Hasil Keputusan Pemilihan Guru Terbaik ** --}}
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
                                            "{{ route('keputusan.show', $laporan['id']) }}"
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
