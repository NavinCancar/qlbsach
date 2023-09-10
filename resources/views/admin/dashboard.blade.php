@extends('admin-layout')
@section('admin-content')
				<div class="p-3 shadow-sm text-center rounded secondary-bg-hover">
                    <h2 class="fs-1 m-0 primary-text primary-font">Hệ thống quản lý bán sách</h2>
                </div>
                <div class="row g-3 my-2">
                    <div class="col-lg-3 col-md-6">
                        <div class="p-3 m-1 secondary-bg-hover shadow-sm d-flex justify-content-around align-items-center rounded row">
                            <h3 class="fs-2 col-sm-8">
								<?php
									$ddh_cxl= Session::get('SO_DDH_CXL');
									if ($ddh_cxl) echo $ddh_cxl;
								?>
							</h3>
                            <i class="fas fa-file fs-1 primary-text rounded-full secondary-bg p-3 col-sm-4"></i>
                            <p class="fs-5">Đơn hàng vẫn chưa xử lý</p>
                            <a href="#" class="text-center">Xem thêm</a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="p-3 m-1 secondary-bg-hover shadow-sm d-flex justify-content-around align-items-center rounded row">
                            <h3 class="fs-2 col-sm-8">
								<?php
									$ddh_dxl= Session::get('SO_DDH_DXL');
									if ($ddh_dxl) echo $ddh_dxl;
								?>
							</h3>
                            <i class="fas fa-box fs-1 primary-text rounded-full secondary-bg p-3 col-sm-4"></i>
                            <p class="fs-5">Đơn hàng chờ vận chuyển</p>
                            <a href="#" class="text-center">Xem thêm</a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="p-3 m-1 secondary-bg-hover shadow-sm d-flex justify-content-around align-items-center rounded row">
                            <h3 class="fs-2 col-sm-8">
								<?php
									$ddh_dg= Session::get('SO_DDH_DG');
									if ($ddh_dg) echo $ddh_dg;
								?>
							</h3>
                            <i class="fas fa-truck fs-1 primary-text rounded-full secondary-bg p-3 col-sm-4"></i>
                            <p class="fs-5">Đơn hàng đang được giao</p>
                            <a href="#" class="text-center">Xem thêm</a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="p-3 m-1 secondary-bg-hover shadow-sm d-flex justify-content-around align-items-center rounded row row">
                            <h3 class="fs-2 col-sm-8">
								<?php
									$users= Session::get('SO_NGUOI_DUNG');
									if ($users) echo $users;
								?>
							</h3>
                            <i class="fas fa-users fs-1 primary-text rounded-full secondary-bg p-3 col-sm-4"></i>
                            <p class="fs-5">Khách hàng thành viên</p>
                            <a href="#" class="text-center">Xem thêm</a>
                        </div>
                    </div>
                </div>
@endsection