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
  #BACKEND <FOR NHÂN VIÊN>
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

/*-----------------------------------*\
  #BACKEND <FOR NHÂN VIÊN BÁN HÀNG>
\*------------------------------------*/

    //đánh giá
    public function danh_gia(){
        $this->AuthLogin();

        $all_danh_gia = DB::table('danh_gia')
        ->join('sach','sach.SACH_MA','=','danh_gia.SACH_MA')
        ->join('khach_hang','khach_hang.KH_MA','=','danh_gia.KH_MA')
        ->orderby('DG_MA','desc')->paginate(10);
        return view('admin.danh-gia')->with('all_danh_gia', $all_danh_gia);
    }

    public function delete_danh_gia($DG_MA){
        $this->AuthLogin();

        DB::table('danh_gia')->where('DG_MA',$DG_MA)->delete();
        Session::put('message','Xóa đánh giá thành công');
        return Redirect::to('danh-gia');
    }

/*-----------------------------------*\
  #BACKEND <FOR CHỦ>
\*------------------------------------*/

    //khách hàng
    public function khach_hang(){
        $this->AuthLogin();

        $all_khach_hang = DB::table('khach_hang')
        //->join('sach','sach.SACH_MA','=','khach_hang.SACH_MA')
        //->join('khach_hang','khach_hang.KH_MA','=','khach_hang.KH_MA')
        ->orderby('KH_MA','desc')->paginate(10);
        return view('admin.khach-hang')->with('all_khach_hang', $all_khach_hang);
    }

        //Thống kê
        public function thong_ke(){
            $this->AuthLogin();
    
            $dayprev=Carbon::now('Asia/Ho_Chi_Minh')->subMonths(3);
            $daynow=Carbon::now('Asia/Ho_Chi_Minh');
            //echo $dayprev .";". $daynow;
    
            Session::put('TGBDau', $dayprev);
            Session::put('TGKThuc', $daynow);

            return view('admin.thong_ke');
        }

        public function thong_ke_tg(Request $request){
            $this->AuthLogin();
            $homnay=Carbon::now('Asia/Ho_Chi_Minh');
            if ($request->TGBDau && $request->TGKThuc && $request->TGBDau<=$request->TGKThuc && $request->TGKThuc<=$homnay ){
                Session::put('TGBDau', $request->TGBDau);
                Session::put('TGKThuc', $request->TGKThuc);

                return view('admin.thong_ke');
            }
            
            Session::put('message','Xin kiểm tra lại dữ liệu đầu vào');
            return view('admin.thong_ke');
        }

}