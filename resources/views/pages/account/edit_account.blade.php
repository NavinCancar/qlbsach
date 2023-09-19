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
                    <form role="form" action="{{URL::to('/update-tai-khoan')}}" method="post" enctype= "multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group text-center">
                            <label for="exampleInputEmail1"><b>Ảnh đại diện:</b></label>
                            <input type="hidden" name="KH_DUONGDANANHDAIDIEN" disabled value="{{$account_info->KH_DUONGDANANHDAIDIEN}}" class="form-control" id="exampleInputEmail1">
                            <style>
                                #file-input {
                                display: none;
                                }

                                .circle {
                                display: flex;
                                justify-content: center;
                                align-items: center;
                                height: 200px;
                                width: 200px;
                                border-radius: 50%;
                                border: 3px solid white;
                                font-size: 60px;
                                font-weight: bold;
                                color: black;
                                cursor: pointer;
                                }

                                .circle:hover {
                                background-color: #f2f2f2;
                                }

                                label {
                                margin: 0;
                                }
                            </style>
                        
                            <div class="container">
                                <label for="file-input" >
                                    <img class="circle" src="public/frontend/images/khachhang/{{$account_info->KH_DUONGDANANHDAIDIEN}}" id="img-preview" src="" alt="Image Preview">
                                    <input type="file" name="KH_DUONGDANANHDAIDIEN" class="form-control"  id="file-input">
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1"><b>Họ tên:</b></label>
                            <input type="text" name="KH_HOTEN" value="{{$account_info->KH_HOTEN}}" class="form-control" id="exampleInputEmail1" required="">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1"><b>Ngày sinh:</b></label>
                            <input type="date" name="KH_NGAYSINH" value="{{$account_info->KH_NGAYSINH}}" class="form-control" id="exampleInputEmail1"  max="<?php echo date('Y-m-d', strtotime('-15 years')); ?>" required="">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1"><b>Giới tính:</b></label>
                            <input type="text" name="KH_GIOITINH" value="{{$account_info->KH_GIOITINH}}" class="form-control" id="exampleInputEmail1" required="">
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1"><b>Số điện thoại:</b></label>
                            <input type="text" name="KH_SODIENTHOAI" value="{{$account_info->KH_SODIENTHOAI}}" class="form-control" id="exampleInputEmail1"required=""  pattern="[0-9]{10,11}">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1"><b>Email:</b></label>
                            <input type="text" name="KH_EMAIL" value="{{$account_info->KH_EMAIL}}" class="form-control" id="exampleInputEmail1" required=""  pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}">
                        </div> 
                        <button type="submit" style="width:100%;" class="btn btn-primary">Lưu cập nhật</button>
                    </form>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    <script>
        const fileInput = document.getElementById('file-input');
        const imgPreview = document.getElementById('img-preview');

        fileInput.addEventListener('change', (event) => {
        const file = event.target.files[0];
        const reader = new FileReader();

        reader.addEventListener('load', (event) => {
            imgPreview.src = event.target.result;
        });

        reader.readAsDataURL(file);
        }); 
    </script>
@endsection
                        

                    
