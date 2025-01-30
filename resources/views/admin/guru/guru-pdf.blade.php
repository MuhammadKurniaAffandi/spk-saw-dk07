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

        #listkriteria table thead tr th {
            text-align: center;
            border: 1px solid #000;
        }


        #listkriteria td,
        #listkriteria th {
            border: 1px solid #000;
            text-align: center;
            padding: 8px;

        }

        #listkriteria .no_urut {
            text-align: center;
            padding: 8px;
        }

        #listkriteria .wrapper_text {
            min-width: 150px;
            max-width: 150px;
            word-wrap: break-word;
            text-align: left;
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
            <center><strong>DATA GURU SDN DURI KEPA 07</strong></center>
        </div>

        <div class="collapse show" id="listkriteria">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="DataTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Guru</th>
                                <th>Jabatan</th>
                                <th>Kelas</th>
                                {{-- <th>Tanggal Lahir</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = 1; @endphp
                            @foreach ($guru as $row)
                                <tr>
                                    <td class="no_urut">{{ $no++ }}</td>
                                    <td class="wrapper_text">{{ $row->nama_guru }}</td>
                                    <td>{{ $row->jabatan }}</td>
                                    <td>{{ $row->kelas }}</td>
                                    {{-- <td>{{ \Carbon\Carbon::parse($row->tanggal_lahir)->format('d-m-Y') }}</td> --}}
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

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
