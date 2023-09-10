@extends('welcome')
@section('content')
<!--HERO--><!--OK-->
<article>
      <section class="section hero" aria-label="home">
        <div class="container row">
          <div class="hero-content col-sm-4">
            <p class="section-subtitle">Cửa hàng sách Bling bling</p>

            <h1 class="h1 hero-title">Nơi tụ hội những cuốn sách độc đáo!</h1>

            <p class="section-text">
              Tham gia ngay với chúng tôi!
            </p>
          </div>
          <div class="hero-banner has-before col-sm-8">
            <!-- Carousel -->
            <div id="demo" class="carousel slide" data-bs-ride="carousel">

              <!-- Indicators/dots -->
              <div class="carousel-indicators">
                <button type="button" data-bs-target="#demo" data-bs-slide-to="0" class="active"></button>
                <button type="button" data-bs-target="#demo" data-bs-slide-to="1"></button>
              </div>

              <!-- The slideshow/carousel -->
              <div class="carousel-inner">
                <div class="carousel-item active">
                  <img src="{{('public/frontend/images/banner1.png')}}" class="d-block w-100">
                </div>
                <div class="carousel-item">
                  <img src="{{('public/frontend/images/banner2.png')}}" class="d-block w-100">
                </div>
              </div>

              <!-- Left and right controls/icons -->
              <button class="carousel-control-prev" type="button" data-bs-target="#demo" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
              </button>
              <button class="carousel-control-next" type="button" data-bs-target="#demo" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
              </button>
            </div>
          </div>
        </div>
      </section>
    </article>
    <section class="section">
      <div class="container">
        <p class="section-subtitle">SẢN PHẨM</p>
        <h2 class="h2 section-title has-underline">
          Hot nhất
          <span class="dis-block has-before"></span>
        </h2>
        <div class="wrapper row">
        @foreach($hot_product as $key => $hotpro)
            <div class="col-sm-3 text-center top-product-card">
                <img src="./public/frontend/images/sach/{{$hotpro->SACH_DUONGDANANHBIA}}" width='85%'>
                <div class="rate pt-2">
                    <div class="star">
                        <?php
                        // Create connection
                        $conn = new mysqli('localhost', 'root', '', 'qlbsach');
                        // Check connection
                        if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                        }
                        $point = "select ROUND(AVG(DG_DIEM)) dg, COUNT('DG_MA') sl from Danh_gia group by SACH_MA having SACH_MA ='".$hotpro->SACH_MA."'";
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

                <h3 class="h4">{{$hotpro->SACH_TEN}}</h3>
                <h4 class="h5">{{number_format($hotpro->SACH_GIA)}} VNĐ</h4>
                <a href="{{ URL::to('/chi-tiet-san-pham/'. $hotpro->SACH_MA) }}"><button class="btn btn-cricle">XEM</button></a>
            </div>
        @endforeach
        </div>
        
        <img src="{{('public/frontend/images/line.png')}}" width="100%" class="mb-5">

        <p class="section-subtitle">SẢN PHẨM</p>
        <h2 class="h2 section-title has-underline">
          Mới nhất
          <span class="dis-block has-before"></span>
        </h2>
        <div class="wrapper row">
        @foreach($new_product as $key => $newpro)
            <div class="col-sm-3 text-center top-product-card">
                <img src="./public/frontend/images/sach/{{$newpro->SACH_DUONGDANANHBIA}}" width='85%'>
                <div class="rate pt-2">
                    <div class="star">
                        <?php
                        // Create connection
                        $conn = new mysqli('localhost', 'root', '', 'qlbsach');
                        // Check connection
                        if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                        }
                        $point = "select ROUND(AVG(DG_DIEM)) dg, COUNT('DG_MA') sl from Danh_gia group by SACH_MA having SACH_MA ='".$newpro->SACH_MA."'";
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

                <h3 class="h4">{{$newpro->SACH_TEN}}</h3>
                <h4 class="h5">{{number_format($newpro->SACH_GIA)}} VNĐ</h4>
                <a href="{{ URL::to('/chi-tiet-san-pham/'. $newpro->SACH_MA) }}"><button class="btn btn-cricle">XEM</button></a>
            </div>
        @endforeach
        </div>
    </section>
@endsection
