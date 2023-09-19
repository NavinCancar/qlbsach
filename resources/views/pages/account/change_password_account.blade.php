@extends('welcome')
@section('content')
<!--HERO-->
    <article style="height: 60px; background-color: var(--light-blue);">
    </article>

    <section class="section">
        <div class="container">
            <div class="row">
                <p class="section-subtitle">CẬP NHẬT</p>
                <h2 class="h2 section-title has-underline">
                    Mật khẩu
                    <span class="dis-block has-before"></span>
                </h2>
                <?php
                    $message = Session::get('message');
                    if($message){
                        echo '<span class="text-notice">'.$message.'</span>';
                        Session::put('message',null);
                    }
                ?>
                <div class="position-center input-form">
                <form role="form" action="{{URL::to('/update-mat-khau')}}" method="post" enctype= "multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="exampleInputEmail1"><b>Mật khẩu cũ:</b></label>
                            <input type="password" name="KH_MATKHAUCU" class="form-control" id="exampleInputEmail1" required="">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1"><b>Mật khẩu mới:</b></label>
                            <input type="password" name="KH_MATKHAUMOI1" class="form-control" id="exampleInputEmail1" required="">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1"><b>Nhập lại mật khẩu mới:</b></label>
                            <input type="password" name="KH_MATKHAUMOI2" class="form-control" id="exampleInputEmail1" required="">
                        </div>
                        <button type="submit" style="width:100%;" class="btn btn-primary">Đổi mật khẩu</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection