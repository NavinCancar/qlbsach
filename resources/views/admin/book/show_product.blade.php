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
                                <form role="form"  method="post">
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
                                                <input type="file" disabled name="SACH_DUONGDANANHBIA" class="form-control"  id="file-input" >
                                            </label>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Tên sách</label>
                                        <input type="text" name="SACH_TEN" disabled value="{{$edit_value->SACH_TEN}}" class="form-control" id="exampleInputEmail1" required="">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Giá sách</label>
                                        <input type="number" min="0" name="SACH_GIA" disabled value="{{$edit_value->SACH_GIA}}" class="form-control" id="exampleInputEmail1" required="">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">ISBN</label>
                                        <input type="text" name="SACH_ISBN" disabled value="{{$edit_value->SACH_ISBN}}" class="form-control" id="exampleInputEmail1" required="">
                                    </div>
                                    <div class="form-group"> 
                                        <label for="exampleInputEmail1">Tác giả</label>
                                        <input type="text" name="" disabled value="<?php
                                            $tg = [];

                                            foreach ($cttg as $key => $ctt) {
                                                $tg[] =$ctt->TG_BUTDANH;
                                            }
                                            
                                            $nganCach = implode(", ", $tg);
                                            
                                            echo $nganCach;                                        
                                        ?>" class="form-control" id="exampleInputEmail1" required="">
                                    </div>
                                    <div class="form-group"> 
                                        <label for="exampleInputEmail1">Thể loại sách</label>
                                        <input type="text" name="" disabled value="<?php
                                            $tls = [];

                                            foreach ($cttls as $key => $ctl) {
                                                $tls[] =$ctl->TLS_TEN;
                                            }
                                            
                                            $nganCach = implode(", ", $tls);
                                            
                                            echo $nganCach;                                        
                                        ?>" class="form-control" id="exampleInputEmail1" required="">
                                    </div>
                                    <div class="form-group"> 
                                        <label for="exampleInputEmail1">Nhà xuất bản</label>
                                        <input type="text" name="" disabled value="{{$edit_value->NXB_TEN}}" class="form-control" id="exampleInputEmail1" required="">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Số trang</label>
                                        <input type="number" min="0" disabled value="{{$edit_value->SACH_SOTRANG}}" name="SACH_SOTRANG" class="form-control" id="exampleInputEmail1" required="">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Ngôn ngữ</label>
                                        <input type="text" name="SACH_NGONNGU" disabled value="{{$edit_value->SACH_NGONNGU}}" class="form-control" id="exampleInputEmail1" required="">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Mô tả sách</label>
                                        <textarea name="SACH_MOTA" disabled id="exampleInputEmail1" cols="30" rows="10" class="form-control" required="">{{$edit_value->SACH_MOTA}}</textarea>
                                    </div>
                                
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
            