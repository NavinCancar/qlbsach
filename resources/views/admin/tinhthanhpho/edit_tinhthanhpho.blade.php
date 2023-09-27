@extends('admin-layout')
@section('admin-content')
                <div class="row my-2 secondary-bg shadow-sm">
                    <h2 class="fs-2 mb-3 p-2 primary-bg text-center primary-text primary-font">Cập nhật tỉnh/thành phố</h2>
                    <?php
                        $message = Session::get('message');
                        if($message){
                            echo '<span class="text-warning">'.$message.'</span></br>';
                            Session::put('message',null);
                        }
                    ?>
                    <!--Content--> 
                    @foreach($edit_tinhthanhpho as $key => $edit_value)
                    <div class="col">
                        <div class="panel-body bg-white rounded shadow-sm center mb-3 p-3">
                            <div class="position-center">
                                <form role="form" action="{{URL::to('/update-tinhthanhpho/'.$edit_value->TTP_MA)}}" method="post">
                                    {{csrf_field() }}
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Têntỉnh/thành phố</label>
                                        <input type="text" name="TTP_TEN" value="{{$edit_value->TTP_TEN}}" class="form-control" id="exampleInputEmail1" required="">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Chi phí giao hàng</label>
                                        <input type="number" name="TTP_CHIPHIGIAOHANG" value="{{$edit_value->TTP_CHIPHIGIAOHANG}}" class="form-control" id="exampleInputEmail1" required="">
                                    </div>
                                    <button type="submit" name="update_tinhthanhpho" class="btn btn-search mb-3 mt-2 text-light" style="width: 100%;">Cập nhật tỉnh/thành phố</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
@endsection
            