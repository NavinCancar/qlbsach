@extends('admin-layout')
@section('admin-content')
                <div class="row my-2 secondary-bg shadow-sm">
                    <h2 class="fs-2 mb-3 p-2 primary-bg text-center primary-text primary-font">Đổi mật khẩu</h2>
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
                                <form role="form" action="{{URL::to('/update-password')}}" method="post" enctype= "multipart/form-data">
                                    {{csrf_field() }}
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Mật khẩu cũ</label>
                                        <input type="password" name="NV_MATKHAUCU" class="form-control" id="exampleInputEmail1" required="">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Mật khẩu mới</label>
                                        <input type="password" name="NV_MATKHAUMOI1" class="form-control" id="exampleInputEmail1" required="">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Nhập lại mật khẩu mới</label>
                                        <input type="password" name="NV_MATKHAUMOI2" class="form-control" id="exampleInputEmail1" required="">
                                    </div>
                                    <button type="submit" name="update_password"  class="btn btn-search mb-3 mt-2 text-light" style="width: 100%;">Cập nhật mật khẩu</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
@endsection