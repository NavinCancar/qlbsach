@extends('admin-layout')
@section('admin-content')
                <div class="row my-2 secondary-bg shadow-sm">
                    <h2 class="fs-2 mb-3 p-2 primary-bg text-center primary-text primary-font">Thông tin tài khoản</h2>
                    <?php
                        $message = Session::get('message');
                        if($message){
                            echo '<span class="text-warning">'.$message.'</span></br>';
                            Session::put('message',null);
                        }
                    ?>
                    <!--Content--> 
                    @foreach($edit_employee as $key => $edit_value)
                    <div class="col">
                        <div class="panel-body bg-white rounded shadow-sm center mb-3 p-3">
                            <div class="position-center">
                                <form role="form" method="post" enctype= "multipart/form-data">
                                    {{csrf_field() }}
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Tên nhân viên</label>
                                        <input type="text" disabled value="{{$edit_value->NV_HOTEN}}" name="NV_HOTEN" class="form-control" id="exampleInputEmail1" placeholder="Tên nhân viên" required="">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Chức vụ</label>
                                        <select disabled name="CV_MA" class="form-control input-sm m-bot15" required="">

                                            @foreach($position as $key => $pos)
                                                
                                                @if($pos->CV_MA==$edit_value->CV_MA)
                                                <option selected value="{{$pos->CV_MA}}">{{$pos->CV_TEN}}</option>
                                                @else
                                                <option value="{{$pos->CV_MA}}">{{$pos->CV_TEN}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Số điện thoại</label>
                                        <input type="text" disabled value="{{$edit_value->NV_SODIENTHOAI}}" name="NV_SODIENTHOAI" class="form-control" id="exampleInputEmail1" placeholder="Tên nhân viên" required="">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Địa chỉ</label>
                                        <input type="text"disabled value="{{$edit_value->NV_DIACHI}}" name="NV_DIACHI" class="form-control" id="exampleInputEmail1" placeholder="Tên nhân viên" required="">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Ngày sinh</label>
                                        <input type="date" disabled value="{{$edit_value->NV_NGAYSINH}}" name="NV_NGAYSINH" class="form-control" id="exampleInputEmail1" placeholder="Tên nhân viên" required="">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Giới tính</label>
                                        <input type="text" disabled value="{{$edit_value->NV_GIOITINH}}" name="NV_GIOITINH" class="form-control" id="exampleInputEmail1" placeholder="Tên nhân viên" required="">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Email</label>
                                        <input type="text" disabled value="{{$edit_value->NV_EMAIL}}" name="NV_EMAIL" class="form-control" id="exampleInputEmail1" placeholder="Tên nhân viên" required="">
                                    </div>
                                    <div class="form-group">
                                        <p><label for="exampleInputEmail1"><b>Ảnh đại diện:</b></label></p>
                                        <img src="{{URL::to('public/backend/images/nhanvien/'.$edit_value->NV_DUONGDANANHDAIDIEN)}}" class="rounded-circle" height="200" width="200">
                                        <input type="hidden" name="NV_DUONGDANANHDAIDIEN" disabled value="{{$edit_value->NV_DUONGDANANHDAIDIEN}}" class="form-control" id="exampleInputEmail1">
                                        
                                    </div>

                                    <a href="{{URL::to('/edit-employee/'.$edit_value -> NV_MA)}}" class="btn btn-search mb-3 mt-2 text-light" style="width: 100%;">Cập nhật tài khoản</a>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
@endsection
                                
                                


            