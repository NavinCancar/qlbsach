@extends('admin-layout')
@section('admin-content')
                  <div class="row my-2 secondary-bg shadow-sm">
                    <h2 class="fs-2 mb-3 p-2 primary-bg text-center primary-text primary-font">Danh sách sách</h2>
                    <!--Header-->
                    <div class="row pb-3 pb-1">
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
                        <div class="input-group d-flex">
                            <form class="d-flex" action="{{ URL::to('/search-all-product') }}" method="POST">
                            {{ csrf_field() }}
                            <input type="text" class="input-sm form-control" name="keywords_submit" style="width: auto; float:none" placeholder="Nhập tên sách cần tìm...">
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
                                  <th class="text-center" style="width:80px">Bìa</th>
                                  <th>Tên sách</th>
                                  <th style="width:150px;">Tác giả</th>
                                  <th style="width:150px;">Thể loại</th>
                                  <th style="width:150px;">Nhà xuất bản</th>
                                  <th style="width:75px;">Tồn</th>
                                  <th style="width:30px;"></th>
                                </tr>
                            </thead>
                            <tbody>
                              @foreach($all_product as $key => $cate_pro)
                                <tr>
                                  <td>{{$cate_pro->SACH_MA}}</td>
                                  <td><img src="public/frontend/images/sach/{{$cate_pro->SACH_DUONGDANANHBIA}}" width="80px"></td>
                                  <td>{{$cate_pro->SACH_TEN}}</td>
                                  <td>
                                    <?php
                                        $tacGias = [];
                                        foreach ($tg as $key => $t) {
                                            if ($t->SACH_MA == $cate_pro->SACH_MA) {
                                                $tacGias[] = $t->TG_BUTDANH;
                                            }
                                        }
                                        $nganCach = implode(", ", $tacGias);
                                        echo $nganCach;                                        
                                    ?>
                                  </td>
                                  <td>
                                    <?php
                                        $tlss = [];
                                        foreach ($tls as $key => $l) {
                                            if ($l->SACH_MA==$cate_pro->SACH_MA) {
                                                $tlss[] =$l->TLS_TEN;
                                            }
                                        }
                                        $nganCach = implode(", ", $tlss);
                                        echo $nganCach;                                        
                                    ?>
                                    
                                  </td>
                                  <td>{{$cate_pro->NXB_TEN}}</td>
                                  <td><i>
                                    <?php
                                        //Check số lượng tồn
                                        $ddh = DB::table('chi_tiet_don_dat_hang')
                                        ->join('don_dat_hang','chi_tiet_don_dat_hang.DDH_MA','=','don_dat_hang.DDH_MA')
                                        ->where('TT_MA', '!=', 5)
                                        ->where('SACH_MA', $cate_pro->SACH_MA)->sum('CTDDH_SOLUONG');

                                        $nhap = DB::table('chi_tiet_lo_nhap')
                                            ->where('SACH_MA', $cate_pro->SACH_MA)->sum('CTLN_SOLUONG');
                                        $xuat = DB::table('chi_tiet_lo_xuat')
                                            ->where('SACH_MA', $cate_pro->SACH_MA)->sum('CTLX_SOLUONG');

                                        echo ($nhap - $xuat - $ddh);
                                    ?>
                                  </i></td>
                                  <td>
                                    <a href="{{URL::to('/show-product/'.$cate_pro -> SACH_MA)}}" class="active styling-edit" ui-toggle-class=""><i class="fa fa-info-circle text-primary text-active"></i></a>
                                    <a href="{{URL::to('/edit-product/'.$cate_pro -> SACH_MA)}}" class="active styling-edit" ui-toggle-class=""><i class="fa fa-pen text-success text-active"></i></a>
                                    <a onclick="return confirm('Bạn có chắc chắn muốn xóa mục này không?')" href="{{URL::to('/delete-product/'.$cate_pro -> SACH_MA)}}" class="active styling-edit" ui-toggle-class=""><i class="fa fa-times text-danger text"></i></a>
                                  </td>
                                </tr>
                              @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!--Footer-->
                    <div>
                      <small class="text-muted inline m-t-sm m-b-sm">
                        {{ "Hiển thị ". $all_product->firstItem() ."-". $all_product->lastItem() ." trong tổng số ". $all_product->total() ." dòng dữ liệu" }}
                      </small>
                    </div>
                    <!--icon thu tu-->
                    <nav aria-label="Page navigation">
                        <ul class="pagination pagination-sm m-t-none m-b-none ">
                            {{-- Previous Page Link --}}
                            @if ($all_product->onFirstPage())
                                <li class="page-item disabled"><a class="page-link" href="#"><i class="fas fa-angle-left"></i></a></li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $all_product->previousPageUrl() }}"><i class="fas fa-angle-left"></i></a>
                                </li>
                            @endif
                            {{-- Pagination Elements --}}
                            @for ($key=0; $key+1<=$all_product->lastPage(); $key++)
                                    @if ($all_product->currentPage() === $key + 1)
                                        <li class="page-item active">
                                            <a class="page-link" href="{{ $all_product->url($key + 1) }}">{{ $key + 1 }}</a>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $all_product->url($key + 1) }}">{{ $key + 1 }}</a>
                                        </li>
                                    @endif
                            @endfor
                        
                            {{-- Next Page Link --}}
                            @if ($all_product->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link" href="{{ $all_product->nextPageUrl() }}"><i class="fas fa-angle-right"></i></a>
                                </li>
                            @else
                                <li class="page-item disabled"><a class="page-link" href="#"><i class="fas fa-angle-right"></i></a></li>
                            @endif
                        </ul>
                    </nav>
                </div>
@endsection
            