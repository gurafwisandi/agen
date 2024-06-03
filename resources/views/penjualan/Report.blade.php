@extends('layouts.main')
@section('container')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <div class="page-title-left">
                            <h4 class="mb-sm-0 font-size-18">{{ $label }}</h4>
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">{{ ucwords($menu) }}</li>
                                <li class="breadcrumb-item">{{ ucwords($submenu) }}</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form class="needs-validation" novalidate>
                                <div class="row" id="id_where">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-4 form-group">
                                                <label>Tanggal Penjualan</label>
                                                <div class="input-daterange input-group" id="datepicker6"
                                                    data-date-format="yyyy-mm-dd" data-date-autoclose="true"
                                                    data-provide="datepicker" data-date-container='#datepicker6'>
                                                    <input type="text" class="form-control" name="start"
                                                        value="{{ isset($_GET['start']) ? $_GET['start'] : '' }}"
                                                        placeholder="Start Date" />
                                                    <input type="text" class="form-control" name="end"
                                                        value="{{ isset($_GET['end']) ? $_GET['end'] : '' }}"
                                                        placeholder="End Date" />
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-2 form-group">
                                                <label>&nbsp;</label>
                                                <br>
                                                <button type="submit" class="btn btn-primary w-md">Cari</button>
                                                <?php
                                                if (isset($_GET['end'])) {
                                                    $start = $_GET['start'];
                                                    $end = $_GET['end'];
                                                } else {
                                                    $start = date('Y-m-d');
                                                    $end = date('Y-m-d');
                                                }
                                                ?>
                                                <a href="{{ route('penjualan.print_laporan', 'start=' . $start . '&end=' . $end . '') }}"
                                                    target="_blank"
                                                    class="btn btn-success btn-rounded waves-effect waves-light w-md"><i
                                                        class="bx bx-printer me-1"></i>Print</a>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div class="mb-4">
                            </div>
                            <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>No Invoice</th>
                                        <th>Tanggal</th>
                                        <th>Customer</th>
                                        <th>Item</th>
                                        <th>Qty</th>
                                        <th>Harga Satuan</th>
                                        <th>Total</th>
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
                        </div>
                    </div>
                </div> <!-- end col -->
            </div>
        </div> <!-- container-fluid -->
    </div>
    <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
@endsection
