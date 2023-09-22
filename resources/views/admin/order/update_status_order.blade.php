@extends('admin-layout')
@section('admin-content')
                <div class="row my-2 secondary-bg shadow-sm">
                    <h2 class="fs-2 mb-3 p-2 primary-bg text-center primary-text primary-font">Cập nhật trạng thái đơn hàng</h2>
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
                                @foreach($edit_order as $key => $edit_value)
                                    <form role="form" action="{{URL::to('/update_status/ddh='.$edit_value->DDH_MA.'&tt='.$edit_value->TT_MA)}})}}" method="post">
                                        {{csrf_field() }}
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Mã đơn đặt hàng</label>
                                            <input type="text" disabled value="{{$edit_value->DDH_MA}}" name="DDH_MA" class="form-control" id="exampleInputEmail1" required="">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Tên trạng thái</label>
                                            <select name="TT_MA" class="form-control input-sm m-bot15" required="">

                                                @foreach($trangthai as $key => $tt)
                                                    
                                                    @if($tt->TT_MA==$edit_value->TT_MA)
                                                    <option selected value="{{$tt->TT_MA}}">{{$tt->TT_TEN}}</option>
                                                    @elseif($tt->TT_MA<$edit_value->TT_MA)

                                                    @else
                                                    <option value="{{$tt->TT_MA}}">{{$tt->TT_TEN}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                        <button type="submit" name="add_employee" class="btn btn-search mb-3 mt-2 text-light" style="width: 100%;">Cập nhật trạng thái đơn đặt hàng</button>
                                    </form>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
@endsection

            