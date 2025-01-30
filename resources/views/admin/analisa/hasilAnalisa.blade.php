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
                            <th class="text-center" colspan="{{ count($kriteria) }}">Kriteria</th>
                        </tr>
                        <tr>
                            @foreach ($kriteria as $key => $value)
                                <th class="text-center">{{ $value->nama_kriteria }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($guru as $alt => $valt)
                            <tr>
                                <td class="text-left">{{ $valt->nama_guru }}</td>
                                @if (count($valt->penilaian) > 0)
                                    @foreach ($valt->penilaian as $key => $value)
                                        <td class="text-center">
                                            {{ $value->nilai }}
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
    <a href="#normalisasi" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true"
        aria-controls="collapseCardExample">
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
                            <th class="text-center" colspan="{{ count($kriteria) }}">Kriteria</th>

                        </tr>
                        <tr>
                            @foreach ($kriteria as $key => $value)
                                <th class="text-center">{{ $value->nama_kriteria }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($normalisasi as $key => $value)
                            <tr>
                                <td class="text-left">{{ $key }}</td>
                                @foreach ($value as $key_1 => $value_1)
                                    <td class="text-center">
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
        <h6 class="m-0 font-weight-bold text-primary text-center">TAHAP PERANGKINGAN</h6>
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

                    </thead>
                    <tbody>
                        @php $no = 1;@endphp

                        @foreach ($sortedData as $key => $value)
                            <tr>
                                <td class="text-left">{{ $key }}</td>
                                <td class="text-center">{{ round($value, 2) }}</td>
                                <td class="text-center">{{ $no++ }}</td>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
