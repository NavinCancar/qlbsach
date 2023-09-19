@extends('all-product')
@section('content')
<!--HERO-->
    <article style="height: 60px; background-color: var(--light-blue);">
    </article>

    <section class="section">
      <div class="container">
            <p class="section-subtitle">CẬP NHẬT</p>
            <h2 class="h2 section-title has-underline">
                Địa chỉ giao hàng
                <span class="dis-block has-before"></span>
            </h2>
            <?php
                $message = Session::get('message');
                if($message){
                    echo '<span class="text-notice">'.$message.'</span>';
                    Session::put('message',null);
                }
            ?>
            @foreach($edit_location as $key => $edit_value)
            <div class="position-center input-form">
                <form role="form" action="{{URL::to('/update-location/'.$edit_value->DCGH_MA)}}"  method="post" enctype= "multipart/form-data">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="exampleInputEmail1"><b>Họ tên người nhận:</b></label>
                        <input type="text" name="DCGH_HOTENNGUOINHAN" value="{{$edit_value->DCGH_HOTENNGUOINHAN}}" class="form-control" id="exampleInputEmail1" placeholder="Họ tên người nhận" required="">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputPassword1"><b>Chọn tỉnh/thành phố:</b></label>
                        <select name="TTP_MA" id="TTP_MA" class="form-control input-sm m-bot15 choose TTP_MA" required="">
                            <option value="">-- Chọn tỉnh / thành phố --</option>
                            @foreach($ttp as $key => $ttp)
                                @if($ttp->TTP_MA==$edit_value->TTP_MA)
                                <option selected value="{{$ttp->TTP_MA}}">{{$ttp->TTP_TEN}}</option>
                                @else
                                <option value="{{$ttp->TTP_MA}}">{{$ttp->TTP_TEN}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"><b>Ví trí cụ thể:</b></label>
                        <input type="text" name="DCGH_VITRICUTHE" value="{{$edit_value->DCGH_VITRICUTHE}}" class="form-control" placeholder="Ví trí cụ thể" required="">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1"><b>Ghi chú:</b></label>
                        <textarea style="resize: none"  rows="8" class="form-control" name="DCGH_GHICHU" id="ckeditor1" placeholder="Ghi chú">{{$edit_value->DCGH_GHICHU}}</textarea>
                    </div>                  
                    <button type="submit"  style="width:100%;" class="btn btn-primary" name="update_location">Cập nhật địa chỉ giao hàng</button>
                </form>
            </div>
            @endforeach
        </div>
    </section>
@endsection