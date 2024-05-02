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
            <form class="needs-validation" action="{{ route('user.store') }}" enctype="multipart/form-data" method="POST"
                novalidate>
                @csrf
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="validationCustom02" class="form-label">Username</label>
                                            <input type="text" class="form-control" id="username" name="username"
                                                required placeholder="Username" autofocus>
                                            <div class="invalid-feedback">
                                                Data wajib diisi.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="validationCustom02" class="form-label">Email</label>
                                            <input type="email" class="form-control" id="email" name="email"
                                                required placeholder="Email">
                                            <div class="invalid-feedback">
                                                Data wajib diisi.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="validationCustom02" class="form-label">Password</label>
                                            <input type="password" class="form-control" id="password" name="password"
                                                min="5" max="255" required placeholder="Password">
                                            <div class="invalid-feedback">
                                                Data wajib diisi.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-2">
                                            <label class="form-label">Cabang <code>*</code></label>
                                            <select class="form-control select select2 cabang" name="cabang" id="cabang"
                                                required>
                                                <option value="">-- PILIH --</option>
                                                @foreach ($cabang as $ra)
                                                    <option value="{{ $ra->id }}">
                                                        {{ $ra->cabang }}
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
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <a href="{{ route('user.list') }}" class="btn btn-secondary" type="submit"
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
