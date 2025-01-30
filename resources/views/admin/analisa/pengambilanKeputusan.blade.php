<div class="card shadow mb-4">
    <!-- Card Header - Accordion -->
    <a href="#rank" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true"
        aria-controls="collapseCardExample">
        <h6 class="m-0 font-weight-bold text-primary text-center">REKOMENDASI PEMILIHAN GURU TERBAIK</h6>
    </a>

    <!-- Card Content - Collapse -->
    <div class="collapse show" id="rank">
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
                <form action="{{ route('analisa.simpan') }}" method="POST">
                    @csrf
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <label for="periode">Periode:</label>
                        </div>
                        <div class="col-auto">
                            <input type="date" name="periode" id="periode" class="form-control" required>
                        </div>
                        <div class="col-auto">
                            <button type="submit" class=" btn btn-md btn-success shadow-sm">
                                <i class="fas fa-save fa-sm text-white-50"></i> Simpan Keputusan
                            </button>
                        </div>
                    </div>
                    <br><br>
                    <table class="table table-bordered">
                        <thead>
                            <tr>

                                <th class="text-bold text-center">Pilih Keputusan</th>
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
                                    <td class="text-center">
                                        <input type="checkbox" name="selected_data[]"
                                            value="{{ json_encode(['nama' => $key, 'nilai' => round($value, 2)]) }}">
                                    </td>
                                    <td class="text-left">{{ $key }}</td>
                                    <td class="text-center">{{ round($value, 2) }}</td>
                                    <td class="text-center">{{ $no++ }}</td>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>
