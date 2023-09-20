@extends('admin-layout')
@section('admin-content')
                  <div class="row my-2 secondary-bg shadow-sm">
                    <h2 class="fs-2 mb-3 p-2 primary-bg text-center primary-text primary-font">Danh sách khách hàng</h2>
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
                                  <th>Mã </th>
                                  <th>Tên khách hàng </th>
                                  <th>Số điện thoại </th>
                                  <th>Ngày sinh </th>
                                  <th>Giới tính </th>
                                  <th>Email </th>
                                </tr>
                            </thead>
                            <tbody>
                              @foreach($all_khach_hang as $key => $cate_pro)
                                <tr>
                                  <td>{{$cate_pro->KH_MA}}</td>
                                  <td>{{$cate_pro->KH_HOTEN}}</td>
                                  <td>{{$cate_pro->KH_SODIENTHOAI}}</td>
                                  <td>{{$cate_pro->KH_NGAYSINH}}</td>
                                  <td>{{$cate_pro->KH_GIOITINH}}</td>
                                  <td>{{$cate_pro->KH_EMAIL}}</td>
                                
                                </tr>
                              @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!--Footer-->
                    <div>
                      <small class="text-muted inline m-t-sm m-b-sm">
                        {{ "Hiển thị ". $all_khach_hang->firstItem() ."-". $all_khach_hang->lastItem() ." trong tổng số ". $all_khach_hang->total() ." dòng dữ liệu" }}
                      </small>
                    </div>
                    <!--icon thu tu-->
                    <nav aria-label="Page navigation">
                        <ul class="pagination pagination-sm m-t-none m-b-none ">
                            {{-- Previous Page Link --}}
                            @if ($all_khach_hang->onFirstPage())
                                <li class="page-item disabled"><a class="page-link" href="#"><i class="fas fa-angle-left"></i></a></li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $all_khach_hang->previousPageUrl() }}"><i class="fas fa-angle-left"></i></a>
                                </li>
                            @endif
                            {{-- Pagination Elements --}}
                            @for ($key=0; $key+1<=$all_khach_hang->lastPage(); $key++)
                                    @if ($all_khach_hang->currentPage() === $key + 1)
                                        <li class="page-item active">
                                            <a class="page-link" href="{{ $all_khach_hang->url($key + 1) }}">{{ $key + 1 }}</a>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $all_khach_hang->url($key + 1) }}">{{ $key + 1 }}</a>
                                        </li>
                                    @endif
                            @endfor
                        
                            {{-- Next Page Link --}}
                            @if ($all_khach_hang->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link" href="{{ $all_khach_hang->nextPageUrl() }}"><i class="fas fa-angle-right"></i></a>
                                </li>
                            @else
                                <li class="page-item disabled"><a class="page-link" href="#"><i class="fas fa-angle-right"></i></a></li>
                            @endif
                        </ul>
                    </nav>
                </div>
@endsection
            