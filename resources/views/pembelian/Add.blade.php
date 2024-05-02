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
                <form class="needs-validation">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="mb-2">
                                                <label for="tgl_kadaluarsa">Tanggal</label>
                                                <div class="input-group" id="datepicker2">
                                                    <input type="text" class="form-control tgl_permintaan"
                                                        placeholder="Tgl" name="tanggal" id="tanggal"
                                                        value="{{ date('Y-m-d') }}" data-date-format="yyyy-mm-dd"
                                                        data-date-container='#datepicker2' data-provide="datepicker"
                                                        required data-date-autoclose="true" autocomplete="off">
                                                    <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                                    <div class="invalid-feedback">
                                                        Data wajib diisi.
                                                    </div>
                                                </div>
                                                <div class="invalid-validasi"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="mb-3">
                                                <label for="total_kuantiti">Keterangan</label>
                                                <input type="text" class="form-control" id="keterangan" name="keterangan"
                                                    placeholder="Keterangan" autocomplete="off">
                                                <div class="invalid-feedback">
                                                    Data wajib diisi.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="mb-2">
                                                <label class="form-label">Produk <code>*</code></label>
                                                <select class="form-control select select2 produk" name="produk"
                                                    id="produk" required>
                                                    <option value="">-- PILIH --</option>
                                                    @foreach ($items as $ra)
                                                        <option value="{{ $ra->id }}" data-id="{{ $ra->nama }}">
                                                            {{ $ra->nama }}
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
                                                <label for="jumlah">Jumlah <code>*</code></label>
                                                <input type="number" class="form-control" id="jumlah" name="jumlah"
                                                    placeholder="Jumlah" autocomplete="off" required />
                                                <div class="invalid-feedback">
                                                    Data wajib diisi.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-mb-2">
                                            <a type="submit" id="button" class="btn btn-info w-md"
                                                onclick="btnTambahProduk()">Tambah
                                                Produk</a>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-12 table-responsive">
                                            <table class="table table-responsive table-bordered table-striped"
                                                id="tableBarang">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center" style="width: 20%">Item</th>
                                                        <th class="text-center" style="width: 10%">Jumlah</th>
                                                        <th class="text-center" style="width: 5%">Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="row mt-4">
                                        <div class="col-sm-12">
                                            <a href="{{ route('pembelian.index') }}" class="btn btn-secondary"
                                                type="submit" id="submit">Kembali</a>
                                            <a class="btn btn-primary" type="submit" style="float: right"
                                                id="save">Simpan</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </body>
    <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/alert.js') }}"></script>
    <script>
        function btnTambahProduk() {
            var select_peminjam = document.getElementById('produk');
            var id_item = select_peminjam.options[select_peminjam.selectedIndex].value;
            var nama_produk = select_peminjam.options[select_peminjam.selectedIndex].getAttribute('data-id');
            var jumlah = document.getElementById('jumlah').value;

            document.getElementById('jumlah').value = '';
            $('#produk').val("").trigger('change')

            if (id_item == '' || jumlah == '') {
                Swal.fire({
                    icon: 'error',
                    title: 'Tanda * (bintang) wajib Diisi',
                    showConfirmButton: false,
                    timer: 1500,
                })
            } else {
                $("#tableBarang tr:last").after(`
                <tr>
                    <td class="text-center" hidden>${id_item}</td>
                    <td class="text-center">${nama_produk}</td>
                    <td class="text-center">${jumlah}</td>
                    <td class="text-center">
                        <a href="#" class="text-danger delete-record">
                            <i class="mdi mdi-delete font-size-18"></i>
                        </a>
                    </td>
                </tr>
            `)
            }
        }

        $(document).ready(function() {
            //fungsi hapus
            $("#tableBarang").on('click', '.delete-record', function() {
                $(this).parent().parent().remove()
            })


            $("#save").on('click', function() {
                let datapembelian = []

                $("#tableBarang").find("tr").each(function(index, element) {
                    let tableData = $(this).find('td'),
                        id_item = tableData.eq(0).text(),
                        nama_produk = tableData.eq(1).text(),
                        jumlah = tableData.eq(2).text()

                    if (id_item != '') {
                        datapembelian.push({
                            id_item,
                            jumlah
                        });
                    }
                });

                if (datapembelian.length > 0) {
                    var tanggal = document.getElementById('tanggal').value;
                    var keterangan = document.getElementById('keterangan').value;

                    jQuery.ajax({
                        type: "POST",
                        url: '{{ route('pembelian.store') }}',
                        dataType: 'json',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            datapembelian,
                            tanggal,
                            keterangan
                        },
                        success: (response) => {
                            if (response.code === 200) {
                                Swal.fire(
                                    'Success',
                                    'Data Pembelian Berhasil di masukan',
                                    'success'
                                ).then(() => {
                                    var APP_URL = {!! json_encode(url('/')) !!}
                                    window.location = APP_URL +
                                        '/pembelian'
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
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Tidak ada Produk',
                        showConfirmButton: false,
                        timer: 1500,
                    });
                }
            });

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
        });
    </script>
@endsection
