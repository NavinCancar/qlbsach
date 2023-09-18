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
  #FRONTEND <FOR ALL>
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

/*-----------------------------------*\
  #FRONTEND <FOR KHÁCH THÀNH VIÊN>???
\*-----------------------------------*/

    //Location
    public function all_location(){
        $this->AuthLogin();
        $KH_MA = Session::get('KH_MA');
        $all_category_product = DB::table('loai_noi_that')->get();
        $all_DCGH = DB::table('dia_chi_giao_hang')
        ->join('tinh_thanh_pho','dia_chi_giao_hang.TTP_MA','=','tinh_thanh_pho.TTP_MA')
        ->where('dia_chi_giao_hang.KH_MA',$KH_MA)
        ->orderby('dia_chi_giao_hang.DCGH_MA')->get();
        
        $count_DCGH = DB::table('dia_chi_giao_hang')
        ->where('dia_chi_giao_hang.KH_MA',$KH_MA)
        ->count('dia_chi_giao_hang.DCGH_MA');
        Session::put('count_DCGH',$count_DCGH);
        return view('pages.location.all-location')->with('category', $all_category_product)->with('all_DCGH', $all_DCGH);
    }

    public function add_location(){
        $this->AuthLogin();
        $KH_MA = Session::get('KH_MA');
        $all_category_product = DB::table('loai_noi_that')->get();

        $ttp= DB::table('tinh_thanh_pho')->orderby('TTP_TEN')->get();
        
        return view('pages.location.add-location')->with('category', $all_category_product)->with(compact('ttp'));
    }

    public function save_location(Request $request){
        $this->AuthLogin();
        $data = array();
        $data['DCGH_HOTENNGUOINHAN'] = $request->DCGH_HOTENNGUOINHAN;
        $data['TTP_MA'] = $request->TTP_MA;
        $data['DCGH_VITRICUTHE'] = $request->DCGH_VITRICUTHE;
        if ($request->DCGH_GHICHU == NULL) $request->DCGH_GHICHU = "Không";
        $data['DCGH_GHICHU'] = $request->DCGH_GHICHU;

        $KH_MA = Session::get('KH_MA');
        $data['KH_MA'] = $KH_MA;
        DB::table('dia_chi_giao_hang')->insert($data);
        Session::put('message','Thêm địa chỉ giao hàng mới thành công');
        return Redirect::to('dia-chi-giao-hang');
    }

    public function edit_location($DCGH_MA){
        $this->AuthLogin();
        $KH_MA = Session::get('KH_MA');
        $all_category_product = DB::table('loai_noi_that')->get();

        $ttp= DB::table('tinh_thanh_pho')->orderby('TTP_TEN')->get();
        $edit_location = DB::table('dia_chi_giao_hang')
        ->where('dia_chi_giao_hang.DCGH_MA',$DCGH_MA)->get();
        return view('pages.location.edit-location')->with('category', $all_category_product)
        ->with('ttp', $ttp)->with(compact('ttp'))->with('edit_location', $edit_location);
    }

    public function update_location(Request $request, $DCGH_MA){
        $this->AuthLogin();
        $data = array();
        $data['DCGH_HOTENNGUOINHAN'] = $request->DCGH_HOTENNGUOINHAN;
        $data['TTP_MA'] = $request->TTP_MA;
        $data['DCGH_VITRICUTHE'] = $request->DCGH_VITRICUTHE;
        if ($request->DCGH_GHICHU == NULL) $request->DCGH_GHICHU = "Không";
        $data['DCGH_GHICHU'] = $request->DCGH_GHICHU;

        DB::table('dia_chi_giao_hang')->where('DCGH_MA',$DCGH_MA)->update($data);

        Session::put('message','Cập nhật địa chỉ giao hàng thành công');
        return Redirect::to('dia-chi-giao-hang');
    }

    public function delete_location($DCGH_MA){
        $this->AuthLogin();

        $checkforeign = DB::table('dia_chi_giao_hang')
        ->join('don_dat_hang','dia_chi_giao_hang.DCGH_MA','=','don_dat_hang.DCGH_MA')
        ->where('dia_chi_giao_hang.DCGH_MA',$DCGH_MA)->count();

        if($checkforeign != 0){
            Session::put('message','Có đơn hàng tồn tại vào địa chỉ này, địa chỉ này không thể xoá');
            return Redirect::to('dia-chi-giao-hang');
        }

        DB::table('dia_chi_giao_hang')->where('DCGH_MA',$DCGH_MA)->delete();
        Session::put('message','Xóa địa chỉ giao hàng thành công');
        return Redirect::to('dia-chi-giao-hang');
    }

    //Account
    public function show_account(){
        $this->AuthLogin();
        $KH_MA = Session::get('KH_MA');
        $all_category_product = DB::table('loai_noi_that')->get();
        $account_info = DB::table('khach_hang')->where('KH_MA',$KH_MA)->get();
        
        return view('pages.account.show_account')
        ->with('category', $all_category_product)->with('account_info', $account_info);
    }

    public function edit_account(){
        $this->AuthLogin();
        $KH_MA = Session::get('KH_MA');
        $all_category_product = DB::table('loai_noi_that')->get();
        $account_info = DB::table('khach_hang')->where('KH_MA',$KH_MA)->get();
        
        return view('pages.account.edit_account')
        ->with('category', $all_category_product)->with('account_info', $account_info);
    }

    public function update_account(Request $request){
        $this->AuthLogin();
        $KH_MA = Session::get('KH_MA');
        $data = array();
        $data['KH_HOTEN'] = $request->KH_HOTEN;
        $data['KH_SODIENTHOAI'] = $request->KH_SODIENTHOAI;
        $data['KH_NGAYSINH'] = $request->KH_NGAYSINH;
        $data['KH_GIOITINH'] = $request->KH_GIOITINH;
        $data['KH_EMAIL'] = $request->KH_EMAIL;
        $get_image= $request->file('KH_DUONGDANANHDAIDIEN');

        if($get_image){

            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.',$get_name_image));

            $new_image =  $KH_MA.'.'.$get_image->getClientOriginalExtension();
            $get_image->move('public/frontend/img/khachhang',$new_image);
            $data['KH_DUONGDANANHDAIDIEN'] = $new_image;
        }
        
        //Dò trùng

        $dskh=DB::table('khach_hang')->get();
        foreach ($dskh as $ds){
            if (strtolower($ds->KH_SODIENTHOAI)==strtolower($request->KH_SODIENTHOAI) && $ds->KH_MA!=$KH_MA) {
                Session::put('message','Cập nhật thất bại. Số điện thoại này đã có trong hệ thống!');
                return Redirect::to('tai-khoan');
            }
            if (strtolower($ds->KH_EMAIL) ==strtolower($request->KH_EMAIL)  && $ds->KH_MA !=$KH_MA ) {
                Session::put('message','Cập nhật thất bại. Email này đã có trong hệ thống!');
                return Redirect::to('tai-khoan');
            }
        }
        DB::table('khach_hang')->where('KH_MA',$KH_MA)->update($data);
        Session::put('message','Cập nhật thông tin thành công');
        return Redirect::to('tai-khoan');
    }

    //Mật khẩu
    public function change_password_account(){
        $this->AuthLogin();
        $all_category_product = DB::table('loai_noi_that')->get();
        return view('pages.account.change_password_account')->with('category', $all_category_product);
    }

    public function update_password_account(Request $request){
        $this->AuthLogin();
        $data = array();
        $KH_MA = Session::get('KH_MA');
        $KH= DB::table('khach_hang')->where('KH_MA',$KH_MA)->first();
        if ($KH->KH_MATKHAU!=$request->KH_MATKHAUCU){
            Session::put('message','Mật khẩu cũ sai, vui lòng kiểm tra lại!');
            return Redirect::to('doi-mat-khau');
        }
        if ($request->KH_MATKHAUMOI1!=$request->KH_MATKHAUMOI2){
            Session::put('message','Mật khẩu nhập lại sai, vui lòng kiểm tra lại!');
            return Redirect::to('doi-mat-khau');
        }
        if ($request->KH_MATKHAUMOI1==$request->KH_MATKHAUCU){
            Session::put('message','Mật khẩu cũ và mật khẩu mới phải khác nhau, vui lòng kiểm tra lại!');
            return Redirect::to('doi-mat-khau');
        }
        $data['KH_MATKHAU'] = $request->KH_MATKHAUMOI1;

        DB::table('khach_hang')->where('KH_MA',$KH_MA)->update($data);
        Session::put('message','Đổi mật khẩu thành công');
        return Redirect::to('doi-mat-khau');
    }


/*-----------------------------------*\
  #BACKEND <FOR CHỦ>
\*-----------------------------------*/

    public function AuthLoginChu(){
        $NV_MA = Session::get('NV_MA');
        $CV_MA = DB::table('nhan_vien')->where('NV_MA',$NV_MA)->first();
        if($NV_MA){
            if($CV_MA->CV_MA != 1){
                return Redirect::to('dashboard')->send();
            }
        }else{
            return Redirect::to('admin')->send();
        }
    }
    
    public function all_khachhang(){
        $this->AuthLoginChu(); 
        $all_khachhang = DB::table('khach_hang')
        ->orderby('khach_hang.KH_MA','desc')->paginate(10);
        $count_khachhang = DB::table('khach_hang')
        ->orderby('khach_hang.KH_MA','desc')->count();
        Session::put('count_khachhang',$count_khachhang);
        $manager_khachhang = view('admin.all_khachhang')->with('all_khachhang', $all_khachhang);
        return view('admin-layout')->with('admin.all_khachhang', $manager_khachhang); 
    }
}
