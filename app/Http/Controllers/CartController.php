<?php

namespace App\Http\Controllers;

use DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Cart;
use Carbon\Carbon;

use Illuminate\Http\Request;
session_start();

class CartController extends Controller
{

/*-----------------------------------*\
  #FRONTEND <FOR KHÁCH THÀNH VIÊN>
\*-----------------------------------*/

    public function AuthLogin(){
        $KH_MA = Session::get('KH_MA');
        if($KH_MA){
            return Redirect::to('show-cart');
        }else{
            $alert='Đăng nhập để có thể sử dụng chức năng này!';
            return Redirect::back()->send()->with('alert', $alert);
        }
    }

    public function save_cart(Request $request){
        $this->AuthLogin();
        $KH_MA = Session::get('KH_MA');

        $all_category_product = DB::table('the_loai_sach')->get();
        $all_cart_product = DB::table('gio_hang')
        ->join('khach_hang','gio_hang.KH_MA','=','khach_hang.KH_MA')
        ->where('khach_hang.KH_MA', $KH_MA)->first();
        
        $data = array();
        $data['GH_MA'] = $all_cart_product->GH_MA;
        $data['SACH_MA'] = $request->productid_hidden;
        $data['CTGH_SOLUONG'] = $request->qty;
        
        /*echo '<pre>';
        print_r ($data);
        echo '</pre>';*/

        DB::table('gio_hang')->where('GH_MA', $all_cart_product->GH_MA)->update(['GH_NGAYCAPNHATLANCUOI' => Carbon::now('Asia/Ho_Chi_Minh')]);
        $checkgh=DB::table('chi_tiet_gio_hang')
        ->where('GH_MA', $all_cart_product->GH_MA)
        ->where('SACH_MA', $request->productid_hidden)->count();
        if($checkgh>0){ 
            DB::table('chi_tiet_gio_hang')
            ->where('GH_MA', $all_cart_product->GH_MA)
            ->where('SACH_MA', $request->productid_hidden)
            ->update($data);
        }
        else{ DB::table('chi_tiet_gio_hang')->insert($data);}
        Session::put('message','Thêm sách vào giỏ hàng thành công');
        
        return Redirect::to('chi-tiet-san-pham/'.$request->productid_hidden);
    }

    public function show_cart(){ ///ok
        $this->AuthLogin();
        $KH_MA = Session::get('KH_MA');
        $all_category_product = DB::table('the_loai_sach')->get();
        $all_cart_product = DB::table('gio_hang')
        ->join('khach_hang','gio_hang.KH_MA','=','khach_hang.KH_MA')
        ->join('chi_tiet_gio_hang','gio_hang.GH_MA','=','chi_tiet_gio_hang.GH_MA')
        ->join('sach','chi_tiet_gio_hang.SACH_MA','=','sach.SACH_MA')
        ->where('khach_hang.KH_MA', $KH_MA)->orderby('GH_NGAYCAPNHATLANCUOI','desc')->get();
        
        return view('pages.cart.show_cart')->with('category', $all_category_product)->with('all_cart_product', $all_cart_product);
    }

    public function update_cart(Request $request){ ///ok
        $this->AuthLogin();
        $KH_MA = Session::get('KH_MA');
        $all_category_product = DB::table('the_loai_sach')->get();
        $all_cart_product = DB::table('gio_hang')
        ->join('khach_hang','gio_hang.KH_MA','=','khach_hang.KH_MA')
        ->where('khach_hang.KH_MA', $KH_MA)->first();
        
        /*$data = array();
        $data['GH_MA'] = $all_cart_product->GH_MA;
        $data['SACH_MA'] = $request->productid_hidden;
        $data['CTGH_SOLUONG'] = $request->qty;
        
        echo '<pre>';
        print_r ($data);
        echo '</pre>';*/

        //Số lượng tồn
        $ddh = DB::table('chi_tiet_don_dat_hang')
        ->join('don_dat_hang','chi_tiet_don_dat_hang.DDH_MA','=','don_dat_hang.DDH_MA')
        ->where('TT_MA', '!=', 5)
        ->where('SACH_MA', $request->productid_hidden)->sum('CTDDH_SOLUONG');

        $nhap = DB::table('chi_tiet_lo_nhap')
            ->where('SACH_MA', $request->productid_hidden)->sum('CTLN_SOLUONG');
        $xuat = DB::table('chi_tiet_lo_xuat')
            ->where('SACH_MA', $request->productid_hidden)->sum('CTLX_SOLUONG');

        if ($nhap-$xuat-$ddh>=$request->qty && $request->qty>0){
            DB::table('gio_hang')->where('GH_MA', $all_cart_product->GH_MA)->update(['GH_NGAYCAPNHATLANCUOI' => Carbon::now('Asia/Ho_Chi_Minh')]);
            DB::table('chi_tiet_gio_hang')->where('GH_MA', $all_cart_product->GH_MA)->where('SACH_MA', $request->productid_hidden)->update(['CTGH_SOLUONG' => $request->qty]);
        }
        if ($request->qty<1){Session::put('message','Số lượng yêu cầu cần lớn hơn 1');}
        else{
            Session::put('message','Số lượng yêu cầu cần nhỏ hơn hoặc bằng số lượng tồn kho: '.$nhap-$xuat-$ddh.'');
        }
        
        return Redirect::to('show-cart');
    }

    public function delete_cart($SACH_MA){ ///ok
        $this->AuthLogin();
        $KH_MA = Session::get('KH_MA');
        $all_category_product = DB::table('the_loai_sach')->get();
        $all_cart_product = DB::table('gio_hang')
        ->join('khach_hang','gio_hang.KH_MA','=','khach_hang.KH_MA')
        ->where('khach_hang.KH_MA', $KH_MA)->first();

        DB::table('gio_hang')->where('GH_MA', $all_cart_product->GH_MA)->update(['GH_NGAYCAPNHATLANCUOI' => Carbon::now('Asia/Ho_Chi_Minh')]);
        DB::table('chi_tiet_gio_hang')->where('GH_MA', $all_cart_product->GH_MA)->where('SACH_MA',$SACH_MA)->delete();
        
        return Redirect::to('show-cart');
    }
}
