@extends('welcome')
@section('content')
<!--HERO-->
<article style="height: 60px; background-color: var(--light-blue);">
    </article>

    <section class="section">
      <div class="container">
        <div class="row">
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
          <?php
            $message = Session::get('message');
            if($message){
                echo '<span class="text-notice">'.$message.'</span>';
                Session::put('message',null);
            }
          ?>
            <form class="row pb-4" action="{{ URL::to('/search-in-order') }}" method="POST">
                {{ csrf_field() }}
                <b class="col-md-3" style="color: var(--dark-blue)">Tìm các đơn đặt hàng cũ:</b>
                <div class="d-flex col-md-9">
                    <input class="form-control me-2" type="text" name="keywords_submit" placeholder="Nhập sách cần tìm...">
                    <button class="btn btn-primary" type="submit"><i class="fa fa-search icon-white"></i></a></button>
                </div>
            </form>
          <div>
            <?php
              $count= Session::get('count_DCGH');
              if ($count) {
                  echo "Tổng số dòng dữ liệu: ".$count;
              }
            ?>
          </div>
          <div class="table-responsive">
            <table class="table b-t b-light table-responsive-md text-center primary-table">
              <thead>
                <tr>
                    <th style="width: 50px">Mã</th>
                    <th style="width: 100px">Ngày đặt</th>
                    <th>Sách</th>
                    <th style="width: 100px">Tổng tiền</th>
                    <th>Trạng thái</th>
                    <th style="width: 125px"></th>
                </tr>
              </thead>
              <tbody>
                @foreach($all_DDH as $key => $all_DDH_old)
                    <tr>
                        <td>{{$all_DDH_old->DDH_MA}}</td>
                        <td>{{ date('d/m/Y', strtotime($all_DDH_old->DDH_NGAYDAT)) }}</td>
                        <td>
                            @foreach($group_DDH as $key => $nhom_DDH)
                                @if($nhom_DDH->DDH_MA==$all_DDH_old->DDH_MA)
                                    <p style='white-space: nowrap; overflow: hidden;text-overflow: ellipsis;'>{{$nhom_DDH->SACH_TEN}}</p>
                                @endif
                            @endforeach
                        </td>
                        <td>{{number_format($all_DDH_old->DDH_TONGTIEN)}}</td>
                        <td style='white-space: nowrap; overflow: hidden;text-overflow: ellipsis;'>{{$all_DDH_old->TT_TEN}}</td>
                        <td><a href="{{URL::to('/show-detail-bill/'.$all_DDH_old->DDH_MA)}}" style="width:100%;" class="btn btn-secondary">Xem chi tiết</a></td>
                    </tr>
                @endforeach
              </tbody>
            </table>
            </div>
        </div>
    </section>
@endsection
