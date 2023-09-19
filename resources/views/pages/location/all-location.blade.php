@extends('welcome')
@section('content')
<!--HERO-->
<article style="height: 60px; background-color: var(--light-blue);">
    </article>

    <section class="section">
      <div class="container">
        <div class="row">
          <p class="section-subtitle">THÔNG TIN</p>
          <h2 class="h2 section-title has-underline">
            Địa chỉ giao hàng
            <span class="dis-block has-before"></span>
          </h2>
          <?php
            $message = Session::get('message');
            if($message){
                echo '<span class="text-notice">'.$message.'</span>';
                Session::put('message',null);
            }
          ?>
          <!--GIỎ-->
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
                    <th>Mã</th>
                    <th>Họ tên người nhận</th>
                    <th>Ví trí cụ thể</th>
                    <th>Tỉnh/Thành phố</th>
                    <th>Ghi chú</th>
                    <th style="width:80px;"></th>
                </tr>
              </thead>
              <tbody>
                @foreach($all_DCGH as $key => $dc)
                    <tr>
                        <td>{{$dc->DCGH_MA}} </td>
                        <td>{{$dc->DCGH_HOTENNGUOINHAN}} </td>
                        <td>{{$dc->DCGH_VITRICUTHE}} </td>
                        <td>{{$dc->TTP_TEN}} </td>
                        <td>{{$dc->DCGH_GHICHU}} </td>
                        <td>
                          <a href="{{URL::to('/sua-dia-chi-giao-hang/'.$dc -> DCGH_MA)}}" class="active styling-edit" ui-toggle-class=""><i class="fa fa-pen text-success text-active"></i></a>
                          <a onclick="return confirm('Bạn có chắc chắn muốn xóa mục này không?')" href="{{URL::to('/xoa-dia-chi-giao-hang/'.$dc -> DCGH_MA)}}"
                            class="active styling-edit" ui-toggle-class=""><i class="fas fa-times" style="color: #ec4c36; font-size: large;"></i></a>
                        </td>
                @endforeach
              </tbody>
            </table>
          </div>
          <a href="{{URL::to('/them-dia-chi-giao-hang')}}" class="pt-5">
            <button type="button" style="width:100%;" class="btn btn-primary">
              <b>Thêm địa chỉ giao hàng <i class="fas fa-plus-circle"></i></b>
            </button>
          </a>
        </div>
    </section>
@endsection
