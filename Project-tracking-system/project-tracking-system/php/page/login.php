<?php
session_start();
if (isset($_SESSION['logged'])) {
    header('location: home.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>เข้าสู่ระบบ</title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../../assets/img/logo-icon.png" />
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="../../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
    <link rel="stylesheet" href="../../dist/css/style.css">
</head>

<body class="hold-transition">
    <div class="login-page">
        <div class="login-box">
            <div class="card card-outline card-primary">
                <div class="card-header text-center">
                    <p class="h3"><strong>Project tracking system</strong></p>
                </div>
                <div class="card-body">
                    <p class="login-box-msg">ยินดีต้อนรับเข้าสู่ระบบ</p>

                    <form action="../../../API/login_api.php" id="form_login" method="POST">
                        <div class="input-group mb-3">
                            <input type="email" class="form-control" placeholder="Email" name="email">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-envelope"></span>
                                </div>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <input type="password" class="form-control" placeholder="Password" name="password">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 text-center">
                                <button type="submit" name="btn_submit" class="btn btn-primary w-100">เข้าสู่ระบบ</button>
                            </div>
                        </div>
                    </form>
                    <!-- <div class="divider d-flex align-items-center my-4">
                        <p class="text-center fw-bold mx-3 mb-0 text-muted">อีเมลและรหัสผ่าน</p>
                    </div>
                    <div class="">
                        <p><b>อีเมล : </b><span>631463010@crru.ac.th</span></p>
                        <p><b>รหัสผ่าน : </b><span>CIT-6oo1</span></p>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
    <!-- jQuery -->
    <script src="../../plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../../dist/js/adminlte.min.js"></script>
    <!-- Sweetalert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            $("#form_login").submit(function(e) {
                e.preventDefault();

                let formUrl = $(this).attr("action");
                let reqMethod = $(this).attr("method");
                let formData = $(this).serialize();

                $.ajax({
                    url: formUrl,
                    type: reqMethod,
                    data: formData,
                    success: function(data) {
                        let result = JSON.parse(data);
                        if (result.status == "success") {
                            Swal.fire({
                                icon: result.status,
                                title: result.title,
                                text: result.msg,
                                showConfirmButton: false,
                                // confirmButtonText: 'ตกลง'
                                timer: 2500
                            }).then(function() {
                                window.location.href = "home.php";
                            });
                        } else {
                            Swal.fire({
                                icon: result.status,
                                title: result.title,
                                text: result.msg,
                            })
                        }
                    }
                })
            })
        })
    </script>
</body>

</html>