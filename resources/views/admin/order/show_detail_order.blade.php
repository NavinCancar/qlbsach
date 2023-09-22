@extends('admin-layout')
@section('admin-content')
                <div class="row my-2 secondary-bg shadow-sm">
                    <h2 class="fs-2 mb-3 p-2 primary-bg text-center primary-text primary-font">Chi tiết đơn đặt hàng</h2>
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
                            @foreach($all_DDH as $key => $all_DDH)
                                <form role="form" action="#"  method="post" enctype= "multipart/form-data">
                                    {{csrf_field() }}
                                    <div class="form-group">
                                        <label for="exampleInputEmail1"><b>Mã đơn đặt hàng:</b></label>
                                        <input type="text" name="DDH_MA" disabled value="{{$all_DDH->DDH_MA}}" class="form-control" id="exampleInputEmail1">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1"><b>Họ tên người đặt:</b></label>
                                        <input type="text" name="DDH_MA" disabled value="{{$all_DDH->KH_HOTEN}}" class="form-control" id="exampleInputEmail1">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1"><b>Họ tên người nhận:</b></label>
                                        <input type="text" name="DDH_MA" disabled value="{{$all_DDH->DCGH_HOTENNGUOINHAN}}" class="form-control" id="exampleInputEmail1">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1"><b>Địa chỉ giao:</b></label>
                                        <input type="text" name="DDH_MA" disabled value="{{$all_DDH->DCGH_VITRICUTHE}}, {{$all_DDH->TTP_TEN}}"
                                        class="form-control" id="exampleInputEmail1">
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputEmail1"><b>Sách đặt:</b></label>
                                        <div class="table-responsive">
                                            <table class="table b-t b-light table-responsive-md text-center primary-table">
                                                <thead>
                                                    <tr>
                                                        <th>Ảnh</th>
                                                        <th style="width:250px">Sách</th>
                                                        <th>Đơn giá</th>
                                                        <th>Số lượng</th>
                                                        <th>Tổng</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($group_DDH as $key => $cart_pro)
                                                    <tr>
                                                        <td><img src="../../qlbsach/public/frontend/images/sach/{{$cart_pro->SACH_DUONGDANANHBIA}}" style='width: 120px;' alt=""></td>
                                                        <td>{{$cart_pro->SACH_TEN}}</td>
                                                        <td><span id="donGia1">{{number_format($cart_pro->CTDDH_DONGIA)}}</span> VNĐ</td>
                                                        <td>{{$cart_pro->CTDDH_SOLUONG}}</td>
                                                        <td><span id="tongGia1"></span> {{number_format($cart_pro->CTDDH_SOLUONG*$cart_pro->CTDDH_DONGIA)}} VNĐ</td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1"><b>Ngày đặt:</b></label>
                                        <input type="date-time" name="DDH_MA" disabled value="{{date('d/m/Y H:i:s', strtotime($all_DDH->DDH_NGAYDAT))}}" class="form-control" id="exampleInputEmail1">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1"><b>Thuế VAT:</b></label>
                                        <input type="text" name="DDH_MA" disabled value="{{$all_DDH->DDH_THUEVAT}}%" class="form-control" id="exampleInputEmail1">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1"><b>Tổng tiền:</b></label>
                                        <input type="text" name="DDH_MA" disabled value="{{number_format($all_DDH->DDH_TONGTIEN)}} VNĐ" class="form-control" id="exampleInputEmail1">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1"><b>Hình thức thanh toán:</b></label>
                                        <input type="text" name="DDH_MA" disabled value="{{$all_DDH->HTTT_TEN}}" class="form-control" id="exampleInputEmail1">
                                    </div>
                                    <br>
                                </form>
                                @if($all_DDH->TT_MA!=1)
                                <a target="_blank" href="{{URL::to('/print-bill/'.$all_DDH->DDH_MA)}}"  class="btn btn-search mb-3 mt-2 text-light" style="width: 100%;">In hoá đơn</a>
                                @endif
                            @endforeach
                            </div>
                        </div>
                    </div>
                </div>
@endsection
