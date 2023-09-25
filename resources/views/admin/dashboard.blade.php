@extends('admin-layout')
@section('admin-content')
				<div class="p-3 shadow-sm text-center rounded secondary-bg-hover">
                    <h2 class="fs-1 m-0 primary-text primary-font">Hệ thống quản lý bán sách</h2>
                </div>
                <div class="row g-3 my-2">
                    <div class="col-lg-3 col-md-6">
                        <div class="p-3 m-1 secondary-bg-hover shadow-sm justify-content-around align-items-center rounded">
                            <div class="d-flex justify-content-between">
                                <h3 class="fs-2 mb-0">
                                    <?php
                                    $ddh_cxl = Session::get('SO_DDH_CXL');
                                    if ($ddh_cxl) echo $ddh_cxl;
                                    ?>
                                </h3>
                                <div class="circle-bg secondary-bg p-3 text-center">
                                    <i class="fas fa-file fs-1 primary-text"></i>
                                </div>
                            </div>
                            <p class="fs-5">Đơn hàng vẫn chưa xử lý</p>
                            <a href="{{URL::to('/danh-muc-trang-thai/1')}}" class="text-center">Xem thêm</a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="p-3 m-1 secondary-bg-hover shadow-sm justify-content-around align-items-center rounded">
                            <div class="d-flex justify-content-between">
                                <h3 class="fs-2 mb-0">
                                    <?php
                                        $ddh_dxl= Session::get('SO_DDH_DXL');
                                        if ($ddh_dxl) echo $ddh_dxl;
                                    ?>
                                </h3>
                                <div class="circle-bg secondary-bg p-3 text-center">
                                    <i class="fas fa-box fs-1 primary-text"></i>
                                </div>
                            </div>
                            <p class="fs-5">Đơn hàng chờ vận chuyển</p>
                            <a href="{{URL::to('/danh-muc-trang-thai/2')}}" class="text-center">Xem thêm</a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="p-3 m-1 secondary-bg-hover shadow-sm justify-content-around align-items-center rounded">
                            <div class="d-flex justify-content-between">
                                <h3 class="fs-2 mb-0">
                                    <?php
                                    	$ddh_dg= Session::get('SO_DDH_DG');
                                        if ($ddh_dg) echo $ddh_dg;
                                    ?>
                                </h3>
                                <div class="circle-bg secondary-bg p-3 text-center">
                                    <i class="fas fa-truck fs-1 primary-text"></i>
                                </div>
                            </div>
                            <p class="fs-5">Đơn hàng đang được giao</p>
                            <a href="{{URL::to('/danh-muc-trang-thai/3')}}" class="text-center">Xem thêm</a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="p-3 m-1 secondary-bg-hover shadow-sm justify-content-around align-items-center rounded">
                            <div class="d-flex justify-content-between">
                                <h3 class="fs-2 mb-0">
                                    <?php
                                    	$users= Session::get('SO_NGUOI_DUNG');
                                        if ($users) echo $users;
                                    ?>
                                </h3>
                                <div class="circle-bg secondary-bg p-3 text-center">
                                    <i class="fas fa-users fs-1 primary-text"></i>
                                </div>
                            </div>
                            <p class="fs-5">Số khách hàng thành viên</p>
                            <a href="{{URL::to('/khach-hang')}}" class="text-center">Xem thêm</a>
                        </div>
                    </div>
                </div>
@endsection