@extends('welcome')
@section('content')
<!--HERO-->
    <article style="height: 60px; background-color: var(--light-blue);">
    </article>

    <section class="section">
        <div class="container">
            <div class="row">
                <p class="section-subtitle">THÔNG TIN</p>
                <h2 class="h2 section-title has-underline">
                    Tài khoản
                    <span class="dis-block has-before"></span>
                </h2>
                <?php
                    $message = Session::get('message');
                    if($message){
                        echo '<span class="text-notice">'.$message.'</span>';
                        Session::put('message',null);
                    }
                ?>
                @foreach($account_info as $key => $account_info)
                <div class="position-center input-form">
                    <form role="form" action="#">
                        <div class="form-group text-center">
                            <label for="exampleInputEmail1"><b>Ảnh đại diện:</b></label>
                            <div style="display: flex; justify-content: center; align-items: center;">
                                <img style="height: 180px; width: 180px;" class="rounded-circle" src="public/frontend/images/khachhang/{{$account_info->KH_DUONGDANANHDAIDIEN}}">
                            </div>
                            <input type="hidden" name="KH_DUONGDANANHDAIDIEN" disabled value="{{$account_info->KH_DUONGDANANHDAIDIEN}}" class="form-control" id="exampleInputEmail1">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1"><b>Họ tên:</b></label>
                            <input type="text" name="KH_HOTEN" disabled value="{{$account_info->KH_HOTEN}}" class="form-control" id="exampleInputEmail1">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1"><b>Ngày sinh:</b></label>
                            <input type="text" name="KH_NGAYSINH" disabled value="{{date('d/m/Y', strtotime($account_info->KH_NGAYSINH))}}" class="form-control" id="exampleInputEmail1">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1"><b>Giới tính:</b></label>
                            <input type="text" name="KH_GIOITINH" disabled value="{{$account_info->KH_GIOITINH}}" class="form-control" id="exampleInputEmail1">
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1"><b>Số điện thoại:</b></label>
                            <input type="text" name="KH_SODIENTHOAI" disabled value="{{$account_info->KH_SODIENTHOAI}}" class="form-control" id="exampleInputEmail1">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1"><b>Email:</b></label>
                            <input type="text" name="KH_EMAIL" disabled value="{{$account_info->KH_EMAIL}}" class="form-control" id="exampleInputEmail1">
                        </div>    
                        <a href="{{URL::to('/cap-nhat-tai-khoan')}}" style="width:100%;" class="btn btn-primary">Cập nhật tài khoản</a>
                    </form>
                </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection