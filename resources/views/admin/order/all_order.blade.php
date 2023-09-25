@extends('admin-layout')
@section('admin-content')
                  <div class="row my-2 secondary-bg shadow-sm">
                    <h2 class="fs-2 mb-3 p-2 primary-bg text-center primary-text primary-font">Tất cả đơn đặt đặt hàng</h2>
                    <!--Header-->
                    <div class="row pb-3 pb-1">
                      <div class="col-sm-6">
                          <p><?php
                            $message = Session::get('message');
                            if($message){
                                echo '<span class="text-warning">'.$message.'</span></br>';
                                Session::put('message',null);
                            }
                          ?></p>
                      </div>
                      <div class="col-sm-3">
                        <div class="dropdown">
                            <button type="button" style="width: 100%;" class="btn btn-blue btn-block dropdown-toggle" data-bs-toggle="dropdown">
                                XEM THEO TRẠNG THÁI
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item text-center" href="{{ URL::to('/danh-muc-trang-thai/tat-ca')}}">- - Tất cả trạng thái - -</a></li>
                                @foreach($all_status as $key => $status)
                                <li><a class="dropdown-item text-center" href="{{ URL::to('/danh-muc-trang-thai/'. $status->TT_MA) }}">{{ $status->TT_TEN }}</a></li>
                                @endforeach
                            </ul>
                        </div>            
                      </div>
                      <div class="col-sm-3">
                        <div class="input-group d-flex">
                            <form class="d-flex" action="{{ URL::to('/search-all-order') }}" method="POST">
                            {{ csrf_field() }}
                            <input type="number" min="1" class="input-sm form-control" name="keywords_submit" style="width: auto; float:none" placeholder="Nhập mã đơn cần tìm...">
                            <button type="submit" class="btn btn-sm btn-blue" style="margin-left: 3px;"><i class="fa fa-search icon-white"></i></a></button>
                          </form>
                        </div>
                      </div>
                    </div>
                    <!--Content-->
                    <div class="table-responsive">
                        <table class="table bg-white rounded shadow-sm table-hover">
                            <thead>
                                <tr>
                                <th>Mã</th>
                                <th>Ngày đặt</th>
                                <th>Sách</th>
                                <th>Số lượng</th>
                                <th>Tổng tiền</th>
                                <th>Trạng thái</th>
                                  <th style="width:60px;"></th>
                                </tr>
                            </thead>
                            <tbody>
                              @foreach($all_DDH as $key => $all_don)
                                @if ($all_don->TT_TEN == "Đã đặt hàng nhưng chưa xử lý") <tr style="background-color:#FCDAD5" >
                                @elseif ($all_don->TT_TEN == "Đã nhận hàng") <tr style="background-color:#C9E4D6" >
                                @else <tr>
                                @endif
                                      <td>{{$all_don->DDH_MA}}</td>
                                      <td>{{date('d/m/Y', strtotime($all_don->DDH_NGAYDAT))}}</td>
                                      <td>
                                          @foreach($group_DDH as $key => $nhom_DDH)
                                              @if($nhom_DDH->DDH_MA==$all_don->DDH_MA)
                                                  <p style='white-space: nowrap; overflow: hidden;text-overflow: ellipsis;'>{{$nhom_DDH->SACH_TEN}}</p>
                                              @endif
                                          @endforeach
                                      </td>
                                      <td>
                                          @foreach($group_DDH as $key => $nhom_DDH)
                                              @if($nhom_DDH->DDH_MA==$all_don->DDH_MA)
                                                  <p style='white-space: nowrap; overflow: hidden;text-overflow: ellipsis;'>{{$nhom_DDH->CTDDH_SOLUONG}}</p>
                                              @endif
                                          @endforeach
                                      </td>
                                      <td>{{number_format($all_don->DDH_TONGTIEN)}} VNĐ</td>
                                      <td>{{$all_don->TT_TEN}}</td>
                                      <td>
                                        <a href="{{URL::to('/show-detail/'.$all_don->DDH_MA)}}" class="active styling-edit" ui-toggle-class=""><i class="fa fa-info-circle text-primary text-active"></i></a>
                                        <a href="{{URL::to('/update-status-order/'.$all_don->DDH_MA)}}" class="active styling-edit" ui-toggle-class=""><i class="fas fa-chevron-circle-up  text-success text-active"></i></a>
                                      </td>
                                  </tr>
                                  @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!--Footer-->
                    <div>
                      <small class="text-muted inline m-t-sm m-b-sm">
                        {{ "Hiển thị ". $all_DDH->firstItem() ."-". $all_DDH->lastItem() ." trong tổng số ". $all_DDH->total() ." dòng dữ liệu" }}
                      </small>
                    </div>
                    <!--icon thu tu-->
                    <nav aria-label="Page navigation">
                        <ul class="pagination pagination-sm m-t-none m-b-none ">
                            {{-- Previous Page Link --}}
                            @if ($all_DDH->onFirstPage())
                                <li class="page-item disabled"><a class="page-link" href="#"><i class="fas fa-angle-left"></i></a></li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $all_DDH->previousPageUrl() }}"><i class="fas fa-angle-left"></i></a>
                                </li>
                            @endif
                            {{-- Pagination Elements --}}
                            @for ($key=0; $key+1<=$all_DDH->lastPage(); $key++)
                                    @if ($all_DDH->currentPage() === $key + 1)
                                        <li class="page-item active">
                                            <a class="page-link" href="{{ $all_DDH->url($key + 1) }}">{{ $key + 1 }}</a>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $all_DDH->url($key + 1) }}">{{ $key + 1 }}</a>
                                        </li>
                                    @endif
                            @endfor
                        
                            {{-- Next Page Link --}}
                            @if ($all_DDH->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link" href="{{ $all_DDH->nextPageUrl() }}"><i class="fas fa-angle-right"></i></a>
                                </li>
                            @else
                                <li class="page-item disabled"><a class="page-link" href="#"><i class="fas fa-angle-right"></i></a></li>
                            @endif
                        </ul>
                    </nav>
                </div>
@endsection
