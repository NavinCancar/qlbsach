@extends('admin-layout')
@section('admin-content')
                <div class="row my-2 secondary-bg shadow-sm">
                    <h2 class="fs-2 mb-3 p-2 primary-bg text-center primary-text primary-font">Thêm lô xuất</h2>
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
                                <form role="form" action="{{URL::to('/save-lo-xuat')}}" method="post">
                                    {{csrf_field() }}

                                    <div class="form-group"> 
                                        <label for="exampleInputEmail1">Nhân viên xuất</label>
                                        <select name="NV_MA" class="form-control input-sm m-bot15" required="">
                                            @foreach($all_nhan_vien as $key => $nv)
                                                <option value="{{$nv->NV_MA}}">{{$nv->NV_HOTEN}}</option> 
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Ngày xuất</label>
                                        <input type="datetime-local" name="LX_NGAYXUAT" class="form-control" id="exampleInputEmail1" required="">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Nội dung lô xuất</label>
                                        <textarea name="LX_NOIDUNG" id="exampleInputEmail1" cols="30" rows="10" class="form-control" required=""></textarea>
                                    </div>
                                    <button type="submit" name="add_lo_xuat" class="btn btn-search mb-3 mt-2 text-light" style="width: 100%;">Thêm lô xuất</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
@endsection
            