@extends('admin-layout')
@section('admin-content')
                <div class="row my-2 secondary-bg shadow-sm">
                    <h2 class="fs-2 mb-3 p-2 primary-bg text-center primary-text primary-font">Thêm lô nhập</h2>
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
                                <form role="form" action="{{URL::to('/save-lo-nhap')}}" method="post">
                                    {{csrf_field() }}

                                    <div class="form-group"> 
                                        <label for="exampleInputEmail1">Nhân viên nhập</label>
                                        <select name="NV_MA" class="form-control input-sm m-bot15" required="">
                                            @foreach($all_nhan_vien as $key => $nv)
                                                <option value="{{$nv->NV_MA}}">{{$nv->NV_HOTEN}}</option> 
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Ngày nhập</label>
                                        <input type="datetime-local" name="LN_NGAYNHAP" class="form-control" id="exampleInputEmail1" required="">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Nội dung lô nhập</label>
                                        <textarea name="LN_NOIDUNG" id="exampleInputEmail1" cols="30" rows="10" class="form-control"></textarea>
                                    </div>
                                    <button type="submit" name="add_lo_nhap" class="btn btn-search mb-3 mt-2 text-light" style="width: 100%;">Thêm lô nhập</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
@endsection
            