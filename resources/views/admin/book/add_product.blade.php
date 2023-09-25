@extends('admin-layout')
@section('admin-content')
                <div class="row my-2 secondary-bg shadow-sm">
                    <h2 class="fs-2 mb-3 p-2 primary-bg text-center primary-text primary-font">Thêm sách</h2>
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
                                <form role="form" action="{{URL::to('/save-product')}}" method="post" enctype="multipart/form-data">
                                    {{csrf_field() }}
                                    <div class="form-group text-center">
                                        <input type="hidden" name="SACH_DUONGDANANHBIA" disabled class="form-control" id="exampleInputEmail1" required="">
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
                                                <img class="square" src="public/frontend/images/sach/add-poster.png" id="img-preview" src="" alt="Image Preview">
                                                <input type="file" name="SACH_DUONGDANANHBIA" class="form-control"  id="file-input" required="">
                                            </label>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Tên sách</label>
                                        <input type="text" name="SACH_TEN" class="form-control" id="exampleInputEmail1" required="">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Giá sách</label>
                                        <input type="number" min="0" name="SACH_GIA" class="form-control" id="exampleInputEmail1" required="">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">ISBN</label>
                                        <input type="text" name="SACH_ISBN" class="form-control" id="exampleInputEmail1" required="">
                                    </div>
                                    <div class="form-group"> 
                                        <label for="exampleInputEmail1">Tác giả (Có thể chọn nhiều giá trị)</label>
                                        <select name="TG_MA[]" class="form-control input-sm m-bot15" required="" multiple>
                                            @foreach($tg as $key => $t)
                                                <option value="{{$t->TG_MA}}">{{$t->TG_BUTDANH}}</option> 
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group"> 
                                        <label for="exampleInputEmail1">Thể loại sách (Có thể chọn nhiều giá trị)</label>
                                        <select name="TLS_MA[]" class="form-control input-sm m-bot15" required="" multiple>
                                            @foreach($tls as $key => $l)
                                                <option value="{{$l->TLS_MA}}">{{$l->TLS_TEN}}</option> 
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group"> 
                                        <label for="exampleInputEmail1">Nhà xuất bản</label>
                                        <select name="NXB_MA" class="form-control input-sm m-bot15" required="">
                                            @foreach($nxb as $key => $masach)
                                                <option value="{{$masach->NXB_MA}}">{{$masach->NXB_TEN}}</option> 
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Số trang</label>
                                        <input type="number" min="0" name="SACH_SOTRANG" class="form-control" id="exampleInputEmail1" required="">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Ngôn ngữ</label>
                                        <input type="text" name="SACH_NGONNGU" class="form-control" id="exampleInputEmail1" required="">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Mô tả sách</label>
                                        <textarea name="SACH_MOTA" id="exampleInputEmail1" cols="30" rows="10" class="form-control" required=""></textarea>
                                    </div>
                                    <button type="submit" name="add_product" class="btn btn-search mb-3 mt-2 text-light" style="width: 100%;">Thêm sách</button>
                                </form>
                            </div>
                        </div>
                    </div>
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
            