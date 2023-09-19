@extends('welcome')
@section('content')
<!--HERO-->
    <article style="height: 60px; background-color: var(--light-blue);">
    </article>

    <section class="section">
        <div class="container">
            <div class="row">
                <p class="section-subtitle">THÔNG TIN</p>
                <h2 class="h2 section-title has-underline">
                    Đơn đặt hàng
                    <span class="dis-block has-before"></span>
                </h2>
                <?php
                    $message = Session::get('message');
                    if($message){
                        echo '<span class="text-notice">'.$message.'</span>';
                        Session::put('message',null);
                    }
                ?>
                <div class="position-center input-form">
                    <form role="form" action="{{URL::to('/order')}}"  method="post" enctype= "multipart/form-data">
                        {{ csrf_field() }}
                            <div class="form-group">
                                <label for="exampleInputEmail1"><b>Phí vận chuyển - Họ tên người nhận - Địa chỉ giao:</b></label>
                                <select name="DCGH_MA" class="form-control input-sm m-bot15">
                                    @foreach($DCGH as $key => $DCGH)
                                        <option value="{{$DCGH->DCGH_MA}}">{{number_format($DCGH->TTP_CHIPHIGIAOHANG)}} VNĐ - {{$DCGH->DCGH_HOTENNGUOINHAN}} - {{$DCGH->DCGH_VITRICUTHE}}, {{$DCGH->TTP_TEN}}</option>
                                    @endforeach 
                                </select>
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
                                        <?php $tong =0; ?>
                                        @foreach($CTGH as $key => $cart_pro)
                                            <tr>
                                                <td><img src="../../qlbsach/public/frontend/images/sach/{{$cart_pro->SACH_DUONGDANANHBIA}}" style='width: 120px;' alt=""></td>
                                                <td>{{$cart_pro->SACH_TEN}}</td>
                                                <td><span id="donGia1">{{number_format($cart_pro->SACH_GIA)}}</span> VNĐ</td>
                                                <td>{{$cart_pro->CTGH_SOLUONG}}</td>
                                                <td><span id="tongGia1"></span> {{number_format($cart_pro->CTGH_SOLUONG*$cart_pro->SACH_GIA)}} VNĐ</td>
                                                <?php
                                                    $tong = $tong + $cart_pro->CTGH_SOLUONG*$cart_pro->SACH_GIA;
                                                ?>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1"><b>Thuế VAT (%):</b></label>
                                <input type="text" name="DDH_THUEVAT" readonly value="8" class="form-control" id="exampleInputEmail1">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1"><b>Tổng tiền (Nội thất + Thuế):</b></label>
                                <input type="text" name="" readonly value="<?php echo number_format($tong+$tong*0.08);?>" class="form-control" id="exampleInputEmail1">
                                <input name="DDH_TONGTIEN" type="hidden" value="<?php echo $tong+$tong*0.08;?>" class="form-control" id="exampleInputEmail1">
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1"><b>Hình thức thanh toán:</b></label>
                                <select name="HTTT_MA" class="form-control input-sm m-bot15">
                                    @foreach($HTTT as $key => $HTTT)
                                        <option value="{{$HTTT->HTTT_MA}}">{{$HTTT->HTTT_TEN}}</option>
                                    @endforeach 
                                </select>
                            </div>
                            <button type="submit" style="width:100%" class="btn btn-primary">Xác nhận đặt hàng</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection