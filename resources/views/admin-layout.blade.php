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

<body>
    <div class="d-flex" id="wrapper">
        <!-- Sidebar -->
        <div class="bg-white" id="sidebar-wrapper">
            <div class="sidebar-heading text-center py-4 primary-text fs-2 fw-bold text-uppercase border-bottom">
                <img src="{{asset('./public/frontend/images/logo-small.png')}}" width="150px">
            </div>
            <div class="list-group list-group-flush my-3">
                <div id="accordion">
                    <div class="card">
                        <a href="{{URL::to('/dashboard')}}" class="list-group-item list-group-item-action bg-transparent primary-text fw-bold">
                            <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                        </a>
                        <!--Sách-->
                        <div class="card-header">
                            <a class="btn list-group-item list-group-item-action bg-transparent primary-text fw-bold"
                                data-bs-toggle="collapse" href="#collapse1">
                                <i class="fas fa-book me-2"></i>Sách
                            </a>
                        </div>
                        <div id="collapse1" class="collapse" data-bs-parent="#accordion">
                            <div class="card-body">
                                <a href="{{URL::to('/add-product')}}"
                                    class="list-group-item list-group-item-action bg-transparent primary-text fw-bold">
                                    Thêm sách
                                </a>
                                <a href="{{URL::to('/all-product')}}"
                                    class="list-group-item list-group-item-action bg-transparent primary-text fw-bold">
                                    Danh sách sách
                                </a>
                            </div>
                        </div>
                        <!--Thể loại sách-->
                        <div class="card-header">
                            <a class="btn list-group-item list-group-item-action bg-transparent primary-text fw-bold"
                                data-bs-toggle="collapse" href="#collapse2">
                                <i class="fas fa-swatchbook me-2"></i>Thể loại sách
                            </a>
                        </div>
                        <div id="collapse2" class="collapse" data-bs-parent="#accordion">
                            <div class="card-body">
                                <a href="{{URL::to('/add-category-product')}}"
                                    class="list-group-item list-group-item-action bg-transparent primary-text fw-bold">
                                    Thêm thể loại sách
                                </a>
                                <a href="{{URL::to('/all-category-product')}}"
                                    class="list-group-item list-group-item-action bg-transparent primary-text fw-bold">
                                    Danh sách thể loại sách
                                </a>
                            </div>
                        </div>

                        <a href="{{URL::to('/thong-ke')}}"
                            class="list-group-item list-group-item-action bg-transparent primary-text fw-bold">
                            <i class="fas fa-chart-bar me-2"></i>Thống kê
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <nav class="navbar navbar-expand-lg navbar-light bg-transparent py-4 px-4">
                <div class="d-flex align-items-center">
                    <i class="fas fa-align-left primary-text fs-4 me-3" id="menu-toggle"></i>
                    <div class="today shadow-sm d-flex justify-content-around align-items-center rounded">
                        <h6><?php
                            $date_array = getdate();
                            $formated_date  = "Hôm nay là: ";
                            $formated_date .= $date_array['mday'] . "/";
                            $formated_date .= $date_array['mon'] . "/";
                            $formated_date .= $date_array['year'];
                            print $formated_date;
                        ?></h6>
                    </div>
                </div>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span><i class="fas fa-caret-down" style="color: var(--dark-blue); font-size: 30px;"></i></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle name fw-bold" href="#" id="navbarDropdown"
                                role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <img alt='' width="40px" class="rounded-full border-5" src="./public/backend/images/nhanvien/<?php
                                        $avt= Session::get('NV_DUONGDANANHDAIDIEN');
                                        if ($avt) {
                                            echo $avt;
                                        }
                                    ?>">
                                <span class="username">
                                    <?php
                                        $name= Session::get('NV_HOTEN');
                                        if($name){
                                            echo $name;
                                        }
                                        $cv= Session::get('CV_MA_User');
                                        ?>
                                </span>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="{{URL::to('/show-employee')}}">Thông tin tài khoản</a></li>
                                <li><a class="dropdown-item" href="{{URL::to('/change-password')}}">Đổi mật khẩu</a></li>
                                <li><a class="dropdown-item" href="{{URL::to('/logout')}}">Đăng xuất</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>

            <div class="container-fluid px-4">

                @yield('admin-content')

            </div>
        </div>
    </div>
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