@extends('admin-layout')
@section('admin-content')
                <div class="row my-2 secondary-bg shadow-sm">
                    <h2 class="fs-2 mb-3 p-2 primary-bg text-center primary-text primary-font">Thêm tỉnh/thành phố</h2>
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
                            <form role="form" action="{{URL::to('/save-tinhthanhpho')}}" method="post">
                                    {{csrf_field() }}
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Tên tỉnh/thành phố</label>
                                        <input type="text" name="TTP_TEN" class="form-control" id="exampleInputEmail1" required="">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Chi phí giao hàng</label>
                                        <input type="number" min="0" name="TTP_CHIPHIGIAOHANG" class="form-control" id="exampleInputEmail1"  placeholder="Chi phí giao hàng" required="">
                                    </div>
                                    <button type="submit" name="add_tinhthanhpho" class="btn btn-search mb-3 mt-2 text-light" style="width: 100%;">Thêm tỉnh/thành phố</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
@endsection
            