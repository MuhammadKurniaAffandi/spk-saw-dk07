<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">

    {{-- ** Awal Custom Style ** --}}
    <style type="text/css">
        .garis1 {
            border-top: 3px solid black;
            height: 2px;
            border-bottom: 1px solid black;

        }

        #jabatan {
            text-align: center;
        }

        #nama-pejabat {
            margin-top: 100px;
            text-align: center;
        }

        #ttd {
            position: absolute;
            bottom: 10;
            right: 20;
        }

        /* custom style table */
        #kop_surat {
            box-sizing: border-box;
        }

        .box1 {
            float: left;
            width: 20%;
            padding-left: 25%;

        }

        .box2 {
            float: left;
            width: 70%;
        }

        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }

        #DataTable {
            border-collapse: collapse;
            width: 100%;
        }

        #rank table thead tr th {
            text-align: center;
            border: 1px solid #000;
        }


        #rank td,
        #rank th {
            border: 1px solid #000;
            text-align: left;
            padding: 8px;

        }

        #rank .no_urut {
            text-align: center;
            padding: 8px;
        }

        #rank .wrapper_text {
            min-width: 150px;
            max-width: 150px;
            word-wrap: break-word;
        }
    </style>
    {{-- ** Akhir Custom Style ** --}}


</head>

<body>
    <div>
        <table id="kop_surat">
            <tr class="clearfix">
                <td class="box1">

                    <img src="{{ public_path('images/logo.png') }}" height="90" width="180">
                </td>
                <td class="box2">
                    <center>
                        <font size="3">PEMERINTAH PROVINSI DAERAH KHUSUS IBUKOTA JAKARTA</font><br>
                        <font size="3">SDN DURI KEPA 07</font><br>
                        <font size="2">Jl. Ratu Alamanda Blok A7 Rt.007/013 Kel. Duri Kepa Telp. 021-5653923
                        </font><br>
                        <font size="2">Kecamatan Kebon Jeruk Kotamadya - Jakarta Barat</font><br>
                    </center>
                </td>
            </tr>
        </table>

        <hr class="garis1" />
        <div style="margin-top: 25px; margin-bottom: 25px;">
            <center><strong><u>SURAT KEPUTUSAN PEMILIHAN GURU TERBAIK</u></strong></center>
        </div>
        <p style="text-indent: 45px;">Berdasarkan hasil penilaian yang objektif dan mempertimbangkan kinerja, dedikasi,
            serta kontribusi yang luar biasa dalam proses belajar-mengajar. Dengan ini, kami menetapkan guru-guru
            terbaik pada periode {{ $laporan['periode'] }} sebagai berikut:</p>

        <div class="collapse show" id="rank">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="DataTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Guru</th>
                                <th>Nilai Preferensi</th>
                            </tr>

                        </thead>
                        <tbody>
                            @php $no = 1;@endphp
                            {{-- @foreach ($hasilKeputusan as $key => $value)
                                <tr>
                                    <td class="no_urut">{{ $no++ }}</td>
                                    <td class="wrapper_text">{{ $value['nama'] }}</td>
                                    <td class="no_urut ">{{ $value['nilai'] }}</td>
                                </tr>
                            @endforeach --}}
                            @if (!empty($hasilKeputusan) && count($hasilKeputusan) > 0)
                                @foreach ($hasilKeputusan as $key => $value)
                                    <tr>
                                        <td class="no_urut">{{ $no++ }}</td>
                                        <td class="wrapper_text">{{ $value['nama'] }}</td>
                                        <td class="no_urut ">{{ $value['nilai'] }}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="3" class="no_urut ">Tidak ada data hasil keputusan!</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <p style="text-indent: 45px;"> Demikian daftar guru terbaik yang terpilih untuk periode
            {{ $laporan['periode'] }}. Keputusan ini
            diharapkan dapat menjadi motivasi bagi seluruh tenaga pendidik untuk terus memberikan yang terbaik dalam
            mencerdaskan generasi bangsa.</p>

        <div id="ttd" class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <p id="jabatan">Jakarta, {{ $tanggal }}</p>
                <p id="jabatan"><strong>Kepala SDN Duri Kepa 07</strong></p>
                <div id="nama-pejabat"><strong><u>ATIN HARYATI, M.Pd</u></strong><br />
                    NIP. 19770513201422004</div>
            </div>
        </div>
    </div>
</body>



</html>
