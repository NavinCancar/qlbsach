@extends('admin-layout')
@section('admin-content')
                  <div class="row my-2 secondary-bg shadow-sm">
                    <h2 class="fs-2 mb-3 p-2 primary-bg text-center primary-text primary-font">Liệt kê chi tiết lô xuất
                      <?php
                          $LX_MA = Session::get('LX_MA');
                          if($LX_MA){ echo $LX_MA;}
                        ?>
                    </h2>
                    <!--Header-->
                    <div class="row pb-2">
                        <div class="col-sm-9">
                            <p><?php
                              $message = Session::get('message');
                              if($message){
                                  echo '<span class="text-warning">'.$message.'</span></br>';
                                  Session::put('message',null);
                              }
                            ?></p>
                        </div>
                        <div class="col-sm-3">
                        <a style="width: 100%;" class="btn btn-blue btn-block" href="{{ URL::to('/add-chitiet-loxuat/'.$LX_MA) }}">Thêm chi tiết lô xuất</a>
                          <?php Session::put('LX_MA',null); ?>
                        </div>
                    </div>
                    <!--Content-->
                    <div class="table-responsive">
                        <table class="table bg-white rounded shadow-sm table-hover">
                            <thead>
                                <tr>
                                  <th>Tên sách xuất</th>
                                  <th>Số lượng</th>
                                  <th>Đơn giá</th>
                                  <th style="width:60px;"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($all_chitiet_loxuat as $key => $pro)
                                <tr>
                                  <td>{{$pro->SACH_TEN}}</td>
                                  <td>{{$pro->CTLX_SOLUONG}}</td>  
                                  <td>{{number_format($pro->CTLX_GIA)}} VNĐ</td>
                                  <td>
                                    <a href="{{URL::to('/edit-chitiet-loxuat/lo='.$pro->LX_MA.'&sach='.$pro->SACH_MA)}}" class="active styling-edit" ui-toggle-class=""><i class="fa fa-pen text-success text-active"></i></a>
                                    <a onclick="return confirm('Bạn có chắc chắn muốn xóa mục này không?')" href="{{URL::to('/delete-chitiet-loxuat/lo='.$pro->LX_MA.'&sach='.$pro->SACH_MA)}}" class="active styling-edit" ui-toggle-class=""><i class="fa fa-times text-danger text"></i></a>
                                  </td>
                                </tr>
                              @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
@endsection