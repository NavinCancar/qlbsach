@extends('admin-layout')
@section('admin-content')
                <div class="row my-2 secondary-bg shadow-sm">
                    <h2 class="fs-2 mb-3 p-2 primary-bg text-center primary-text primary-font">Thêm chi tiết lô xuất
                        <?php
                            $LX_MA = Session::get('LX_MA');
                            if($LX_MA){echo $LX_MA;}
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
                                <form role="form" action="{{URL::to('/save-chitiet-loxuat/'.$LX_MA)}}" method="post">
                                    {{csrf_field() }}

                                    <div class="form-group"> 
                                        <label for="exampleInputEmail1">Tên sách xuất</label>
                                        <select name="SACH_MA" class="form-control input-sm m-bot15" required="">
                                            @foreach($sach as $key => $masach)
                                                <option value="{{$masach->SACH_MA}}">{{$masach->SACH_TEN}}</option> 
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Số lượng</label>
                                        <input type="text" name="CTLX_SOLUONG" class="form-control" id="exampleInputEmail1" placeholder="Số lượng" required="" pattern="[0-9]+">
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Giá</label>
                                        <input type="text" name="CTLX_GIA" class="form-control" id="exampleInputEmail1" placeholder="Giá" required="" pattern="[0-9]+">
                                    </div>
                                    <button type="submit" name="add_chitiet_loxuat" class="btn btn-search mb-3 mt-2 text-light" style="width: 100%;">Thêm chi tiết lô xuất</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <?php Session::put('LX_MA',null); ?>
@endsection
        