@extends('admin-layout')
@section('admin-content')
                <div class="row my-2 secondary-bg shadow-sm">
                    <h2 class="fs-2 mb-3 p-2 primary-bg text-center primary-text primary-font">Cập nhật lô xuất</h2>
                    <?php
                        $message = Session::get('message');
                        if($message){
                            echo '<span class="text-warning">'.$message.'</span></br>';
                            Session::put('message',null);
                        }
                    ?>
                    <!--Content--> 
                    @foreach($edit_lo_xuat as $key => $edit_value)
                    <div class="col">
                        <div class="panel-body bg-white rounded shadow-sm center mb-3 p-3">
                            <div class="position-center">
                                <form role="form" action="{{URL::to('/update-lo-xuat/'.$edit_value->LX_MA)}}" method="post">
                                    {{csrf_field() }}

                                    
                                    <div class="form-group"> 
                                        <label for="exampleInputEmail1">Nhân viên xuất</label>
                                        <select name="NV_MA" class="form-control input-sm m-bot15" required="">
                                            @foreach($all_nhan_vien as $key => $nv)
                                            
                                            @if($nv->NV_MA==$edit_value->NV_MA)
                                            <option selected value="{{$nv->NV_MA}}">{{$nv->NV_HOTEN}}</option>
                                            @else
                                            <option value="{{$nv->NV_MA}}">{{$nv->NV_HOTEN}}</option>
                                            @endif
                                        @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Ngày xuất</label>
                                        <input type="datetime-local" value="{{$edit_value->LX_NGAYXUAT}}" name="LX_NGAYXUAT" class="form-control" id="exampleInputEmail1" required="">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Nội dung lô xuất</label>
                                        <textarea name="LX_NOIDUNG" id="exampleInputEmail1" cols="30" rows="10" class="form-control" required="">{{$edit_value->LX_NOIDUNG}}</textarea>
                                    </div>
                                    <button type="submit" name="update_lo_xuat" class="btn btn-search mb-3 mt-2 text-light" style="width: 100%;">Cập nhật lô xuất</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
@endsection
            