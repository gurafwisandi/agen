@extends('layouts.main')
@section('container')
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
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="validationCustom02" class="form-label">Item</label>
                                        <input type="text" class="form-control" id="item" name="item" disabled
                                            placeholder="Item" value="{{ $list->nama }}" autofocus>
                                        <div class="invalid-feedback">
                                            Data wajib diisi.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label>Keterangan</label>
                                        <textarea type="text" name="keterangan" class="form-control" id="keterangan" placeholder="Keterangan"
                                            autocomplete="off" disabled>{{ $list->keterangan }}</textarea>
                                        <div class="invalid-feedback">
                                            Data wajib diisi.
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="validationCustom02" class="form-label">Stok</label>
                                        <input type="text" class="form-control" id="item" name="item" disabled
                                            placeholder="Item" value="{{ $list->stok }}" autofocus>
                                        <div class="invalid-feedback">
                                            Data wajib diisi.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="validationCustom02" class="form-label">Satuan
                                            <code>*</code></label>
                                        <select class="form-control select select2" name="id_satuan" id="id_satuan"
                                            disabled>
                                            <option value="">--Pilih Satuan--
                                            </option>
                                            @foreach ($satuan as $ra)
                                                <option value="{{ $ra->id }}"
                                                    {{ $ra->id == $list->id_satuan ? 'selected' : '' }}>
                                                    {{ $ra->satuan }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback">
                                            Data wajib diisi.
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <form class="needs-validation" action="{{ route('item.store_price') }}" method="POST"
                                novalidate>
                                @csrf
                                <input type="hidden" name="id_item" value="{{ $list->id }}">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="validationCustom02" class="form-label">Jumlah
                                                <code>*</code></label>
                                            <input type="number" class="form-control" id="jml" name="jml"
                                                required placeholder="Jumlah">
                                            <div class="invalid-feedback">
                                                Data wajib diisi.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="validationCustom02" class="form-label">Harga
                                                <code>*</code></label>
                                            <input type="number" class="form-control" id="harga" name="harga"
                                                required placeholder="Harga">
                                            <div class="invalid-feedback">
                                                Data wajib diisi.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 align-self-center">
                                        <div class="d-grid">
                                            <button class="btn btn-success" style="margin-top: 10px;" type="submit"
                                                id="submit">Simpan</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <table id="datatable" class="table table-striped dt-responsive nowrap w-100">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Jml</th>
                                                        <th>Harga</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($harga as $har)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ number_format($har->jml) }}</td>
                                                            <td>{{ number_format($har->harga) }}</td>
                                                            <td>
                                                                <?php $Id = Crypt::encryptString($har->id); ?>
                                                                <form class="delete-form"
                                                                    action="{{ route('item.destroy_price', $Id) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <div class="d-flex gap-3">
                                                                        <a href class="text-danger delete_confirm"><i
                                                                                class="mdi mdi-delete font-size-18"></i></a>
                                                                    </div>
                                                                </form>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <a href="{{ route('item.index') }}" class="btn btn-secondary" type="submit"
                                            id="submit">Kembali</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- container-fluid -->
    </div>
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
    </script>
@endsection
<script src="{{ asset('assets/js/pages/lightbox.init.js') }}"></script>
