@extends('admin-layout')
@section('admin-content')
                  <div class="row my-2 secondary-bg shadow-sm">
                    <h2 class="fs-2 mb-3 p-2 primary-bg text-center primary-text primary-font">Danh sách lô nhập</h2>
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
                    </div>
                    <!--Content-->
                    <div class="table-responsive">
                        <table class="table bg-white rounded shadow-sm table-hover">
                            <thead>
                                <tr>
                                  <th>Mã lô nhập</th>
                                  <th>Nhân viên</th>
                                  <th>Ngày nhập</th>
                                  <th>Nội dung</th>
                                  <th style="width:90px;"></th>
                                </tr>
                            </thead>
                            <tbody>
                              @foreach($all_lo_nhap as $key => $cate_pro)
                                <tr>
                                  <td>{{$cate_pro->LN_MA}}</td>
                                  <td>{{$cate_pro->NV_HOTEN}}</td>
                                  <td>{{$cate_pro->LN_NGAYNHAP}}</td>
                                  <td>{{$cate_pro->LN_NOIDUNG}}</td>
                                  <td>
                                    <a href="{{URL::to('/all-chitiet-lonhap/'.$cate_pro -> LN_MA)}}" class="active styling-edit" ui-toggle-class=""><i class="fa fa-info-circle text-primary text-active"></i></a>
                                    <a href="{{URL::to('/edit-lo-nhap/'.$cate_pro -> LN_MA)}}" class="active styling-edit" ui-toggle-class=""><i class="fa fa-pen text-success text-active"></i></a>
                                    <a onclick="return confirm('Bạn có chắc chắn muốn xóa mục này không?')" href="{{URL::to('/delete-lo-nhap/'.$cate_pro -> LN_MA)}}" class="active styling-edit" ui-toggle-class=""><i class="fa fa-times text-danger text"></i></a>
                                  </td>
                                </tr>
                              @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!--Footer-->
                    <div>
                      <small class="text-muted inline m-t-sm m-b-sm">
                        {{ "Hiển thị ". $all_lo_nhap->firstItem() ."-". $all_lo_nhap->lastItem() ." trong tổng số ". $all_lo_nhap->total() ." dòng dữ liệu" }}
                      </small>
                    </div>
                    <!--icon thu tu-->
                    <nav aria-label="Page navigation">
                        <ul class="pagination pagination-sm m-t-none m-b-none ">
                            {{-- Previous Page Link --}}
                            @if ($all_lo_nhap->onFirstPage())
                                <li class="page-item disabled"><a class="page-link" href="#"><i class="fas fa-angle-left"></i></a></li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $all_lo_nhap->previousPageUrl() }}"><i class="fas fa-angle-left"></i></a>
                                </li>
                            @endif
                            {{-- Pagination Elements --}}
                            @for ($key=0; $key+1<=$all_lo_nhap->lastPage(); $key++)
                                    @if ($all_lo_nhap->currentPage() === $key + 1)
                                        <li class="page-item active">
                                            <a class="page-link" href="{{ $all_lo_nhap->url($key + 1) }}">{{ $key + 1 }}</a>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $all_lo_nhap->url($key + 1) }}">{{ $key + 1 }}</a>
                                        </li>
                                    @endif
                            @endfor
                        
                            {{-- Next Page Link --}}
                            @if ($all_lo_nhap->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link" href="{{ $all_lo_nhap->nextPageUrl() }}"><i class="fas fa-angle-right"></i></a>
                                </li>
                            @else
                                <li class="page-item disabled"><a class="page-link" href="#"><i class="fas fa-angle-right"></i></a></li>
                            @endif
                        </ul>
                    </nav>
                </div>
@endsection
            