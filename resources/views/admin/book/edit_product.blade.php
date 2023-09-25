@extends('admin-layout')
@section('admin-content')
                <div class="row my-2 secondary-bg shadow-sm">
                    <h2 class="fs-2 mb-3 p-2 primary-bg text-center primary-text primary-font">Cập nhật sách</h2>
                    <?php
                        $message = Session::get('message');
                        if($message){
                            echo '<span class="text-warning">'.$message.'</span></br>';
                            Session::put('message',null);
                        }
                    ?>
                    <!--Content--> 
                    @foreach($edit_product as $key => $edit_value)
                    <div class="col">
                        <div class="panel-body bg-white rounded shadow-sm center mb-3 p-3">
                            <div class="position-center">
                                <form role="form" action="{{URL::to('/update-product/'.$edit_value->SACH_MA)}}" method="post">
                                    {{csrf_field() }}
                                    
                                    <div class="form-group text-center">
                                        <input type="hidden" name="SACH_DUONGDANANHBIA" disabled value="{{$edit_value->SACH_DUONGDANANHBIA}}" class="form-control" id="exampleInputEmail1">
                                        <style>
                                            #file-input {
                                            display: none;
                                            }

                                            .square {
                                            display: flex;
                                            justify-content: center;
                                            align-items: center;
                                            height: 300px;
                                            width: 300px;
                                            border: 3px solid white;
                                            font-size: 60px;
                                            font-weight: bold;
                                            color: black;
                                            cursor: pointer;
                                            }

                                            .square:hover {
                                            background-color: #f2f2f2;
                                            }
                                        </style>
                                    
                                        <div class="container">
                                            <label for="file-input" >
                                                <img class="square" src="../public/frontend/images/sach/{{$edit_value->SACH_DUONGDANANHBIA}}" id="img-preview" src="" alt="Image Preview">
                                                <input type="file" name="SACH_DUONGDANANHBIA" class="form-control"  id="file-input" >
                                            </label>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Tên sách</label>
                                        <input type="text" name="SACH_TEN"  value="{{$edit_value->SACH_TEN}}" class="form-control" id="exampleInputEmail1" required="">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Giá sách</label>
                                        <input type="number" min="0" name="SACH_GIA"  value="{{$edit_value->SACH_GIA}}" class="form-control" id="exampleInputEmail1" required="">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">ISBN</label>
                                        <input type="text" name="SACH_ISBN"  value="{{$edit_value->SACH_ISBN}}" class="form-control" id="exampleInputEmail1" required="">
                                    </div>
                                    <div class="form-group"> 
                                        <label for="exampleInputEmail1">Tác giả (Có thể chọn nhiều giá trị)</label>
                                        <select name="TG_MA[]" class="form-control input-sm m-bot15" required="" multiple>
                                            @foreach($tg as $key => $t)
                                                <option 
                                                <?php
                                                    foreach($cttg as $key => $ctt){
                                                        if($t->TG_MA==$ctt->TG_MA) echo 'selected';
                                                    }
                                                ?>
                                                value="{{$t->TG_MA}}">{{$t->TG_BUTDANH}}</option> 
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group"> 
                                        <label for="exampleInputEmail1">Thể loại sách (Có thể chọn nhiều giá trị)</label>
                                        <select name="TLS_MA[]" class="form-control input-sm m-bot15" required="" multiple>
                                            @foreach($tls as $key => $l)
                                                <option 
                                                <?php
                                                    foreach($cttls as $key => $ctl){
                                                        if($l->TLS_MA==$ctl->TLS_MA) echo 'selected';
                                                    }
                                                ?>
                                                value="{{$l->TLS_MA}}">{{$l->TLS_TEN}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group"> 
                                        <label for="exampleInputEmail1">Nhà xuất bản</label>
                                        <select name="NXB_MA" class="form-control input-sm m-bot15" required="">
                                            @foreach($nxb as $key => $masach)
                                                @if($masach->NXB_MA==$edit_value->NXB_MA)
                                                <option selected value="{{$masach->NXB_MA}}">{{$masach->NXB_TEN}}</option>
                                                @else
                                                <option value="{{$masach->NXB_MA}}">{{$masach->NXB_TEN}}</option> 
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Số trang</label>
                                        <input type="number" min="0"  value="{{$edit_value->SACH_SOTRANG}}" name="SACH_SOTRANG" class="form-control" id="exampleInputEmail1" required="">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Ngôn ngữ</label>
                                        <input type="text" name="SACH_NGONNGU"  value="{{$edit_value->SACH_NGONNGU}}" class="form-control" id="exampleInputEmail1" required="">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Mô tả sách</label>
                                        <textarea name="SACH_MOTA" id="exampleInputEmail1" cols="30" rows="10" class="form-control" required="">{{$edit_value->SACH_MOTA}}</textarea>
                                    </div>
                                    <button type="submit" name="update_product" class="btn btn-search mb-3 mt-2 text-light" style="width: 100%;">Cập nhật sách</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
<script>
        const fileInput = document.getElementById('file-input');
        const imgPreview = document.getElementById('img-preview');

        fileInput.addEventListener('change', (event) => {
        const file = event.target.files[0];
        const reader = new FileReader();

        reader.addEventListener('load', (event) => {
            imgPreview.src = event.target.result;
        });

        reader.readAsDataURL(file);
        }); 
</script>

@endsection
            