@extends('admin-layout')
@section('admin-content')
                  <div class="row my-2 secondary-bg shadow-sm">
                    <h2 class="fs-2 mb-3 p-2 primary-bg text-center primary-text primary-font">Danh sách thể loại sách</h2>
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
                                  <th>Mã thể loại</th>
                                  <th>Tên thể loại</th>
                                  <th style="width:60px;"></th>
                                </tr>
                            </thead>
                            <tbody>
                              @foreach($all_category_product as $key => $cate_pro)
                                <tr>
                                  <td>{{$cate_pro->TLS_MA}}</td>
                                  <td>{{$cate_pro->TLS_TEN}}</td>
                                  <td>
                                    <a href="{{URL::to('/edit-category-product/'.$cate_pro -> TLS_MA)}}" class="active styling-edit" ui-toggle-class=""><i class="fa fa-pencil-alt text-success text-active"></i></a>
                                    <a onclick="return confirm('Bạn có chắc chắn muốn xóa mục này không?')" href="{{URL::to('/delete-category-product/'.$cate_pro -> TLS_MA)}}" class="active styling-edit" ui-toggle-class=""><i class="fa fa-times text-danger text"></i></a>
                                  </td>
                                </tr>
                              @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!--Footer-->
                    <div>
                      <small class="text-muted inline m-t-sm m-b-sm">
                        {{ "Hiển thị ". $all_category_product->firstItem() ."-". $all_category_product->lastItem() ." trong tổng số ". $all_category_product->total() ." dòng dữ liệu" }}
                      </small>
                    </div>
                    <!--icon thu tu-->
                    <nav aria-label="Page navigation">
                        <ul class="pagination pagination-sm m-t-none m-b-none ">
                            {{-- Previous Page Link --}}
                            @if ($all_category_product->onFirstPage())
                                <li class="page-item disabled"><a class="page-link" href="#"><i class="fas fa-angle-left"></i></a></li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $all_category_product->previousPageUrl() }}"><i class="fas fa-angle-left"></i></a>
                                </li>
                            @endif
                            {{-- Pagination Elements --}}
                            @for ($key=0; $key+1<=$all_category_product->lastPage(); $key++)
                                    @if ($all_category_product->currentPage() === $key + 1)
                                        <li class="page-item active">
                                            <a class="page-link" href="{{ $all_category_product->url($key + 1) }}">{{ $key + 1 }}</a>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $all_category_product->url($key + 1) }}">{{ $key + 1 }}</a>
                                        </li>
                                    @endif
                            @endfor
                        
                            {{-- Next Page Link --}}
                            @if ($all_category_product->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link" href="{{ $all_category_product->nextPageUrl() }}"><i class="fas fa-angle-right"></i></a>
                                </li>
                            @else
                                <li class="page-item disabled"><a class="page-link" href="#"><i class="fas fa-angle-right"></i></a></li>
                            @endif
                        </ul>
                    </nav>
                </div>
@endsection
            