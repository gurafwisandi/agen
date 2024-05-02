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
                                        <input type="hidden" name="id_pembelian" id="id_pembelian"
                                            value="{{ $list->id }}">
                                        <div class="col-md-3">
                                            <div class="mb-2">
                                                <label for="tgl_kadaluarsa">Tanggal</label>
                                                <div class="input-group" id="datepicker2">
                                                    <input type="text" class="form-control tgl_permintaan"
                                                        placeholder="Tgl" name="tanggal" id="tanggal"
                                                        value="{{ $list->date }}" data-date-format="yyyy-mm-dd"
                                                        data-date-container='#datepicker2' data-provide="datepicker"
                                                        required data-date-autoclose="true" autocomplete="off" disabled>
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
                                                <label for="total_kuantiti">Keterangan<code>*</code></label>
                                                <input type="text" class="form-control" id="keterangan" name="keterangan"
                                                    value="{{ $list->keterangan }}" placeholder="Keterangan"
                                                    autocomplete="off" readonly>
                                                <div class="invalid-feedback">
                                                    Data wajib diisi.
                                                </div>
                                            </div>
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
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($details as $det)
                                                        <tr>
                                                            <td class="text-center">{{ $det->item->nama }}</td>
                                                            <td class="text-center">{{ $det->jml }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="row mt-4">
                                        <div class="col-sm-12">
                                            <a href="{{ route('pembelian.index') }}" class="btn btn-secondary"
                                                type="submit" id="submit">Kembali</a>
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
            var id_pembelian = document.getElementById('id_pembelian').value;
            var jml = document.getElementById('jumlah').value;

            jQuery.ajax({
                type: "POST",
                url: '{{ route('pembelian.store_edit') }}',
                dataType: 'json',
                data: {
                    "_token": "{{ csrf_token() }}",
                    id_pembelian,
                    id_item,
                    jml
                },
                success: (response) => {
                    if (response.code === 200) {
                        Swal.fire(
                            'Success',
                            'Data Pembelian Berhasil di masukan',
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
        }

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
    </script>
@endsection
