@extends('admin-layout')
@section('admin-content')
                <div class="row my-2 secondary-bg shadow-sm">
                    <h2 class="fs-2 mb-3 p-2 primary-bg text-center primary-text primary-font">Cập nhật nhà xuất bản</h2>
                    <?php
                        $message = Session::get('message');
                        if($message){
                            echo '<span class="text-warning">'.$message.'</span></br>';
                            Session::put('message',null);
                        }
                    ?>
                    <!--Content--> 
                    @foreach($edit_nhaxuatban as $key => $edit_value)
                    <div class="col">
                        <div class="panel-body bg-white rounded shadow-sm center mb-3 p-3">
                            <div class="position-center">
                                <form role="form" action="{{URL::to('/update-nhaxuatban/'.$edit_value->NXB_MA)}}" method="post">
                                    {{csrf_field() }}
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Tên nhà xuất bản</label>
                                        <input type="text" name="NXB_TEN" value="{{$edit_value->NXB_TEN}}" class="form-control" id="exampleInputEmail1" required="">
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Số điện thoại nhà xuất bản</label>
                                        <input type="text" name="NXB_SODIENTHOAI" value="{{$edit_value->NXB_SODIENTHOAI}}" class="form-control" id="exampleInputEmail1" required="">
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Địa chỉ nhà xuất bản</label>
                                        <input type="text" name="NXB_DIACHI" value="{{$edit_value->NXB_DIACHI}}" class="form-control" id="exampleInputEmail1" required="">
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Email nhà xuất bản</label>
                                        <input type="text" name="NXB_EMAIL" value="{{$edit_value->NXB_EMAIL}}" class="form-control" id="exampleInputEmail1" required="">
                                    </div>

                                    
                                    <button type="submit" name="update_nhaxuatban" class="btn btn-search mb-3 mt-2 text-light" style="width: 100%;">Cập nhật nhà xuất bản</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
@endsection
            