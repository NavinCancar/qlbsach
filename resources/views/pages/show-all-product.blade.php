@extends('all-product')
@section('content')
<!--HERO--><!--OK-->
<article style="height: 60px; background-color: var(--light-blue);"></article>
    <section class="section ">
      <div class="container">
        <div class="row">
          <p class="section-subtitle">DANH MỤC SẢN PHẨM</p>
          <h2 class="h2 section-title has-underline">
            Tất cả
            <span class="dis-block has-before"></span>
          </h2>
          <!--PRODUCT-->
          <div class="col-sm-9">
            <div class="wrapper row">
                @foreach($all_product as $key => $product)
                    <div class="col-sm-3 text-center top-product-card">
                        <img src="../public/frontend/images/sach/{{$product->SACH_DUONGDANANHBIA}}" width='85%'>
                        <div class="rate pt-2">
                            <div class="star">
                                <?php
                                // Create connection
                                $conn = new mysqli('localhost', 'root', '', 'qlbsach');
                                // Check connection
                                if ($conn->connect_error) {
                                die("Connection failed: " . $conn->connect_error);
                                }
                                $point = "select ROUND(AVG(DG_DIEM)) dg, COUNT('DG_MA') sl from Danh_gia group by SACH_MA having SACH_MA ='".$product->SACH_MA."'";
                                $result = $conn->query($point);
                                $dg=0; $sl=0;
                                while ($row = $result->fetch_assoc()) {
                                    $dg= $row['dg']."<br>";
                                    $sl= $row['sl'];
                                }
                                $x = 1;
                                for ($x = 1; $x <= $dg; $x++) {
                                echo '<i class="fas fa-star"></i>';
                                } 
                                echo '<i> ('.$sl.')</i>';
                                ?>
                            </div>
                        </div>

                        <h3 class="h4">{{$product->SACH_TEN}}</h3>
                        <h4 class="h5">{{number_format($product->SACH_GIA)}} VNĐ</h4>
                        <a href="{{ URL::to('/chi-tiet-san-pham/'. $product->SACH_MA) }}"><button class="btn btn-cricle">XEM</button></a>
                    </div>
                @endforeach
            </div>
          </div>
          <!--BỘ LỌC-->
          <div class="col-sm-3">
            <ul class="list-group rounded-2 text-center">
              <li class="list-group-item disabled light-blue-background">
                <h4>Danh mục sản phẩm</h4>
              </li>
              <li class="list-group-item bg-active"><a class="category-list" href="{{ URL::to('/danh-muc-san-pham/tat-ca')}}">- - Tất cả sản phẩm - -</a></li>
              @foreach($category as $key => $cate)    
                <li class="list-group-item"><a class="category-list" href="{{ URL::to('/danh-muc-san-pham/'. $cate->TLS_MA) }}">{{ $cate->TLS_TEN }}</a></li>
              @endforeach
            </ul>
          </div>


          <!--icon thu tu-->
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center text-center pt-4">
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
      </div>
    </section>
@endsection
