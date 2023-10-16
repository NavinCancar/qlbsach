@extends('admin-layout')
@section('admin-content')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.1.1/chart.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.1.1/helpers.esm.min.js"></script>
<style>
.panel-sub-heading {
    position: relative;
    height: 40px;
    line-height: 40px;
    width: 30%;
    letter-spacing: 0.2px;
    color: #000;
    font-size: 18px;
    font-weight: 400;
    padding: 0 16px;
    background:#ddede0;
    border-top-right-radius: 2px;
    border-top-left-radius: 2px; 
    text-transform: uppercase;
    text-align: center;
}

.anh{
    width:80%;
    margin: 0 10% 5%;
}
.khung{
    height: 25em;
    text-decoration: none;
}
</style>
            <div class="container-fluid px-4">
                <div class="p-3 mb-4 bg-white shadow-sm text-center rounded">
                    <?php
                        $TGBDau = Session::get('TGBDau');
                        $TGKThuc= Session::get('TGKThuc');
                    ?>
                    <h2 class="fs-2 m-0 primary-text primary-font">Bảng thống kê ( <?php echo (date('d/m/Y', strtotime($TGBDau)). ' - '.date('d/m/Y', strtotime($TGKThuc))) ?> )</h2>
                    <hr>
                    <div class="panel-body">
                        <form role="form" action="{{URL::to('/thong-ke-thoi-gian')}}" method="post">
                            {{csrf_field() }}
                            <div class="form-group row time">
                                <div class="col-lg-3 col-md-4 col-sm-12"><b>Thống kê theo thời gian:</b></div>
                                <div class="col-lg-3 col-md-4 col-sm-6">Từ: &nbsp;&nbsp;&nbsp;&nbsp; <input type="date" name="TGBDau"
                                        placeholder="Thời gian bắt đầu" required=""></div>
                                <div class="col-lg-3 col-md-4 col-sm-6">Đến: &nbsp;&nbsp; <input type="date" name="TGKThuc"
                                        placeholder="Thời gian kết thúc" required=""></div>
                                <div class="col-lg-3"><button type="submit" class="btn btn-search" style="width: 100%;">Thông kê</button></div>
                            </div>
                        </form>
                        <?php
                            $message = Session::get('message');
                            if($message){
                                echo '<span class="text-alert">'.$message.'</span></br>';
                                Session::put('message',null);
                            }
                        ?>
                    </div>
                </div>
                <div class="row my-2 secondary-bg shadow-sm">
                    <h3 class="fs-2 mb-3 p-2 primary-bg primary-text primary-font">Thống kê doanh thu</h3>
                    <!--Content-->
                    <div class="col">
                        <div class="panel-body bg-white rounded shadow-sm center mb-3 pt-2">
                            <canvas id="chartId" aria-label="chart" heigth="350" width="880"></canvas>
                            <?php
                                $connect = mysqli_connect("localhost", "root", "", "qlbsach");
                                $query = "SELECT * FROM DON_DAT_HANG WHERE DDH_NGAYDAT BETWEEN '" . $TGBDau . " 00:00:00' AND '" .  $TGKThuc . " 23:59:59' AND TT_MA != 5 ORDER BY DDH_NGAYDAT";
                                $result = mysqli_query($connect, $query);
                                $labels = array();
                                $data = array();
                                while ($row = mysqli_fetch_array($result)) {
                                $labels[] = $row["DDH_NGAYDAT"];
                                $data[] = $row["DDH_TONGTIEN"];
                                }
                            ?>
                            <script>
                                var ctx = document.getElementById("chartId").getContext("2d");
                                var myChart = new Chart(ctx, {
                                    //type: 'line',
                                    type: 'bar',
                                    data: {
                                        labels: <?php echo json_encode($labels); ?>,
                                        datasets: [{
                                        label: 'Doanh thu',
                                        data: <?php echo json_encode($data); ?>,
                                        //backgroundColor: '#27a4f2',
                                        backgroundColor: ['#cfebfc',  '#bbdffb', '#90cbf9', '#64b7f6', '#41a7f5', '#1e97f3', '#1a8ae5', '#1477d2', '#1065c0', '#0747a1', '#063f90', 
                                        '#053880', '#043170', '#042a60', '#032350'],
                                        borderColor: 'black',
                                        borderWidth: 2,
                                        pointRadius: 5,
                                        }],
                                    },
                                    options: {
                                        responsive: false,
                                    },
                                });
                            </script>

                        </div>
                    </div>
                </div>
                <div class="row my-2 secondary-bg shadow-sm">
                    <h3 class="fs-2 mb-3 p-2 primary-bg primary-text primary-font">Thống kê thể loại sách</h3>
                    <!--Content-->
                    <div class="col">
                        <div class="panel-body bg-white rounded shadow-sm center mb-3 pt-2">
                        <canvas id="chartId2" aria-label="chart" height="350" width="880"></canvas>
                        <?php
                            $query2 = "SELECT t.*, SUM(ctddh_soluong) tong FROM the_loai_sach t
                            JOIN thuoc_the_loai s on s.TLS_MA = t.TLS_MA 
                            JOIN chi_tiet_don_dat_hang c on s.SACH_MA = c.SACH_MA 
                            JOIN don_dat_hang d on c.DDH_MA = d.DDH_MA
                            WHERE d.DDH_NGAYDAT BETWEEN '" . $TGBDau . " 00:00:00' AND '" .  $TGKThuc . " 23:59:59' 
                            AND d.TT_MA != 5
                            GROUP by s.TLS_MA ORDER BY tong;";
                            $result2 = mysqli_query($connect, $query2);
                            $labels2 = array();
                            $data2 = array();
                            while ($row = mysqli_fetch_array($result2)) {
                            $labels2[] = $row["TLS_TEN"];
                            $data2[] = $row["tong"];
                            }
                        ?>
                        <script>
                            var chrt = document.getElementById("chartId2").getContext("2d");
                            var chartId = new Chart(chrt, {
                                type: 'pie',
                                data: {
                                        labels: <?php echo json_encode($labels2); ?>,
                                        datasets: [{
                                        label: 'Doanh thu',
                                        data: <?php echo json_encode($data2); ?>,
                                        //backgroundColor: ['#cfebfc',  '#9fd7f9', '#6ec2f7', '#3eaef4', '#27a4f2', '#2790f2', '#0f88fa', '#1167d6', '#1c68c9', '#1c5db0', '#22589c'],
                                        backgroundColor: ['#cfebfc',  '#bbdffb', '#90cbf9', '#64b7f6', '#41a7f5', '#1e97f3', '#1a8ae5', '#1477d2', '#1065c0', '#0747a1', '#063f90', 
                                        '#053880', '#043170', '#042a60', '#032350'],
                                        borderColor: 'black',
                                        borderWidth: 2,
                                        pointRadius: 5,
                                        }],
                                    },
                                options: {
                                    responsive: false,
                                },
                            });
                        </script>
                        </div>
                    </div>
                </div>

                <div class="row my-2 secondary-bg shadow-sm">
                    <h3 class="fs-2 mb-3 p-2 primary-bg primary-text primary-font">Top 3 sách bán chạy nhất</h3>
                    <?php 
                        $hot_product = DB::table('sach')
                        ->join(DB::raw('(select `sach`.`SACH_MA`, sum(`chi_tiet_don_dat_hang`.`CTDDH_SOLUONG`) as soluongban from `sach` 
                                        inner join `chi_tiet_don_dat_hang` on `chi_tiet_don_dat_hang`.`SACH_MA` = `sach`.`SACH_MA` 
                                        inner join `don_dat_hang` on `don_dat_hang`.`DDH_MA` = `chi_tiet_don_dat_hang`.`DDH_MA` 
                                        where `don_dat_hang`.`DDH_NGAYDAT` BETWEEN "' . $TGBDau . ' 00:00:00" AND "' . $TGKThuc . ' 23:59:59" 
                                        and `don_dat_hang`.`TT_MA` != 5 group by `sach`.`SACH_MA`) j'), 
                                'j.SACH_MA', '=', 'sach.SACH_MA')
                        ->orderby('soluongban','desc')->limit(3)->get();
                    ?>
                    <!--Content-->
                    <div class="col">
                        <div class="panel-body bg-white rounded shadow-sm center mb-3 pt-2">
                            <div class="wrapper row">
                                @foreach($hot_product as $key => $product)
                                    <div class="col-sm-4 text-center top-product-card">
                                        <a href="{{ URL::to('/chi-tiet-san-pham/'. $product->SACH_MA) }}">
                                            <img src="public/frontend/images/sach/{{$product->SACH_DUONGDANANHBIA}}" width='85%'>
                                        </a>
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

                                        <h4 class="fs-5 p-2 primary-text primary-font">{{$product->SACH_TEN}}</h4>
                                        <h6>{{number_format($product->SACH_GIA)}} VNĐ</h6>
                                        <h6>Số lượng bán: {{$product->soluongban}}</h6>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>                 
        
@endsection
            