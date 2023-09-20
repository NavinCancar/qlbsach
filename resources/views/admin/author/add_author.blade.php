@extends('admin-layout')
@section('admin-content')
                <div class="row my-2 secondary-bg shadow-sm">
                    <h2 class="fs-2 mb-3 p-2 primary-bg text-center primary-text primary-font">Thêm tác giả</h2>
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
                                <form role="form" action="{{URL::to('/save-author')}}" method="post">
                                    {{csrf_field() }}
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Bút danh tác giả</label>
                                        <input type="text" name="TG_BUTDANH" class="form-control" id="exampleInputEmail1" required="">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Mô tả tác giả</label>
                                        <textarea name="TG_MOTA" id="exampleInputEmail1" cols="30" rows="10" class="form-control"></textarea>
                                    </div>
                                    <button type="submit" name="add_author" class="btn btn-search mb-3 mt-2 text-light" style="width: 100%;">Thêm tác giả</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
@endsection
            