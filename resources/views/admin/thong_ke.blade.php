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
                                $query = "SELECT * FROM DON_DAT_HANG WHERE DDH_NGAYDAT BETWEEN '" . $TGBDau . "' AND '" .  $TGKThuc . "' AND TT_MA != 5 ORDER BY DDH_NGAYDAT";
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
                                type: 'line',
                                data: {
                                    labels: <?php echo json_encode($labels); ?>,
                                    datasets: [{
                                    label: 'Doanh thu',
                                    data: <?php echo json_encode($data); ?>,
                                    backgroundColor: '#27a4f2',
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
                            WHERE d.DDH_NGAYDAT BETWEEN '".$TGBDau."' AND '".$TGKThuc."'
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
            </div>                 
        
@endsection
            