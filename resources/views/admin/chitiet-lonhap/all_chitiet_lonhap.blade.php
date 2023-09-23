@extends('admin-layout')
@section('admin-content')
                  <div class="row my-2 secondary-bg shadow-sm">
                    <h2 class="fs-2 mb-3 p-2 primary-bg text-center primary-text primary-font">Liệt kê chi tiết lô nhập
                      <?php
                          $LN_MA = Session::get('LN_MA');
                          if($LN_MA){ echo $LN_MA;}
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
                        <a style="width: 100%;" class="btn btn-blue btn-block" href="{{ URL::to('/add-chitiet-lonhap/'.$LN_MA) }}">Thêm chi tiết lô nhập</a>
                          <?php Session::put('LN_MA',null); ?>
                        </div>
                    </div>
                    <!--Content-->
                    <div class="table-responsive">
                        <table class="table bg-white rounded shadow-sm table-hover">
                            <thead>
                                <tr>
                                  <th>Tên sách nhập</th>
                                  <th>Số lượng</th>
                                  <th>Đơn giá</th>
                                  <th style="width:60px;"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($all_chitiet_lonhap as $key => $pro)
                                <tr>
                                  <td>{{$pro->SACH_TEN}}</td>
                                  <td>{{$pro->CTLN_SOLUONG}}</td>  
                                  <td>{{number_format($pro->CTLN_GIA)}} VNĐ</td>
                                  <td>
                                    <a href="{{URL::to('/edit-chitiet-lonhap/lo='.$pro->LN_MA.'&sach='.$pro->SACH_MA)}}" class="active styling-edit" ui-toggle-class=""><i class="fa fa-pen text-success text-active"></i></a>
                                    <a onclick="return confirm('Bạn có chắc chắn muốn xóa mục này không?')" href="{{URL::to('/delete-chitiet-lonhap/lo='.$pro->LN_MA.'&sach='.$pro->SACH_MA)}}" class="active styling-edit" ui-toggle-class=""><i class="fa fa-times text-danger text"></i></a>
                                  </td>
                                </tr>
                              @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
@endsection