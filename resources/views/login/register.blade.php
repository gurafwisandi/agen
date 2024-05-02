<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Register | Skote - Admin & Dashboard Template</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
        <meta content="Themesbrand" name="author" />
        <link rel="shortcut icon" href="{{ URL::asset('assets/images/favicon.ico') }}">
        <link href="{{ URL::asset('assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <link href="{{ URL::asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ URL::asset('assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
    </head>
    <body>
        <div class="account-pages my-5 pt-sm-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card overflow-hidden">
                            <div class="bg-primary bg-soft">
                                <div class="row">
                                    <div class="col-7">
                                        <div class="text-primary p-4">
                                            <h5 class="text-primary">Free Register</h5>
                                            <p>Get your free Skote account now.</p>
                                        </div>
                                    </div>
                                    <div class="col-5 align-self-end">
                                        <img src="{{ URL::asset('assets/images/profile-img.png') }}" alt="" class="img-fluid">
                                    </div>
                                </div>
                            </div>
                            <div class="card-body pt-0"> 
                                <div>
                                    <a>
                                        <div class="avatar-md profile-user-wid mb-4">
                                            <span class="avatar-title rounded-circle bg-light">
                                                <img src="{{ URL::asset('assets/images/logo.svg') }}" alt="" class="rounded-circle" height="34">
                                            </span>
                                        </div>
                                    </a>
                                </div>
                                @if (session()->has('registerError'))
                                    <div class="p-2">
                                        <div class="alert alert-danger" role="alert">
                                            Register Fail!
                                        </div>
                                    </div>
                                @endif
                                @if (count($errors) > 0)
                                    <div class="p-2">
                                        <div class="alert alert-danger" role="alert">
                                            Register Fail!
                                        </div>
                                    </div>
                                @endif
                                <div class="p-2">
                                    <form class="needs-validation" novalidate action="{{ route('login.store') }}" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="useremail" class="form-label">Email</label>
                                            <input type="email" name="email" class="form-control" id="email" placeholder="Enter email" required autofocus>  
                                            <div class="invalid-feedback">
                                                Email wajib diisi dan sesuai format
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="username" class="form-label">Username</label>
                                            <input type="text" name="name" class="form-control" id="username" placeholder="Enter username" required>
                                            <div class="invalid-feedback">
                                                Nama wajib diisi
                                            </div>  
                                        </div>
                                        <div class="mb-3">
                                            <label for="userpassword" class="form-label">Password</label>
                                            <input type="password" name="password" class="form-control" id="userpassword" placeholder="Enter password" required>
                                            <div class="invalid-feedback">
                                                Password wajib diisi
                                            </div>       
                                        </div>
                                        <div class="mt-4 d-grid">
                                            <button class="btn btn-primary waves-effect waves-light" type="submit">Register</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="mt-5 text-center">
                            <div>
                                <p>Already have an account ? <a href="{{ url('/') }}" class="fw-medium text-primary"> Login</a> </p>
                                <p>© <script>document.write(new Date().getFullYear())</script> Skote. Crafted with <i class="mdi mdi-heart text-danger"></i> by Themesbrand</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('assets/libs/metismenu/metisMenu.min.js') }}"></script>
        <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
        <script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>
        <script src="{{ asset('assets/js/app.js') }}"></script>
        <script src="{{ asset('assets/js/pages/form-validation.init.js') }}"></script>
    </body>
</html>