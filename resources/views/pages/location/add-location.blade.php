@extends('welcome')
@section('content')
<!--HERO-->
    <article style="height: 60px; background-color: var(--light-blue);">
    </article>

    <section class="section">
      <div class="container">
            <p class="section-subtitle">THÊM</p>
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
            <div class="position-center input-form">
                <form role="form" action="{{URL::to('/save-location')}}"  method="post" enctype= "multipart/form-data">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="exampleInputEmail1"><b>Họ tên người nhận:</b></label>
                        <input type="text" name="DCGH_HOTENNGUOINHAN" class="form-control" id="exampleInputEmail1" placeholder="Họ tên người nhận" required="">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1"><b>Chọn tỉnh/thành phố:</b></label>
                        <select name="TTP_MA" id="TTP_MA" class="form-control input-sm m-bot15" required="">
                            <option value="">-- Chọn tỉnh / thành phố --</option>
                            @foreach($ttp as $key => $ttp)
                                <option value="{{$ttp->TTP_MA}}">{{$ttp->TTP_TEN}}</option>
                            @endforeach 
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"><b>Ví trí cụ thể:</b></label>
                        <input type="text" name="DCGH_VITRICUTHE" class="form-control" placeholder="Ví trí cụ thể" required="">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1"><b>Ghi chú:</b></label>
                        <textarea style="resize: none"  rows="8" class="form-control" name="DCGH_GHICHU" id="ckeditor1" placeholder="Ghi chú"></textarea>
                    </div>        
                    <button type="submit"  style="width:100%;" class="btn btn-primary" name="save_location">Thêm địa chỉ giao hàng</button>
                </form>
            </div>
        </div>
    </section>
@endsection

    
    
