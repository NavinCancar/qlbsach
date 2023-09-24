@extends('admin-layout')
@section('admin-content')
                <div class="row my-2 secondary-bg shadow-sm">
                    <h2 class="fs-2 mb-3 p-2 primary-bg text-center primary-text primary-font">Thêm chi tiết lô nhập
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
                                <form role="form" action="{{URL::to('/save-chitiet-lonhap/'.$LN_MA)}}" method="post">
                                    {{csrf_field() }}

                                    <div class="form-group"> 
                                        <label for="exampleInputEmail1">Tên sách nhập</label>
                                        <select name="SACH_MA" class="form-control input-sm m-bot15" required="">
                                            @foreach($sach as $key => $masach)
                                                <option value="{{$masach->SACH_MA}}">{{$masach->SACH_TEN}}</option> 
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Số lượng</label>
                                        <input type="number" min="1" name="CTLN_SOLUONG" class="form-control" id="exampleInputEmail1" placeholder="Số lượng" required="">
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Giá</label>
                                        <input type="number" min="0" name="CTLN_GIA" class="form-control" id="exampleInputEmail1" placeholder="Giá" required="">
                                    </div>
                                    <button type="submit" name="add_chitiet_lonhap" class="btn btn-search mb-3 mt-2 text-light" style="width: 100%;">Thêm chi tiết lô nhập</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <?php Session::put('LN_MA',null); ?>
@endsection
        