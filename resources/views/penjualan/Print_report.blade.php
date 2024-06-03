<!DOCTYPE HTML>
<html>
<link href="{{ URL::asset('assets/print/bootstrap.min.css') }}" rel="stylesheet">

<head>
    <style type="text/css">
        table {
            width: 100%;
            height: 100%;
        }

        p {
            margin: 0 0 0px
        }
    </style>
</head>

<body onload="javascript:window.print(); setTimeout(function () {window.close();},500);">
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
                                    <td colspan="3" style="text-align:center">BANDAR TELUR
                                        <br>
                                        Tanggal Penjualan {{ $start == $end ? $start : $start . ' s/d ' . $end }}
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
                    <td style="padding: 10px;">
                        <table class="table" border="1">
                            <thead>
                                <tr>
                                    <td>No Invoice</td>
                                    <td>Tanggal</td>
                                    <td>Customer</td>
                                    <td>Item</td>
                                    <td>Qty</td>
                                    <td>Harga Satuan</td>
                                    <td>Total</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $grandTodal = 0; ?>
                                @foreach ($lists as $list)
                                    <tr>
                                        <td>{{ $list->no_invoice }}</td>
                                        <td>{{ $list->date }}</td>
                                        <td>{{ $list->customer ? $list->customer : '' }}</td>
                                        <td>{{ $list->nama }}</td>
                                        <td>{{ $list->jml . ' ' . $list->satuan }}</td>
                                        <td>{{ number_format($list->harga) }}</td>
                                        <?php
                                        if ($list->transfer) {
                                            $grandTodal += 0;
                                        } else {
                                            $grandTodal += $list->total;
                                        }
                                        ?>
                                        <td>{{ $list->transfer ? 'Transfer' : number_format($list->total) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="6" style="text-align:right"><b>Grand Total</b></td>
                                    <td><b>{{ number_format($grandTodal) }}</b></td>
                                </tr>
                            </tfoot>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

</html>
