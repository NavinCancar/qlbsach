<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Bling Bling - Trang quản trị</title>
  <meta name="title" content="Bling bling online bookstore">
  <link rel="shortcut icon" href="{{asset('./public/frontend/images/logo.png')}}" type="image/x-icon" />
  <!--js-->
  <script src="./assets/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!--css-->
  <link rel="stylesheet" href="{{asset('./public/bootstrap/css/bootstrap.min.css')}}"/>
  <link rel="stylesheet" href="{{asset('./public/backend/css/styles.css')}}">

  <!--fontawesome-->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"
        integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous" />
</head>

<body class="d-flex" id="login-wrapper">
    <form class="mx-auto pt-6 login-form" action="{{URL::to('/admin-dashboard')}}" method="post">
		{{csrf_field()}}
        <div class="sidebar-heading text-center py-2 primary-text fs-2 fw-bold text-uppercase text-center">
            <img src="{{asset('./public/frontend/images/logo-small.png')}}" width="150px">
        </div>
        <h5 class="text-center secondary-font">ĐĂNG NHẬP</h5>
        <div class="mb-3 mt-4">
            <label for="exampleInputEmail1" class="form-label">Email</label>
            <input type="text" name="admin_email" class="form-control login-form-control" id="exampleInputEmail1"
                aria-describedby="emailHelp" require="">
        </div>
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Mật khẩu</label>
            <input type="password" name="admin_password" class="form-control login-form-control" id="exampleInputPassword1" require="">
        </div>
        <button type="submit" class="btn btn-search btn-login mt-3">Đăng nhập</button>
		<?php
            $message = Session::get('message');
            if($message){
                echo '<span class="text-warning">'.$message.'</span>';
                Session::put('message',null);
            }
        ?>
    </form>

    <!-- /#page-content-wrapper -->
</div>

<!--js-->
<script src="{{asset('./public/bootstrap/js/bootstrap.min.js')}}"></script>
<script src="{{asset('./public/backend/js/script.js')}}" defer></script>
<script src="{{asset('./public/bootstrap/js/bootstrap.bundle.js')}}"></script>
<script>
  var el = document.getElementById("wrapper");
  var toggleButton = document.getElementById("menu-toggle");

  toggleButton.onclick = function () {
      el.classList.toggle("toggled");
  };
</script>
</body>

</html>