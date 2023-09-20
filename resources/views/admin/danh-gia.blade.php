@extends('admin-layout')
@section('admin-content')
                  <div class="row my-2 secondary-bg shadow-sm">
                    <h2 class="fs-2 mb-3 p-2 primary-bg text-center primary-text primary-font">Danh sách đánh giá</h2>
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
                                  <th>Khách hàng </th>
                                  <th>Sách </th>
                                  <th style="width:400px">Nội dung đánh giá </th>
                                  <th>Điểm </th>
                                  <th>Thời gian </th>
                                  <th style="width:30px;"></th>
                                </tr>
                            </thead>
                            <tbody>
                              @foreach($all_danh_gia as $key => $cate_pro)
                                <tr>
                                  <td>{{$cate_pro->DG_MA}}</td>
                                  <td>{{$cate_pro->KH_HOTEN}}</td>
                                  <td>{{$cate_pro->SACH_TEN}}</td>
                                  <td>{{$cate_pro->DG_NOIDUNG}}</td>
                                  <td>{{$cate_pro->DG_DIEM}} <i class="fas fa-star" style="color: var(--gold);"></i></td>
                                  <td>{{ date('d/m/Y H:i', strtotime($cate_pro->DG_THOIGIAN)) }}</td>
                                  <td>
                                    <a onclick="return confirm('Bạn có chắc chắn muốn xóa mục này không?')" href="{{URL::to('/delete-danh-gia/'.$cate_pro -> DG_MA)}}" class="active styling-edit" ui-toggle-class=""><i class="fa fa-times text-danger text"></i></a>
                                  </td>
                                </tr>
                              @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!--Footer-->
                    <div>
                      <small class="text-muted inline m-t-sm m-b-sm">
                        {{ "Hiển thị ". $all_danh_gia->firstItem() ."-". $all_danh_gia->lastItem() ." trong tổng số ". $all_danh_gia->total() ." dòng dữ liệu" }}
                      </small>
                    </div>
                    <!--icon thu tu-->
                    <nav aria-label="Page navigation">
                        <ul class="pagination pagination-sm m-t-none m-b-none ">
                            {{-- Previous Page Link --}}
                            @if ($all_danh_gia->onFirstPage())
                                <li class="page-item disabled"><a class="page-link" href="#"><i class="fas fa-angle-left"></i></a></li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $all_danh_gia->previousPageUrl() }}"><i class="fas fa-angle-left"></i></a>
                                </li>
                            @endif
                            {{-- Pagination Elements --}}
                            @for ($key=0; $key+1<=$all_danh_gia->lastPage(); $key++)
                                    @if ($all_danh_gia->currentPage() === $key + 1)
                                        <li class="page-item active">
                                            <a class="page-link" href="{{ $all_danh_gia->url($key + 1) }}">{{ $key + 1 }}</a>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $all_danh_gia->url($key + 1) }}">{{ $key + 1 }}</a>
                                        </li>
                                    @endif
                            @endfor
                        
                            {{-- Next Page Link --}}
                            @if ($all_danh_gia->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link" href="{{ $all_danh_gia->nextPageUrl() }}"><i class="fas fa-angle-right"></i></a>
                                </li>
                            @else
                                <li class="page-item disabled"><a class="page-link" href="#"><i class="fas fa-angle-right"></i></a></li>
                            @endif
                        </ul>
                    </nav>
                </div>
@endsection
            