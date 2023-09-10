<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;

use Carbon\Carbon;
session_start();

class AdminController extends Controller
{

/*-----------------------------------*\
  #BACKEND <ONLY NHÂN VIÊN>
\*-----------------------------------*/

    public function AuthLogin(){
        $NV_MA = Session::get('NV_MA');
        if($NV_MA){
            return Redirect::to('dashboard');
        }else{
            return Redirect::to('admin')->send();
        }
    }

    public function index(){
    	return view('admin-login');
    }

    public function show_dashboard(){
        $this->AuthLogin();

        //Các mini box

        //Đơn hàng chưa xử lý
        $ddh_cxl = DB::table('don_dat_hang')->where('TT_MA', 1)->count();
        Session::put('SO_DDH_CXL',$ddh_cxl);

        //Đơn hàng chờ vận chuyển
        $ddh_dxl = DB::table('don_dat_hang')->where('TT_MA', 2)->count();
        Session::put('SO_DDH_DXL',$ddh_dxl);

        //Đơn hàng đang giao
        $ddh_dg = DB::table('don_dat_hang')->where('TT_MA', 3)->count();
        Session::put('SO_DDH_DG',$ddh_dg);

        //Khách hàng thành viên
        $users = DB::table('khach_hang')->count();
        Session::put('SO_NGUOI_DUNG',$users);
            
    	return view('admin.dashboard');
    }

    public function dashboard(Request $request){
    	$admin_email = $request->admin_email;
        $admin_password = $request->admin_password;

        $result = DB::table('nhan_vien')->where('NV_EMAIL', $admin_email)->where('NV_MATKHAU', $admin_password)->first();
        if($result){
            Session::put('NV_HOTEN',$result->NV_HOTEN);
            Session::put('NV_MA',$result->NV_MA);
            Session::put('CV_MA_User',$result->CV_MA);
            Session::put('NV_DUONGDANANHDAIDIEN',$result->NV_DUONGDANANHDAIDIEN);
            return Redirect::to('/dashboard');
        }else{
            Session::put('message','Mật khẩu hoặc tài khoản sai. Vui lòng nhập lại!');
            return Redirect::to('/admin');
        }
    }

    public function logout(Request $request){
        $this->AuthLogin();
        Session::put('NV_HOTEN',null);
        Session::put('NV_MA',null);
        Session::put('CV_MA_User',null);
        Session::put('NV_DUONGDANANHDAIDIEN',null);
        return Redirect::to('/admin');
    }
}
