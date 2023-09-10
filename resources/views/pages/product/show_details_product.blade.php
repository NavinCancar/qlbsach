@extends('all-product')
@section('content')
<!--HERO--><!--OK-->
<article style="height: 60px; background-color: var(--light-blue);"></article>
    <section class="section ">
      <div class="container">
        <!--PRODUCT-->
        @foreach($product_detail as $key => $value)
            <div class="row mt-4">
            <div class="col-lg-5 col-md-12 col-12 pb-5">
                <img class="img-fluid w-100 pb-1" id="MainImg" src="../public/frontend/images/sach/{{$value->SACH_DUONGDANANHBIA}}" alt="">
            </div>
            <div class="col-lg-7 col-md-12 col-12">
                <h2 class="h2 section-title has-underline">
                {{$value->SACH_TEN}}
                <span class="dis-block has-before"></span>
                </h2>
                <p class="product-detail-inf text-center" style="padding-bottom: 0px; margin-bottom: 0px;">
                    <span class="section-subtitle">{{number_format($value->SACH_GIA)}} VNĐ</span>
                </p>
                <div class="star text-center">
                    <?php
                        // Create connection
                        $conn = new mysqli('localhost', 'root', '', 'qlbsach');
                        // Check connection
                        if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                        }
                        $point = "select ROUND(AVG(DG_DIEM)) dg, COUNT('DG_MA') sl from Danh_gia group by SACH_MA having SACH_MA ='".$value->SACH_MA."'";
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
                    ?>
                </div>
                <p class="product-detail-inf"><span class="product-detail-title">Tác giả: </span>
                &emsp;<span>
                @foreach($author_product as $key => $au)
                    {{$au->TG_BUTDANH}} |
                @endforeach
                </span>
                </p>
                
                <p class="product-detail-inf"><span class="product-detail-title">Thể loại: </span>
                &emsp;<span>
                @foreach($category_product as $key => $cate)
                {{$cate->TLS_TEN}} |
                @endforeach
                </span>
                </p>

                <?php
                    $ton = Session::get('ton');
                ?>

                <form action="{{URL::to('/save-cart')}}" method="POST">
                {{ csrf_field() }}
                    <p class="product-detail-inf"><span class="product-detail-title">Số lượng: </span>
                        <input name="qty" type="number" min="1" max="<?php echo $ton; ?>" value="1"> |
                        &emsp;<span class="product-detail-title">Số lượng tồn: </span>
                            <?php
                                echo $ton;
                                Session::put('ton',null);
                            ?> |
                        &emsp;<span class="product-detail-title">Đã bán: </span>
                        <?php
                            $ban = Session::get('ban');
                            echo $ban;
                            Session::put('ban',null);
                        ?> |
                    </p>
                    <input name="productid_hidden" type="hidden"  value="{{$value->SACH_MA}}" />
                    <button type="submit" class="btn btn-primary product-detail-btn">THÊM GIỎ HÀNG</button>
                </form>
                <?php
                    $message = Session::get('message');
                    if($message){
                        echo '<span class="text-warning">'.$message.'</span>';
                        Session::put('message',null);
                    }
                ?>
                </p>
                <br>
                <h2 class="has-underline"><span class="dis-block has-before"></span></h2>
            </div>

            <p class="product-detail-inf" style="text-align: justify;"><span class="product-detail-title">Nội dung:
                </span>{{$value->SACH_MOTA}}
            </p>
            <div class="row">
                <div class="col-lg-3 col-md-6">
                <p class="product-detail-inf"><span class="product-detail-title">Số trang: </span>{{$value->SACH_SOTRANG}}</p>
                </div>
                <div class="col-lg-3 col-md-6">
                <p class="product-detail-inf"><span class="product-detail-title">Ngôn ngữ: </span>{{$value->SACH_NGONNGU}}</p>
                </div>
                <div class="col-lg-3 col-md-6">
                <p class="product-detail-inf"><span class="product-detail-title">Nhà xuất bản: </span>{{$value->NXB_TEN}}</p>
                </div>
                <div class="col-lg-3 col-md-6">
                <p class="product-detail-inf"><span class="product-detail-title">ISBN: </span>{{$value->SACH_ISBN}}</p>
                </div>
            </div>
            </div>
        @endforeach
    </section>
    <section class="section ">
      <div class="container">
        <div class="row">
          <h2 class="h2 section-title has-underline">
            Đánh giá
            <span class="dis-block has-before"></span>
          </h2>
          <!--ĐÁNH GIÁ-->
            <?php
                $KH_MA = Session::get('kh');
            ?>

          <section class="content-item" id="comments">
            <div class="container p-5">
                @foreach($binh_luan as $key => $bl)
                    @if($bl->KH_MA==$KH_MA)
                        <form  role="form"  action="{{URL::to('/danh-gia/'.$bl->SACH_MA)}}" method="POST" >
                            {{ csrf_field() }}
                            <fieldset>
                                <div class="form-group row">
                                    <textarea class="form-control" id="message" name="DG_NOIDUNG" placeholder="Nhập bình luận.."
                                    required=""></textarea>
                                    <fieldset class="star-right">
                                    <input type="radio" id="star5" name="DG_DIEM" value="5">
                                    <label for="star5"></label>
                                    <input type="radio" id="star4" name="DG_DIEM" value="4">
                                    <label for="star4"></label>
                                    <input type="radio" id="star3" name="DG_DIEM" value="3">
                                    <label for="star3"></label>
                                    <input type="radio" id="star2" name="DG_DIEM" value="2">
                                    <label for="star2"></label>
                                    <input type="radio" id="star1" name="DG_DIEM" value="1" required>
                                    <label for="star1"></label>
                                    </fieldset>
                                    <button type="submit" class="btn btn-primary pull-left">Đăng bình luận mới</button>
                                </div>
                            </fieldset>
                        </form>
                    @endif
                @endforeach
                
                <?php
                    $countdg = Session::get('countdg');
                    if($countdg){
                        echo '<h4> Có '.$countdg.' bình luận</h4>';
                        Session::put('countdg',null);
                    }
                ?>

              <!-- COMMENT - START -->
                @foreach($danh_gia as $key => $dg)
                    <div class="media">
                        <a class="pull-left" href="#"><img class="media-object rounded-circle"
                            src="../public/frontend/images/khachhang/{{$dg->KH_DUONGDANANHDAIDIEN}}" alt=""></a>
                        <div class="media-body">
                        <h4 class="media-heading"><b>{{$dg->KH_HOTEN}}</b><span class="list-unstyled list-inline media-detail pull-right">
                            {{date('H:i:s d/m/Y', strtotime($dg->DG_THOIGIAN))}}</span></h4>
                        <p>{{$dg->DG_NOIDUNG}}</p>
                        <ul class="list-unstyled list-inline media-detail pull-right">
                            <div class="star">
                                <?php
                                    // Create connection
                                    $conn = new mysqli('localhost', 'root', '', 'qlbsach');
                                    // Check connection
                                    if ($conn->connect_error) {
                                    die("Connection failed: " . $conn->connect_error);
                                    }
                                    $point = "select DG_DIEM dg from Danh_gia where DG_MA ='".$dg->DG_MA."'";
                                    $result = $conn->query($point);
                                    $dg=0;
                                    while ($row = $result->fetch_assoc()) {
                                        $dg= $row['dg']."<br>";
                                    }
                                    $x = 1;
                                    for ($x = 1; $x <= $dg; $x++) {
                                    echo '<i class="fas fa-star" ></i>';
                                    }
                                ?>
                            </div>
                        </ul>
                        </div>
                    </div>
                @endforeach
              <!-- COMMENT - END -->
            </div>
          </section>
        </div>
      </div>
    </section>
    <section class="section ">
      <div class="container">
        <div class="row">
          <h2 class="h2 section-title has-underline">
            Sách liên quan
            <span class="dis-block has-before"></span>
          </h2>
          <!--LIÊN QUAN-->
          @foreach($product_relate as $key => $relate)
            <div class="col-sm-3 text-center top-product-card">
                <img src="../public/frontend/images/sach/{{$relate->SACH_DUONGDANANHBIA}}" width='85%'>
                <div class="rate pt-2">
                    <div class="star">
                        <?php
                            // Create connection
                            $conn = new mysqli('localhost', 'root', '', 'qlbsach');
                            // Check connection
                            if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                            }
                            $point = "select ROUND(AVG(DG_DIEM)) dg, COUNT('DG_MA') sl from Danh_gia group by SACH_MA having SACH_MA ='".$relate->SACH_MA."'";
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

                <h3 class="h4">{{$relate->SACH_TEN}}</h3>
                <h4 class="h5">{{number_format($relate->SACH_GIA)}} VNĐ</h4>
                <a href="{{ URL::to('/chi-tiet-san-pham/'. $relate->SACH_MA) }}"><button class="btn btn-cricle">XEM</button></a>
            </div>
          @endforeach
        </div>
      </div>
    </section>
@endsection