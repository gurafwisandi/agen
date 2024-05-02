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
        <div class="print">
            <table class="report-container">
                <thead class="report-header">
                    <tr>
                        <th>
                            <div class="header-info">
                                <table border="0">
                                    <tr>
                                        <td style="width: 6.7%;"></td>
                                        <td colspan="3" style="text-align:center"> BANDAR TELUR
                                            <br>
                                            <div style="font-size: 10px;">
                                                {{ $list->user->cabang->alamat }}<br>
                                                WA {{ $list->user->cabang->kontak }}
                                            </div>
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
                            <hr style="border-bottom:1px dashed rgb(5, 5, 5);margin-top: 10px;margin-bottom: 0px;">
                            <div style="padding-left:1%;padding-right:1%;">
                                <table border="0">
                                    <tr>
                                        <td><b>{{ Str::substr($list->no_invoice, 9, 4) }}</b></td>
                                        <td class="text-right">
                                            <b>{{ date('d/m/Y', strtotime($list->date)) . ' ' . date('H:i', strtotime($list->created_at)) }}</b>
                                            &nbsp;
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            {{ $list->customer ? $list->customer->nama : '-' }}
                                        </td>
                                    </tr>
                                </table>
                                <hr style="border-bottom:1px dashed rgb(5, 5, 5);margin-top: 10px;margin-bottom: 0px;">
                                <table class="table" border="0">
                                    <tbody style="font-size: 10px;">
                                        @foreach ($details as $det)
                                            <tr>
                                                <td colspan="3">{{ $det->item->nama }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">
                                                    {{ number_format($det->jml) . ' ' . $det->satuan->satuan }}</td>
                                                <td class="text-right">{{ number_format($det->harga) }}</td>
                                                <td class="text-right">{{ number_format($det->jml * $det->harga) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot style="font-size: 14px;">
                                        <tr>
                                            <td colspan="2"><i><b>TOTAL</b></i></td>
                                            <td class="text-right">{{ number_format($list->total) }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"><i><b>BAYAR</b></i></td>
                                            <td class="text-right">{{ number_format($list->total_bayar) }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"><i><b>KEMBALI</b></i></td>
                                            <td class="text-right">
                                                {{ number_format($list->total_bayar - $list->total) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="text-center">== TERIMAKASIH ==</td>
                                        </tr>
                                    </tfoot>
                                </table>
                                <hr style="border-bottom:1px dashed rgb(5, 5, 5);margin-top: 10px;margin-bottom: 0px;">
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </body>

</html>
