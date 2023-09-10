@extends('welcome')
@section('content')
<!--HERO--><!--OK-->
<article style="height: 60px; background-color: var(--light-blue);">
    </article>

    <section class="section">
      <div class="container">

        <div class="row">
          <!--ĐĂNG NHẬP-->
          <div class="col-sm-5 col-sm-offset-1">
            <div class="login-form">
              <h2 class="h2 section-title has-underline">
                Đăng nhập
                <span class="dis-block has-before"></span>
              </h2>
              <?php
                    $messagedn= Session::get('messagedn');
                    if($messagedn){
                    echo '<span class="text-warning">'. $messagedn .'</span>';
                        Session::put('messagedn', null);
                    }
               ?>
              <form action="{{URL::to('/costumer-check')}}" method="post">
                {{ csrf_field() }}
                <input type="text" name="KH_SODIENTHOAI" placeholder="Nhập số điện thoại" required="" pattern="[0-9]{10,11}">
                <input type="password" name="KH_MATKHAU" placeholder="Nhập password" required="">
                <button type="submit" class="btn btn-primary">Đăng nhập</button>
              </form>
            </div>
          </div>

          <div class="col-sm-2">
            <p class="section-subtitle mt-5">HOẶC</p>
          </div>
          <!--ĐĂNG KÝ-->
          <div class="col-sm-5">
            <div class="signup-form">
              <h2 class="h2 section-title has-underline">
                Đăng ký
                <span class="dis-block has-before"></span>
              </h2>
              <?php
                    $messagedk= Session::get('messagedk');
                    if($messagedk){
                    echo '<span class="text-warning">'. $messagedk .'</span>';
                        Session::put('messagedk', null);
                    }
               ?>
              <form action="{{URL::to('/dang-ky')}}" method="post" enctype= "multipart/form-data">
                {{ csrf_field() }}
                <input type="text" name="KH_SODIENTHOAI" placeholder="Nhập số điện thoại" required=""
                  pattern="[0-9]{10,11}">
                <input type="password" name="KH_MATKHAU" placeholder="Nhập password" required="">
                <input type="text" name="KH_HOTEN" placeholder="Nhập họ tên" required="">
                <input type="date" name="KH_NGAYSINH" max="<?php echo date('Y-m-d', strtotime('-12 years')); ?>" placeholder="Nhập ngày sinh" required="">
                <style>
                  input[type="radio"] {
                    transform: scale(0.8);
                    /* Điều chỉnh kích thước */
                    height: 20px;
                    margin-top: 12px;
                  }
                </style>
                <div class="row" style=" margin-bottom: 12px;">
                  <div class="col-6" style="display: flex; align-items: center; flex-wrap: nowrap;">
                    <input type="radio" id="nam" name="KH_GIOITINH" value="Nam" required=""
                      style="width: 50px; margin-left: 30%;">
                    <label for="nam">Nam</label>
                  </div>
                  <div class="col-6" style="display: flex; align-items: center; flex-wrap: nowrap;">
                    <input type="radio" id="nu" name="KH_GIOITINH" value="Nữ" required=""
                      style="width: 50px; margin-left: 20%;">
                    <label for="nu">Nữ</label>
                  </div>
                </div>

                <input type="text" name="KH_EMAIL" placeholder="Nhập email" required=""
                  pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}">
                <input type="file" name="KH_DUONGDANANHDAIDIEN" placeholder="Chọn ảnh đại diện">
                <button type="submit" class="btn btn-primary">Đăng ký</button>
              </form>
            </div>
          </div>
        </div>
    </section>
@endsection
