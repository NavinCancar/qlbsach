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
            Giỏ hàng
            <span class="dis-block has-before"></span>
          </h2>
          <?php
            $message = Session::get('message');
            if($message){
                echo '<span class="text-warning">'.$message.'</span>';
                Session::put('message',null);
            }
          ?>
          <!--GIỎ-->
          <div class="table-responsive">
            <table class="table b-t b-light table-responsive-md text-center primary-table">
              <thead>
                <tr>
                  <th style='width: 120px;'>Ảnh</th>
                  <th>Sách</th>
                  <th>Giá</th>
                  <th style="width: 14rem;">Số lượng</th>
                  <th>Tổng</th>
                  <th style="width: 50px;">Xoá</th>
                </tr>
              </thead>
              <tbody>
                <?php $tong =0; ?>
                @foreach($all_cart_product as $key => $cart_pro)
                    <tr>
                        <td style="padding-top: 0;"><img src="../qlbsach/public/frontend/images/sach/{{$cart_pro->SACH_DUONGDANANHBIA}}" style='width: 120px;' alt=""></td>
                        <td style='white-space: nowrap; overflow: hidden;text-overflow: ellipsis;'>{{$cart_pro->SACH_TEN}}</td>
                        <td>{{number_format($cart_pro->SACH_GIA)}} VNĐ</td>
                        <td style="white-space: nowrap;">
                            <form action="{{URL::to('/update-cart')}}" method="POST">
                                {{ csrf_field() }}
                                    <button type="button" class="btn-change" onclick="changeQty(this, -1)"><i
                                        class="fas fa-minus"></i></button>
                                    <input class="w-25 pl-1" name="qty" value="{{$cart_pro->CTGH_SOLUONG}}" type="number" min="1" value="1">
                                    <button type="button" class="btn-change" onclick="changeQty(this, 1)"><i
                                        class="fas fa-plus"></i></button>
                                    <input name="productid_hidden" type="hidden"  value="{{$cart_pro->SACH_MA}}" />
                            </form>
                        </td>
                        <td>{{number_format($cart_pro->CTGH_SOLUONG*$cart_pro->SACH_GIA)}} VNĐ</td>
                        <td><a onclick="return confirm('Bạn có chắc chắn muốn xóa mục này không?')" href="{{URL::to('/delete-cart/'.$cart_pro->SACH_MA)}}"
                            class="active styling-edit" ui-toggle-class=""><i class="fas fa-times"
                                style="color: #ec4c36; font-size: large;"></i></a></td>
                    </tr>
                    <?php
                        $tong = $tong + $cart_pro->CTGH_SOLUONG*$cart_pro->SACH_GIA;
                    ?>
                @endforeach
              </tbody>
            </table>
          </div>
          <div class="row pt-5">
            <div class=" col-lg-8 col-md-6 col-12">
              <div class="d-flex justify-content-between sum-cart">
                <h4>Tổng giỏ hàng:</h4>
                <div></div>
                <h3 class="h4"><b><?php echo number_format($tong); ?> VNĐ</b></h3>
              </div>
            </div>
            <div class=" col-lg-2 col-md-3 col-12 button-cart">
              <a href="{{URL::to('/show-detail-order')}}"><button class="btn btn-primary">Đặt hàng ngay!</button></a>
            </div>
            <div class=" col-lg-2 col-md-3 col-12 button-cart">
              <a href="{{URL::to('/show-all-bill')}}"><button class="btn btn-secondary">Xem danh sách đơn hàng cũ</button></a>
            </div>
          </div>
        </div>
    </section>



        <script>
            //Nút +, -
            function changeQty(button, change) {
                var inputElement = button.parentNode.querySelector('input[type="number"]');
                var inputValue = parseInt(inputElement.value);

                if (isNaN(inputValue)) {
                inputValue = 1;
                }

                var newValue = inputValue + change;
                newValue = newValue < 1 ? 1 : newValue;

                inputElement.value = newValue;
                inputElement.dispatchEvent(new Event('input'));
            }

            //Tự động submit khi đổi qty
            // Get all input elements with the name "qty"
            var qtyInputs = document.querySelectorAll('input[name="qty"]');

            // Add event listener to each qty input
            qtyInputs.forEach(function(input) {
                input.addEventListener('input', function() {
                this.closest('form').submit();
                });
            });
        </script>
@endsection