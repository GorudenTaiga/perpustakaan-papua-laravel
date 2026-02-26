<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Daftar Member - Perpustakaan Daerah</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/png" href="images/icon/favicon.ico">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/themify-icons.css">
    <link rel="stylesheet" href="css/metisMenu.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/slicknav.min.css">
    <!-- amchart css -->
    <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css"
        media="all" />
    <!-- others css -->
    <link rel="stylesheet" href="css/typography.css">
    <link rel="stylesheet" href="css/default-css.css">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/responsive.css">
    <!-- modernizr css -->
    <script src="js/vendor/modernizr-2.8.3.min.js"></script>
</head>

<body>
    <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
    <!-- preloader area start -->
    <div id="preloader">
        <div class="loader"></div>
    </div>
    <!-- preloader area end -->
    <!-- login area start -->
    <div class="login-area">
        <div class="container">
            <div class="login-box ptb--100">
                <form method="post" action="{{ route('postRegister') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="login-form-head">
                        <h4>Daftar Member</h4>
                        <p>Selamat datang di Perpustakaan Daerah</p>
                    </div>
                    <div class="login-form-body">
                        <div class="form-gp">
                            <label for="exampleInputName1">Nama Lengkap</label>
                            <input type="text" name="name" id="exampleInputName1">
                            <i class="ti-user"></i>
                            <div class="text-danger"></div>
                        </div>
                        <div class="form-gp">
                            {{-- <input type="text" name="name" id="exampleInputName1"> --}}
                            <select name="jenis" id="exampleInputJenis">
                                <option value="Mahasiswa">Mahasiswa</option>
                                <option value="Dosen">Dosen</option>
                                <option value="Pelajar">Pelajar</option>
                                <option value="Umum">Umum</option>
                            </select>
                            <i class="ti-user"></i>
                            <div class="text-danger"></div>
                        </div>
                        <div class="form-gp">
                            <label for="exampleInputEmail1">Email</label>
                            <input type="email" name="email" id="exampleInputEmail1">
                            <i class="ti-email"></i>
                            <div class="text-danger"></div>
                        </div>
                        <div class="form-gp">
                            <label for="exampleInputPassword1">Password</label>
                            <input type="password" name="password" id="exampleInputPassword1">
                            <i class="ti-lock" onclick="handleShowPassword()"></i>
                            <div class="text-danger"></div>
                        </div>
                        <div class="form-gp">
                            <label for="exampleInputDocument">Dokumen Pendukung</label>
                            <small class="form-text text-muted">Upload surat aktif kuliah/sekolah, KTP, atau dokumen identitas lainnya (Max 2MB)</small>
                            <input type="file" name="document" id="exampleInputDocument" accept=".pdf,.jpg,.jpeg,.png,.webp" class="form-control">
                            <i class="ti-file"></i>
                            <div class="text-danger"></div>
                        </div>
                        <div class="submit-btn-area">
                            <button id="form_submit" type="submit">Daftar <i class="ti-arrow-right"></i></button>
                            {{-- <div class="login-other row mt-4">
                                <div class="col-6">
                                    <a class="fb-login" href="#">Sign up with <i class="fa fa-facebook"></i></a>
                                </div>
                                <div class="col-6">
                                    <a class="google-login" href="#">Sign up with <i class="fa fa-google"></i></a>
                                </div>
                            </div> --}}
                        </div>
                        @session('success')
                            <div class="form-gp">
                                <div class="text-success">{{ session('success') }}</div>
                                <div class="text-success">Silahkan klik tombol Login untuk menuju ke menu Login</div>
                            </div>
                        @endsession
                        <div class="form-footer text-center mt-5">
                            <p class="text-muted">Sudah memiliki akun? <a href="{{ route('login') }}">Login</a></p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- login area end -->

    <!-- jquery latest version -->
    <script>
        function handleShowPassword() {
            const passwordInput = document.getElementById('exampleInputPassword1');
            const icon = document.querySelector('#exampleInputPassword1 + i');
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            if (icon.classList.contains('ti-lock')) {
                icon.classList.remove('ti-lock');
                icon.classList.add('ti-unlock');
            } else {
                icon.classList.remove('ti-unlock');
                icon.classList.add('ti-lock');
            }

        }
    </script>
    <script src="js/vendor/jquery-2.2.4.min.js"></script>
    <!-- bootstrap 4 js -->
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/metisMenu.min.js"></script>
    <script src="js/jquery.slimscroll.min.js"></script>
    <script src="js/jquery.slicknav.min.js"></script>

    <!-- others plugins -->
    <script src="js/plugins.js"></script>
    <script src="js/scripts.js"></script>
</body>

</html>
