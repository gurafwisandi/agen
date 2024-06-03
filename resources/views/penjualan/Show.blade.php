@extends('layouts.main')
@section('container')

    <body class="InvBarang">
        <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">{{ $label }}</h4>
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item">{{ ucwords($menu) }}</li>
                                    <li class="breadcrumb-item">{{ ucwords($submenu) }}</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="mb-3">
                                            <label for="total_kuantiti">No Invoice<code>*</code></label>
                                            <input type="text" class="form-control" id="no_invoice" name="no_invoice"
                                                value="{{ $list->no_invoice }}" placeholder="No Invoice" autocomplete="off"
                                                disabled>
                                            <input type="hidden" name="id_penjualan" id="id_penjualan"
                                                value="{{ $list->id }}">
                                            <div class="invalid-feedback">
                                                Data wajib diisi.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2" id="divValueCustomer">
                                        <div class="mb-2">
                                            <label class="form-label">Customer <code>*</code></label>
                                            <select class="form-control select select2 nama" name="nama" id="nama"
                                                disabled>
                                                <option value="">-- PILIH --</option>
                                                @foreach ($customers as $cus)
                                                    <option value="{{ $cus->id }}" data-id="{{ $cus->nama }}"
                                                        {{ $cus->id == $list->id_customer ? 'selected' : '' }}>
                                                        {{ $cus->nama . ' - ' . $cus->kontak }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback">
                                                Data wajib diisi.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="mb-2">
                                            <label for="tgl_kadaluarsa">Tanggal</label>
                                            <div class="input-group" id="datepicker2">
                                                <input type="text" class="form-control tgl_penjualan" placeholder="Tgl"
                                                    name="tgl_penjualan" id="tgl_penjualan" data-date-format="yyyy-mm-dd"
                                                    value="{{ $list->date }}" data-date-container='#datepicker2'
                                                    data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                                                    disabled>
                                                <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                                <div class="invalid-feedback">
                                                    Data wajib diisi.
                                                </div>
                                            </div>
                                            <div class="invalid-validasi"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="tgl_kadaluarsa">Transfer</label>
                                        <div class="mb-2">
                                            <input class="form-check-input" type="checkbox"
                                                {{ $list->transfer ? 'checked' : '' }} id="transferCheck" disabled>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-12 table-responsive">
                                        <table class="table table-responsive table-bordered table-striped" id="tableBarang">
                                            <thead>
                                                <tr>
                                                    <th class="text-center" style="width: 20%">Item</th>
                                                    <th class="text-center" style="width: 10%">Jumlah</th>
                                                    <th class="text-center" style="width: 10%">Satuan</th>
                                                    <th class="text-center" style="width: 10%">@Harga</th>
                                                    <th class="text-center" style="width: 10%">Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($details as $det)
                                                    <tr>
                                                        <td class="text-center">{{ $det->item->nama }}</td>
                                                        <td class="text-center">{{ $det->jml }}</td>
                                                        <td class="text-center">{{ $det->satuan->satuan }}</td>
                                                        <td class="text-center">{{ number_format($det->harga) }}</td>
                                                        <td class="text-center">
                                                            {{ number_format($det->jml * $det->harga) }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="row mt-5">
                                    <div class="col-md-9 offset-md-7">
                                        <div class="row mb-2">
                                            <label class="col-md-3 text-right">Total Penjualan</label>
                                            <div class="col-md-3">
                                                <input type="text" class="form-control text-center" style="float: right"
                                                    id="total_penjualan" name="total_penjualan"
                                                    value="{{ number_format($list->total) }}" placeholder="Rp" readonly>
                                                <input type="hidden" class="form-control" id="value_total_penjualan"
                                                    name="value_total_penjualan"
                                                    value="{{ number_format($list->total) }}" placeholder="Rp">
                                            </div>
                                        </div>
                                        <div class="row mb-2" hidden>
                                            <label class="col-md-3 text-right">Bayar</label>
                                            <div class="col-md-3">
                                                <input type="text" class="form-control text-center"
                                                    style="float: right" id="bayar_penjualan" name="bayar_penjualan"
                                                    placeholder="Rp" value="{{ number_format($list->total_bayar) }}"
                                                    readonly>
                                            </div>
                                        </div>
                                        <div class="row mb-2" hidden>
                                            <label class="col-md-3 text-right">Kembalian</label>
                                            <div class="col-md-3">
                                                <input type="text" class="form-control text-center"
                                                    style="float: right" id="kembalian_penjualan"
                                                    name="kembalian_penjualan" placeholder="Rp"
                                                    value="{{ number_format($list->total_bayar - $list->total) }}"
                                                    readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-sm-12">
                                        <a href="{{ route('penjualan.index') }}" class="btn btn-secondary"
                                            type="submit" id="submit">Kembali</a>
                                        <?php $Id = Crypt::encryptString($list->id); ?>
                                        <a href="{{ route('penjualan.print', $Id) }}" target="_blank"
                                            class="btn btn-success waves-effect waves-light me-1"><i
                                                class="fa fa-print"></i></a>
                                        <a href="{{ route('penjualan.pos', $Id) }}" target="_blank"
                                            class="btn btn-info waves-effect waves-light me-1"><i class="fa fa-print"></i>
                                            Thermal</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
@endsection
