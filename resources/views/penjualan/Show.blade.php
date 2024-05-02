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
                                                    value="{{ date('Y-m-d') }}" data-date-container='#datepicker2'
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
                                                    name="value_total_penjualan" value="{{ number_format($list->total) }}"
                                                    placeholder="Rp">
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <label class="col-md-3 text-right">Bayar</label>
                                            <div class="col-md-3">
                                                <input type="text" class="form-control text-center"
                                                    style="float: right" id="bayar_penjualan" name="bayar_penjualan"
                                                    placeholder="Rp" value="{{ number_format($list->total_bayar) }}"
                                                    readonly>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
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
    <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/alert.js') }}"></script>
    <script>
        $('.delete_confirm').on('click', function(event) {
            event.preventDefault();
            Swal.fire({
                title: 'Hapus Data',
                text: 'Ingin menghapus data?',
                icon: 'question',
                showCloseButton: true,
                showCancelButton: true,
                cancelButtonText: "Batal",
                focusConfirm: false,
            }).then((value) => {
                if (value.isConfirmed) {
                    $(this).closest("form").submit()
                }
            });
        });

        function btnTambahProduk() {
            var id_penjualan = document.getElementById('id_penjualan').value;
            var select_peminjam = document.getElementById('produk');
            var id_item = select_peminjam.options[select_peminjam.selectedIndex].value;
            var jml = document.getElementById('jumlah').value;
            var harga_value = document.getElementById('harga_value').value;

            jQuery.ajax({
                type: "POST",
                url: '{{ route('penjualan.store_edit') }}',
                dataType: 'json',
                data: {
                    "_token": "{{ csrf_token() }}",
                    id_penjualan,
                    id_item,
                    jml,
                    harga_value
                },
                success: (response) => {
                    if (response.code === 200) {
                        Swal.fire(
                            'Success',
                            'Data Penjualan Berhasil di masukan',
                            'success'
                        ).then(() => {
                            location.reload();
                        })
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Tanda * (bintang) wajib diisi',
                            showConfirmButton: false,
                            timer: 1500,
                        })
                    }
                },
                error: err => console.log(err)
            });

            document.getElementById('jumlah').value = '';
            $('#produk').val("").trigger('change')
        }


























        // function sum(total) {
        //     var value_total_penjualan = document.getElementById('value_total_penjualan').value;
        //     document.getElementById('value_total_penjualan').value = parseFloat(value_total_penjualan) + parseFloat(total);
        //     document.getElementById('total_penjualan').value = formatRupiah(document.getElementById('value_total_penjualan')
        //         .value);
        // }

        function formatRupiah(angka) {
            var number_string = angka.toString().replace(/[^,\d]/g, ''),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/g);

            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            return rupiah + (split[1] !== undefined ? ',' + split[1] : '');
        }

        // function CustomerBaru() {
        //     var checkBox = document.getElementById("invalidCheck");
        //     if (checkBox.checked == true) {
        //         // Checkbox is checked, do something
        //         document.getElementById("divCusCustomer").style.display = "block"
        //         document.getElementById("divCusKontak").style.display = "block"
        //         document.getElementById("divCusAlamat").style.display = "block"
        //         document.getElementById("divValueCustomer").style.display = "none"
        //     } else {
        //         // Checkbox is unchecked, do something else
        //         document.getElementById("divCusCustomer").style.display = "none"
        //         document.getElementById("divCusKontak").style.display = "none"
        //         document.getElementById("divCusAlamat").style.display = "none"
        //         document.getElementById("divValueCustomer").style.display = "block"
        //     }
        // }

        $(document).ready(function() {
            //fungsi hapus
            // $("#tableBarang").on('click', '.delete-record', function() {
            //     $(this).parent().parent().remove()


            //     $("#tableBarang").find("tr").each(function(index, element) {
            //         let tableData = $(this).find('td'),
            //             total = tableData.eq(7).text()

            //         document.getElementById('value_total_penjualan').value = total;
            //         document.getElementById('total_penjualan').value = formatRupiah(total);
            //     });
            // })

            $("#produk").change(function() {
                document.getElementById("jumlah").disabled = false
                document.getElementById("jumlah").value = null
                document.getElementById("satuan").value = null
                document.getElementById("harga").value = null
                document.getElementById("harga_value").value = null
                document.getElementById("button").disabled = true
            });

            $("#jumlah").keyup(function() {
                var select_peminjam = document.getElementById('produk');
                var id_item = select_peminjam.options[select_peminjam.selectedIndex].value;
                var jml = $(this).val();
                $.ajax({
                    type: "POST",
                    url: '{{ route('item.dropdown_price') }}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        id_item,
                        jml
                    },
                    success: response => {
                        if (response.products != null) {
                            document.getElementById("satuan").value = response.products
                                .satuan;
                            document.getElementById("harga").value = formatRupiah(response
                                .products
                                .harga);
                            document.getElementById("harga_value").value = (response
                                .products
                                .harga);
                            document.getElementById("button").disabled = false
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Belum setting Harga Item!',
                                showConfirmButton: false,
                                timer: 1500,
                            })
                        }

                    },
                    error: (err) => {
                        console.log(err);
                    },
                });
            });


            // $("#save").on('click', function() {
            //     let datapenjualan = []

            //     $("#tableBarang").find("tr").each(function(index, element) {
            //         let tableData = $(this).find('td'),
            //             id_item = tableData.eq(1).text(),
            //             jml = tableData.eq(3).text(),
            //             harga = tableData.eq(5).text()

            //         if (id_item != '') {
            //             datapenjualan.push({
            //                 id_item,
            //                 jml,
            //                 harga
            //             });
            //         }
            //     });

            //     if (datapenjualan.length > 0) {
            //         var id_customer = document.getElementById('nama').value; // dropdown customer
            //         var date = document.getElementById('tgl_penjualan').value;
            //         var total = document.getElementById('value_total_penjualan').value;
            //         var invalidCheck = document.getElementById('invalidCheck').checked;

            //         var add_customer = document.getElementById('add_customer').value;
            //         var add_kontak = document.getElementById('add_kontak').value;
            //         var add_alamat = document.getElementById('add_alamat').value;

            //         jQuery.ajax({
            //             type: "POST",
            //             url: '{{ route('penjualan.store') }}',
            //             dataType: 'json',
            //             data: {
            //                 "_token": "{{ csrf_token() }}",
            //                 date,
            //                 total,
            //                 id_customer,
            //                 invalidCheck,
            //                 add_customer,
            //                 add_kontak,
            //                 add_alamat,
            //                 datapenjualan
            //             },
            //             success: (response) => {
            //                 if (response.code === 200) {
            //                     Swal.fire(
            //                         'Success',
            //                         'Data Penjualan Berhasil di masukan',
            //                         'success'
            //                     ).then(() => {
            //                         var APP_URL = {!! json_encode(url('/')) !!}
            //                         window.location = APP_URL +
            //                             '/penjualan'
            //                     })
            //                 } else {
            //                     Swal.fire({
            //                         icon: 'error',
            //                         title: 'Tanda * (bintang) wajib diisi',
            //                         showConfirmButton: false,
            //                         timer: 1500,
            //                     })
            //                 }
            //             },
            //             error: err => console.log(err)
            //         });
            //     } else {
            //         Swal.fire({
            //             icon: 'error',
            //             title: 'Tidak ada Produk',
            //             showConfirmButton: false,
            //             timer: 1500,
            //         });
            //     }
            // });
        });
    </script>
@endsection
