<!DOCTYPE html>
<html lang="en">
<!--OK-->
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Bling Bling - Cửa hàng sách</title>
  <meta name="title" content="Bling bling online bookstore">
  <link rel="shortcut icon" href="{{asset('public/frontend/images/logo.png')}}" type="image/x-icon" />
  <!--js-->
  <script src="{{asset('./public/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

  <!--css-->
  <link rel="stylesheet" href="{{asset('./public/bootstrap/css/bootstrap.min.css')}}"/>
  <link rel="stylesheet" href="{{asset('./public/frontend/css/style.css')}}">

  <!--fontawesome-->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"
        integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous" />
<body>

  <!--HEADER-->
 
 
  <header class="header nav-line" data-header>
    <div class="container">
      <a href="{{ URL::to('/trang-chu')}}" class="logo">Bling Bling</a>

      <nav class="navbar" data-navbar>
        <ul class="navbar-list">
          <li class="navbar-item">
            <form class="d-flex" action="{{ URL::to('/tim-kiem') }}" method="POST">
              {{ csrf_field() }}
              <input name="keyword" type="text" placeholder="Nhập sách cần tìm..." class="search" >
              <button type="submit" style="padding-left: 5px;"><i class="fa fa-search navbar-link"></i></button>
            </form>
          </li>

          <li class="navbar-item">
            <a href="{{ URL::to('/trang-chu')}}" class="navbar-link" data-nav-link>
              <i class="fa fa-home"></i> Trang chủ
            </a>
          </li>
          
          <li class="navbar-item">
            <div class="dropdown">
            <a class="navbar-link dropdown-toggle" href="#" id="navbarScrollingDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="fa fa-list"></i> Danh mục
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarScrollingDropdown">
              <li><a class="dropdown-item" href="{{ URL::to('/danh-muc-san-pham/tat-ca')}}">Tất cả sản phẩm</a></li>
              <li><hr class="dropdown-divider"></li>
              @foreach($category as $key => $cate)
                <li><a class="dropdown-item" href="{{ URL::to('/danh-muc-san-pham/'. $cate->TLS_MA) }}">{{ $cate->TLS_TEN }}</a></li>
              @endforeach
            </ul></div>
          </li>

          <li class="navbar-item">
            <a href="{{URL::to('/show-cart')}}" class="navbar-link" data-nav-link><i class="fa fa-shopping-cart"></i>
              <?php 
                $idkh= Session::get('KH_MA');
                if($idkh){
                  $sl_ghkh = DB::table('chi_tiet_gio_hang')
                            ->join('gio_hang','chi_tiet_gio_hang.GH_MA','=','gio_hang.GH_MA')
                            ->where('gio_hang.KH_MA',$idkh)->count('chi_tiet_gio_hang.SACH_MA');
                  echo '<i class="badge rounded-pill" style="background-color: var(--blue); position: relative; /* Đảm bảo rằng phần tử sử dụng vị trí tương đối */
                  top: -10px; left: -7px /* Dịch chuyển phần tử lên 2px so với vị trí ban đầu */">'.$sl_ghkh.'</i>';
                }
              ?>Giỏ hàng
            </a>
          </li>

          <li class="navbar-item">
            <?php
              $name= Session::get('KH_HOTEN');
              if($name){  
                  echo'<div class="dropdown">';
                      echo'<a class="navbar-link dropdown-toggle" href="#" id="navbarScrollingDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">';

                      echo $name;

                      echo '</a>
                      <ul class="dropdown-menu" aria-labelledby="navbarScrollingDropdown">';
                      echo'<li><a class="dropdown-item"  href="'.URL::to('/tai-khoan').'"><i class=" fa fa-user-circle"></i> Tài khoản</a></li>';
                      echo'<li><a class="dropdown-item"  href="'.URL::to('/doi-mat-khau').'"><i class=" fa fa-key"></i> Đổi mật khẩu</a></li>';
                      echo'<li><a class="dropdown-item"  href="'.URL::to('/dia-chi-giao-hang').'" ><i class="fa fa-location-arrow"></i> Địa chỉ giao hàng</a></li>';
                      echo'<li><a class="dropdown-item"  href="'.URL::to('/dang-xuat').'"><i class="fa fa-sign-out-alt"></i> Đăng xuất</a></li>';
                      echo '</ul>
                      </div>';
              }
                          
              else echo '<a href="'.URL::to('/dang-nhap').'" class="navbar-link" data-nav-link><i class="fa fa-user"></i> Đăng ký/Đăng nhập</a>';
            ?>
          </li>
           
          <li class="navbar-item">        
            <?php
               $avt= Session::get('KH_DUONGDANANHDAIDIEN');
               if ($avt) {
                   echo '<img style="width:2.5em" class ="rounded-circle" alt="" src="../public/frontend/images/khachhang/'.$avt.'">';
               }
            ?>
          </li>
        </ul>
      </nav>

      <button class="nav-toggle-btn" aria-label="toggle menu" data-nav-toggler>
        <i class="fa fa-bars open" name="menu-outline" aria-hidden="true"></i>
        <i class="fa fa-times close" name="close-outline" aria-hidden="true"></i>
      </button>
    </div>
    @if(session('alert'))
        <!--<section class='alert alert-success'>{{session('alert')}}</section>-->
        <script language="Javascript"> alert ("{{session('alert')}}")</script>
    @endif
  </header>

  <main>
    @yield('content')
  </main>

  <!--FOOTER-->

  <footer class="footer">
    <div class="container">
      <div class="footer-top">
        <a href="#" class="logo"><img src="{{('../public/frontend/images/banner-bottom.png')}}"></a>
        <ul class="footer-list social-link pt-4">
            <li>
              <a href="#" class="btn"><i class="fab fa-twitter"></i></a>
            </li>
            <li>
              <a href="#" class="btn"><i class="fab fa-facebook-f"></i></i></a>
            </li>
            <li>
              <a href="#" class="btn"><i class="fab fa-instagram"></i></a>
            </li>
            <li>
              <a href="#" class="btn"><i class="fab fa-youtube"></i></a>
            </li>
            <li>
              <a href="#" class="btn"><i class="fab fa-tiktok"></i></a>
            </li>
        </ul>
      </div>

      <div class="container row">
        <div class="col-sm-4">
          <ul>
            <li>
              <p class="section-subtitle">DỊCH VỤ</p>
            </li>
            <li>
              <a href="#" class="footer-link">Điều khoản sử dụng</a>
            </li>
            <li>
              <a href="#" class="footer-link">Chính sách bảo mật thông tin cá nhân</a>
            </li>
            <li>
              <a href="#" class="footer-link">Chính sách bảo mật thanh toán</a>
            </li>
            <li>
              <a href="#" class="footer-link">Chính sách bảo mật đơn hàng</a>
            </li>
            <li>
              <a href="#" class="footer-link">Giới thiệu Bling bling</a>
            </li>
          </ul>
        </div>
        <div class="col-sm-4">
          <ul>
            <li>
              <p class="section-subtitle">HỖ TRỢ</p>
            </li>
            <li>
              <a href="#" class="footer-link">Chính sách đổi - trả - hoàn tiền</a>
            </li>
            <li>
              <a href="#" class="footer-link">Chính sách bảo hành - bồi hoàn</a>
            </li>
            <li>
              <a href="#" class="footer-link">Chính sách vận chuyển</a>
            </li>
            <li>
              <a href="#" class="footer-link">Chính sách khách sỉ</a>
            </li>
            <li>
              <a href="#" class="footer-link">Phương thức thanh toán và xuất HĐ</a>
            </li>
          </ul>
        </div>
        <div class="col-sm-4">
            <ul>
              <ul>
              <li>
                <p class="section-subtitle">NHÓM 4</p>
              </li>
              <li>
                <p class="footer-list-text">Nguyễn Phương Hiếu B2003737</p>
              </li>
              <li>
                <p class="footer-list-text">Nguyễn Thị Ngọc Hương B2003741</p>
              </li>
              <li>
                <p class="footer-list-text">Vũ Thị Hương Khoa B2011972</p>
              </li>
            </ul>
            </ul>
        </div>
      </div>
    </div>
  </footer>
  <!--js-->
  <script src="{{asset('./public/bootstrap/js/bootstrap.min.js')}}"></script>
  <script src="{{asset('./public/frontend/js/script.js')}}" defer></script>
  <script src="{{asset('./public/bootstrap/js/bootstrap.bundle.js')}}"></script>
</body>

</html>