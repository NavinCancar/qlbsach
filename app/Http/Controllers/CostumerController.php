<?php

namespace App\Http\Controllers;

use DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;

use Illuminate\Http\Request;

use Carbon\Carbon;
session_start();

class CostumerController extends Controller
{

/*-----------------------------------*\
  #FRONTEND
\*-----------------------------------*/

    public function AuthLogin(){ ///ok
        $KH_MA = Session::get('KH_MA');
        if($KH_MA){
            return Redirect::to('show-cart');
        }else{
            return Redirect::to('trang-chu')->send();
        }
    }
    //Dang nhap/xuat khach hang
    public function dang_nhap(){ ///ok
        $all_category_product = DB::table('the_loai_sach')->get();

    	return view('login')->with('category', $all_category_product);
    }

    public function trang_chu(Request $request){ ///ok
        //Đăng nhập
    	$KH_SODIENTHOAI = $request->KH_SODIENTHOAI;
        $KH_MATKHAU = $request->KH_MATKHAU;
        
        $result = DB::table('khach_hang')->where('KH_SODIENTHOAI', $KH_SODIENTHOAI)->where('KH_MATKHAU', $KH_MATKHAU)->first();
        /*echo '<pre>';
        print_r ($result);
        echo '</pre>';*/
        
        if($result){
            Session::put('KH_HOTEN',$result->KH_HOTEN);
            Session::put('KH_MA',$result->KH_MA);
            Session::put('KH_DUONGDANANHDAIDIEN',$result->KH_DUONGDANANHDAIDIEN);
            return Redirect::to('/trang-chu');
        }else{
            Session::put('messagedn','Mật khẩu hoặc tài khoản sai. Vui lòng nhập lại!');
            return Redirect::to('/dang-nhap');
        } 
    }

    public function logout(Request $request){ ///ok
        $this->AuthLogin();
        Session::put('KH_HOTEN',null);
        Session::put('KH_MA',null);
        Session::put('KH_DUONGDANANHDAIDIEN',null);
        return Redirect::to('/trang-chu');
    }
    
    public function signup(Request $request){
        //Đăng ký
        //Ghi nhận đăng ký, chưa xử lý ảnh đại diện
        $data = array();
        $data['KH_SODIENTHOAI'] = $request->KH_SODIENTHOAI;
        $data['KH_MATKHAU'] = $request->KH_MATKHAU;  
        $data['KH_HOTEN'] = $request->KH_HOTEN;
        $data['KH_NGAYSINH'] = $request->KH_NGAYSINH;
        $data['KH_GIOITINH'] = $request->KH_GIOITINH;
        $data['KH_EMAIL'] = $request->KH_EMAIL;
        $data['KH_DUONGDANANHDAIDIEN'] = 'macdinh.png';

        //Dò trùng
        $dskh=DB::table('khach_hang')->get();
        foreach ($dskh as $ds){
            if (strtolower($ds->KH_SODIENTHOAI)==strtolower($request->KH_SODIENTHOAI)) {
                Session::put('messagedk','Số điện thoại này đã có trong hệ thống, vui lòng đăng ký bằng số khác!');
                return Redirect::to('/dang-nhap');
            }
            if (strtolower($ds->KH_EMAIL) ==strtolower($request->KH_EMAIL) ) {
                Session::put('messagedk','Email này đã có trong hệ thống, vui lòng đăng ký bằng số khác!');
                return Redirect::to('/dang-nhap');
            }
        }

        DB::table('khach_hang')->insert($data);

        //Lấy mã khách để xử lý ảnh đại diện
        $KH = DB::table('khach_hang')->where('khach_hang.KH_SODIENTHOAI', $request->KH_SODIENTHOAI)
        ->orderby('khach_hang.KH_MA','desc')->first();
        $KH_MA = $KH->KH_MA;

        //Xử lý ảnh đại diện
        $get_image= $request->file('KH_DUONGDANANHDAIDIEN');
        if($get_image){
            $data1 = array();
            $new_image =  'khachhang'.$KH_MA.'.'.$get_image->getClientOriginalExtension();
            $get_image->move('public/frontend/images/khachhang',$new_image);
            $data1['KH_DUONGDANANHDAIDIEN'] = $new_image;
            DB::table('khach_hang')->where('KH_MA',$KH_MA)->update($data1);
        }

        //Tạo giỏ hàng cho khách
        $data2 = array();
        $data2['GH_MA'] = $KH_MA;
        $data2['KH_MA'] = $KH_MA;
        $data2['GH_NGAYCAPNHATLANCUOI'] = Carbon::now('Asia/Ho_Chi_Minh');

        //print_r ($data2);
        DB::table('gio_hang')->insert($data2);

        //echo '<pre>';
        //print_r ($data);
        //echo '</pre>';
        
        Session::put('messagedk','Đăng ký thành công, giờ bạn có thể đăng nhập!');
        return Redirect::to('/dang-nhap');
    }
}
