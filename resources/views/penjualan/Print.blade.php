<!DOCTYPE HTML>
<html>

{{-- <link rel="stylesheet" href="{{ URL::asset('assets/print/main.css') }}" /> --}}
{{-- <link rel="stylesheet" media="print" href="{{ URL::asset('assets/print/print.css') }}" /> --}}
<link href="{{ URL::asset('assets/print/bootstrap.min.css') }}" rel="stylesheet">

<head>
    <style type="text/css">
        table {
            width: 100%;
            height: 100%;
        }

        .table>tbody>tr>.emptyrow {
            border-top: none;
        }

        .table>tbody>tr>td {
            border: none;
            padding: 5px;
        }

        .table>thead>tr>.emptyrow {
            border-bottom: none;
        }

        .table>thead>tr {
            border-bottom: 0.5px solid;
            border-top: 0.5px solid;
        }

        .table>tbody>tr>.highrow {
            border-top: 1px solid;
        }

        p {
            margin: 0 0 0px
        }
    </style>
</head>

<body onload="javascript:window.print() ;drawer();setTimeout(function () {window.close();},100);">

    <body>
        {{-- <button onclick="javascript:window.print()" class="btn-print">Print</button> --}}
        <div class="print">
            <table class="report-container">
                <thead class="report-header">
                    <tr>
                        <th>
                            <div class="header-info"><br>
                                <table border="0">
                                    <tr>
                                        <td style="width: 6.7%;">
                                            <img src="" width="40">
                                        </td>
                                        <td colspan="3" style="text-align:center"> BANDAR TELUR
                                            <br>
                                            {{ $list->user->cabang->alamat }}
                                            <br>
                                            WA {{ $list->user->cabang->kontak }}
                                        </td>
                                        <td style="width: 6.7%;">
                                            <img src="" width="40">
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody class="report-content">
                    <tr>
                        <td>
                            {{-- <hr>
                            <div style="text-align:center;margin-top:0.5%"><b>INVOICE</b></div>
                            --}}
                            <hr>
                            <div style="padding-left:3%;padding-right:3%;">
                                <table border="0" style="margin-bottom: 0.5%;margin-left:0.5%;margin-right:0.5%;">
                                    <tr>
                                        <td>No Invoice</td>
                                        <td>:</td>
                                        <td>{{ $list->no_invoice }}</td>
                                        <td width="40%"></td>
                                        <td>Tanggal</td>
                                        <td>:</td>
                                        <td>{{ date('l, d F Y', strtotime($list->date)) }}</td>
                                    </tr>
                                    <tr>
                                        <td>Jam</td>
                                        <td>:</td>
                                        <td>{{ date('H:i:s', strtotime($list->created_at)) }}</td>
                                        <td width="40%"></td>
                                        <td>Customer</td>
                                        <td>:</td>
                                        <td>{{ $list->customer ? $list->customer->nama . ' - ' . $list->customer->alamat : '-' }}
                                        </td>
                                    </tr>
                                </table>
                                <table class="table" border="1">
                                    <thead>
                                        <tr>
                                            <td style="width: 35%;"><strong>Nama barang</strong></td>
                                            <td class="text-left" style="width: 1%;"><strong>Jumlah</strong></td>
                                            <td class="text-right" style="width: 15%;"><strong>@Harga</strong></td>
                                            <td class="text-right" style="width: 15%;"><strong>Total</strong></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($details as $det)
                                            <tr>
                                                <td>{{ $det->item->nama }}</td>
                                                <td class="text-center">
                                                    {{ number_format($det->jml) . ' ' . $det->satuan->satuan }}</td>
                                                <td class="text-right">{{ number_format($det->harga) }}</td>
                                                <td class="text-right">{{ number_format($det->jml * $det->harga) }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td><i><b>Terimakasih sudah berbelanja di BANDAR TELUR</b></i></td>
                                            <td colspan="2" class="text-right">Total Penjualan</td>
                                            <td class="text-right">{{ number_format($list->total) }}</td>
                                        </tr>
                                    </tfoot>
                                </table>
                                <table border="0">
                                    <tr>
                                        <td width="10%"></td>
                                        <td width="15%" style="text-align:center">Penerima</td>
                                        <td width="40%"></td>
                                        <td width="15%" style="text-align:center">Hormat Kami</td>
                                        <td width="20%"></td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td width="20%"></td>
                                        <td width="10%" style="text-align:center">
                                            (<u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>)
                                        </td>
                                        <td width="40%"></td>
                                        <td width="10%" style="text-align:center">({{ $list->user->name }})</td>
                                        <td width="20%"></td>
                                    </tr>
                                </table>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div style="margin: 70px 0px 0px 50px;">
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </body>

</html>
