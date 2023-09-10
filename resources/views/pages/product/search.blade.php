@extends('welcome')
@section('content')
<!--HERO--><!--OK-->
<article style="height: 60px; background-color: var(--light-blue);"></article>
    <section class="section ">
      <div class="container">

          <p class="section-subtitle">Cụm từ "<?php
            $keyword = Session::get('keyword');
            if($keyword){
                echo $keyword;
                Session::put('keyword',null);
            }
          ?>" có</p>
          <h2 class="h2 section-title has-underline">
            Kết quả tìm kiếm
            <span class="dis-block has-before"></span>
          </h2>
          <!--PRODUCT-->
          <div>
            <div class="wrapper row">
                @foreach($search_product as $key => $product)
                    <div class="col-sm-3 text-center top-product-card">
                        <img src="./public/frontend/images/sach/{{$product->SACH_DUONGDANANHBIA}}" width='85%'>
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

      </div>
    </section>
@endsection
