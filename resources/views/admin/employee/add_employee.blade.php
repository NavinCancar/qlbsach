@extends('admin-layout')
@section('admin-content')
                <div class="row my-2 secondary-bg shadow-sm">
                    <h2 class="fs-2 mb-3 p-2 primary-bg text-center primary-text primary-font">Thêm nhân viên</h2>
                    <?php
                        $message = Session::get('message');
                        if($message){
                            echo '<span class="text-warning">'.$message.'</span></br>';
                            Session::put('message',null);
                        }
                    ?>
                    <!--Content--> 
                    <div class="col">
                        <div class="panel-body bg-white rounded shadow-sm center mb-3 p-3">
                            <div class="position-center">
                                <form role="form" action="{{URL::to('/save-employee')}}" method="post" enctype= "multipart/form-data">
                                    {{csrf_field() }}
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Tên nhân viên</label>
                                        <input type="text" name="NV_HOTEN" class="form-control" id="exampleInputEmail1" placeholder="Tên nhân viên" required="">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Chức vụ</label>
                                        <select name="CV_MA" class="form-control input-sm m-bot15" required="">
                                            @foreach($position as $key => $pos)
                                                <option value="{{$pos->CV_MA}}">{{$pos->CV_TEN}}</option>
                                            @endforeach
                                                
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Số điện thoại</label>
                                        <input type="text" name="NV_SODIENTHOAI" class="form-control" id="exampleInputEmail1" placeholder="Số điện thoại nhân viên" required="" pattern="[0-9]{10,11}">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Địa chỉ</label>
                                        <input type="text" name="NV_DIACHI" class="form-control" id="exampleInputEmail1" placeholder="Địa chỉ nhân viên" required="">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Ngày sinh</label>
                                        <input type="date" name="NV_NGAYSINH" class="form-control" id="exampleInputEmail1" placeholder="Ngày sinh nhân viên"  max="<?php echo date('Y-m-d', strtotime('-18 years')); ?>" required="">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Giới tính</label>
                                        <input type="text" name="NV_GIOITINH" class="form-control" id="exampleInputEmail1" placeholder="Giới tính nhân viên" required="">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Email</label>
                                        <input type="text" name="NV_EMAIL" class="form-control" id="exampleInputEmail1" placeholder="Email nhân viên" required="" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Ảnh đại diện</label>
                                        <style>
                                            #file-input-f {
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
                                            <label for="file-input-f" >
                                                <img class="circle" src="{{URL::to('public/backend/images/nhanvien/macdinh.png')}}" height="200" width="200" id="img-preview" src="" alt="Image Preview">
                                                <input type="file" name="NV_DUONGDANANHDAIDIEN" class="form-control" id="file-input-f" required="">

                                            </label>
                                        </div>
                                    </div>
                                    <button type="submit" name="add_employee" class="btn btn-search mb-3 mt-2 text-light" style="width: 100%;">Thêm nhân viên</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
<script>
    const fileInput = document.getElementById('file-input-f');
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
            