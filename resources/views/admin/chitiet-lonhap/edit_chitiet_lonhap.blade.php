@extends('admin-layout')
@section('admin-content')
                <div class="row my-2 secondary-bg shadow-sm">
                    <h2 class="fs-2 mb-3 p-2 primary-bg text-center primary-text primary-font">Cập nhật chi tiết lô nhập
                        <?php
                            $LN_MA = Session::get('LN_MA');
                            if($LN_MA){echo $LN_MA;}
                        ?>
                    </h2>

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
                                @foreach($edit_lonhap as $key => $edit_value)
                                    <form role="form" action="{{URL::to('/update-chitiet-lonhap/lo='.$edit_value->LN_MA.'&sach='.$edit_value->SACH_MA)}}" method="post">
                                        {{csrf_field() }}

                                        <div class="form-group"> 
                                            <label for="exampleInputEmail1">Tên sách nhập</label>
                                            <select  disabled name="SACH_MA" class="form-control input-sm m-bot15" required="">
                                                @foreach($sach as $key => $masach)
                                                    @if($masach->SACH_MA==$edit_value->SACH_MA)
                                                    <option selected value="{{$masach->SACH_MA}}">{{$masach->SACH_TEN}}</option>
                                                    @else
                                                    <option value="{{$masach->SACH_MA}}">{{$masach->SACH_TEN}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Số lượng</label>
                                            <input type="text" value="{{$edit_value->CTLN_SOLUONG}}" name="CTLN_SOLUONG" class="form-control" id="exampleInputEmail1" placeholder="Số lượng" required=""  pattern="[0-9]+">
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Giá</label>
                                            <input type="text" value="{{$edit_value->CTLN_GIA}}" name="CTLN_GIA" class="form-control" id="exampleInputEmail1" placeholder="Giá" required=""  pattern="[0-9]+">
                                        </div>
                                        <button type="submit" name="add_chitiet_lonhap" class="btn btn-search mb-3 mt-2 text-light" style="width: 100%;">Cập nhật chi tiết lô nhập</button>
                                    </form>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <?php Session::put('LN_MA',null); ?>
@endsection