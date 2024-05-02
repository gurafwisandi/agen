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
            <form class="needs-validation" action="{{ route('item.update', Crypt::encryptString($list->id)) }}"
                enctype="multipart/form-data" method="POST" novalidate>
                @csrf
                @method('PATCH')
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="validationCustom02" class="form-label">Item</label>
                                            <input type="text" class="form-control" id="item" name="item"
                                                required placeholder="Item" value="{{ $list->nama }}" autofocus>
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
                                                required>
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
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label>Keterangan</label>
                                            <textarea type="text" name="keterangan" class="form-control" id="keterangan" placeholder="Keterangan"
                                                autocomplete="off" required>{{ $list->keterangan }}</textarea>
                                            <div class="invalid-feedback">
                                                Data wajib diisi.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <a href="{{ route('item.index') }}" class="btn btn-secondary" type="submit"
                                                id="submit">Kembali</a>
                                            <button class="btn btn-primary" type="submit" id="submit">Simpan</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div> <!-- container-fluid -->
    </div>
    <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
@endsection
<script src="{{ asset('assets/js/pages/lightbox.init.js') }}"></script>
