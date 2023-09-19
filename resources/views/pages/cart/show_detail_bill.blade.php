@extends('all-product')
@section('content')
<!--HERO-->
    <article style="height: 60px; background-color: var(--light-blue);">
    </article>

    <section class="section">
        <div class="container">
            <div class="row">
                <p class="section-subtitle">THÔNG TIN</p>
                <h2 class="h2 section-title has-underline">
                    Hoá đơn
                    <span class="dis-block has-before"></span>
                </h2>
                <?php
                    $message = Session::get('message');
                    if($message){
                        echo '<span class="text-notice">'.$message.'</span>';
                        Session::put('message',null);
                    }
                ?>
                @foreach($all_DDH as $key => $all_DDH)
                <div class="position-center input-form">
                    <form role="form" action="#">
                        <div class="form-group">
                            <label for="exampleInputEmail1"><b>Mã đơn đặt hàng:</b></label>
                            <input type="text" name="DDH_MA" disabled value="{{$all_DDH->DDH_MA}}" class="form-control" id="exampleInputEmail1">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1"><b>Ngày đặt:</b></label>
                            <input type="text" name="DDH_MA" disabled value="{{date('d/m/Y H:i:s', strtotime($all_DDH->DDH_NGAYDAT))}}" class="form-control" id="exampleInputEmail1">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1"><b>Trạng thái đơn hàng:</b></label>
                            <input type="text" name="DDH_MA" disabled value="{{$all_DDH->TT_TEN}}" class="form-control" id="exampleInputEmail1">
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
                            <label for="exampleInputEmail1"><b>Nội thất đặt:</b></label>

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
                            <label for="exampleInputEmail1"><b>Hình thức thanh toán:</b></label>
                            <input type="text" name="DDH_MA" disabled value="{{$all_DDH->HTTT_TEN}}" class="form-control" id="exampleInputEmail1">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1"><b>Thuế VAT:</b></label>
                            <input type="text" name="DDH_MA" disabled value="{{$all_DDH->DDH_THUEVAT}}%" class="form-control" id="exampleInputEmail1">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1"><b>Tổng tiền:</b></label>
                            <input type="text" name="DDH_MA" disabled value="{{number_format($all_DDH->DDH_TONGTIEN)}} VNĐ" class="form-control" id="exampleInputEmail1">
                        </div>
                        
                        @if($all_DDH->TT_MA<=3)
                            <a  style="width:100%;" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn huỷ đơn hàng này không?')" href="{{URL::to('/huy-don/'.$all_DDH->DDH_MA)}}">Huỷ đơn</a>
                        @endif
                    </form>
                </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection