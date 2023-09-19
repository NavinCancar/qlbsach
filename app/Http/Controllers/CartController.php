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

    //Giỏ hàng
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
        priSACH_r ($data);
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
        priSACH_r ($data);
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
            Session::put('message','Giỏ hàng đã được cập nhật');
        }
        elseif ($request->qty<1){Session::put('message','Số lượng yêu cầu cần lớn hơn 1');}
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

    //Đơn đặt hàng
    public function show_all_bill(){
        $this->AuthLogin();
        $KH_MA = Session::get('KH_MA');
        $all_category_product = DB::table('the_loai_sach')->get();
        $all_DDH=  DB::table('don_dat_hang')
        ->join('trang_thai','don_dat_hang.TT_MA','=','trang_thai.TT_MA')
        ->join('dia_chi_giao_hang','dia_chi_giao_hang.DCGH_MA','=','don_dat_hang.DCGH_MA')
        ->where('dia_chi_giao_hang.KH_MA', $KH_MA)->orderby('don_dat_hang.DDH_NGAYDAT','desc')->paginate(5);
        $group_DDH = DB::table('don_dat_hang')
        ->join('chi_tiet_don_dat_hang','don_dat_hang.DDH_MA','=','chi_tiet_don_dat_hang.DDH_MA')
        ->join('sach','sach.SACH_MA','=','chi_tiet_don_dat_hang.SACH_MA')
        ->join('dia_chi_giao_hang','dia_chi_giao_hang.DCGH_MA','=','don_dat_hang.DCGH_MA')
        ->where('dia_chi_giao_hang.KH_MA', $KH_MA)->get();
        
        return view('pages.cart.show_all_bill')->with('category', $all_category_product)
        ->with('all_DDH', $all_DDH)->with('group_DDH', $group_DDH);
    }

    public function show_detail_bill($DDH_MA){
        $this->AuthLogin();
        $KH_MA = Session::get('KH_MA');
        $all_category_product = DB::table('the_loai_sach')->get();
        $all_DDH=  DB::table('don_dat_hang')
        ->join('trang_thai','don_dat_hang.TT_MA','=','trang_thai.TT_MA')
        ->join('dia_chi_giao_hang','dia_chi_giao_hang.DCGH_MA','=','don_dat_hang.DCGH_MA')
        ->join('hinh_thuc_thanh_toan','hinh_thuc_thanh_toan.HTTT_MA','=','don_dat_hang.HTTT_MA')
        ->join('tinh_thanh_pho','dia_chi_giao_hang.TTP_MA','=','tinh_thanh_pho.TTP_MA')
        ->where('don_dat_hang.DDH_MA', $DDH_MA)->get();

        $group_DDH = DB::table('chi_tiet_don_dat_hang')
        ->join('sach','sach.SACH_MA','=','chi_tiet_don_dat_hang.SACH_MA')
        ->where('chi_tiet_don_dat_hang.DDH_MA', $DDH_MA)->get();

        return view('pages.cart.show_detail_bill')->with('category', $all_category_product)
        ->with('all_DDH', $all_DDH)->with('group_DDH', $group_DDH);
    }
    
    //Đặt hàng
    public function show_detail_order(){
        $this->AuthLogin();
        $KH_MA = Session::get('KH_MA');
        $all_category_product = DB::table('the_loai_sach')->get();

        $DCGH = DB::table('dia_chi_giao_hang')
        ->join('tinh_thanh_pho','dia_chi_giao_hang.TTP_MA','=','tinh_thanh_pho.TTP_MA')
        ->where('dia_chi_giao_hang.KH_MA', $KH_MA)->get();

        $CTGH = DB::table('chi_tiet_gio_hang')
        ->join('sach','sach.SACH_MA','=','chi_tiet_gio_hang.SACH_MA')
        ->join('gio_hang','chi_tiet_gio_hang.GH_MA','=','gio_hang.GH_MA')
        ->join('khach_hang','khach_hang.KH_MA','=','gio_hang.KH_MA')
        ->where('khach_hang.KH_MA', $KH_MA)->get();

        $HTTT = DB::table('hinh_thuc_thanh_toan')->orderby('HTTT_MA')->get();

        return view('pages.cart.show_detail_order')->with('category', $all_category_product)
        ->with('DCGH', $DCGH)->with('CTGH', $CTGH)->with('HTTT', $HTTT);
    }

    public function order(Request $request){
        $this->AuthLogin();
        $KH_MA = Session::get('KH_MA');

        $DCGH = DB::table('dia_chi_giao_hang')
        ->join('tinh_thanh_pho','dia_chi_giao_hang.TTP_MA','=','tinh_thanh_pho.TTP_MA')
        ->where('dia_chi_giao_hang.DCGH_MA', $request->DCGH_MA)->first();

        $now = Carbon::now('Asia/Ho_Chi_Minh');
        $date = $now->format('Y-m-d_H-i-s');

        $data = array();

        $data['HTTT_MA'] = $request->HTTT_MA;
        $data['DCGH_MA'] = $request->DCGH_MA;
        $data['TT_MA'] = 1;
        $data['DDH_NGAYDAT'] = $now;
        $data['DDH_TONGTIEN'] =  $request->DDH_TONGTIEN+$DCGH->TTP_CHIPHIGIAOHANG;
        $data['DDH_THUEVAT'] = $request->DDH_THUEVAT;

        DB::table('don_dat_hang')->insert($data);

        // Truy vấn dữ liệu
        $CTGH = DB::table('chi_tiet_gio_hang')
        ->join('sach','sach.SACH_MA','=','chi_tiet_gio_hang.SACH_MA')
        ->join('gio_hang','chi_tiet_gio_hang.GH_MA','=','gio_hang.GH_MA')
        ->join('khach_hang','khach_hang.KH_MA','=','gio_hang.KH_MA')
        ->where('khach_hang.KH_MA', $KH_MA)->get();
        
        //echo '<pre>';
        $DDH_MA=DB::table('don_dat_hang')
        ->orderby('don_dat_hang.DDH_MA','desc')->first();
        $data2 = array();
        // Lấy từng dòng và hiển thị
        $all_cart_product = DB::table('gio_hang')
        ->join('khach_hang','gio_hang.KH_MA','=','khach_hang.KH_MA')
        ->where('khach_hang.KH_MA', $KH_MA)->first();
        foreach ($CTGH as $row) {
            $data2['DDH_MA'] = $DDH_MA->DDH_MA;
            $data2['SACH_MA'] = $row->SACH_MA;
            $data2['CTDDH_SOLUONG'] = $row->CTGH_SOLUONG;
            $data2['CTDDH_DONGIA'] = $row->SACH_GIA;
            //priSACH_r ($data2);
            DB::table('chi_tiet_don_dat_hang')->insert($data2);
            DB::table('chi_tiet_gio_hang')->where('GH_MA', $all_cart_product->GH_MA)->where('SACH_MA',$row->SACH_MA)->delete();
        }

        Session::put('message','Đặt hàng thành công!');
        return Redirect::to('show-cart');
    }

    //TTìm kiếm sách trong đơn đặt hàng
    public function search_in_order(Request $request){
        $this->AuthLogin();
        $KH_MA = Session::get('KH_MA');

        $keywords = $request ->keywords_submit;
        Session::put('keyword',$request ->keywords_submit);

        $all_category_product = DB::table('the_loai_sach')->get();

        $all_DDH=  DB::table('don_dat_hang')
        ->join('trang_thai','don_dat_hang.TT_MA','=','trang_thai.TT_MA')
        ->join('chi_tiet_don_dat_hang','don_dat_hang.DDH_MA','=','chi_tiet_don_dat_hang.DDH_MA')
        ->join('sach','sach.SACH_MA','=','chi_tiet_don_dat_hang.SACH_MA')
        ->join('dia_chi_giao_hang','dia_chi_giao_hang.DCGH_MA','=','don_dat_hang.DCGH_MA')
        ->where('dia_chi_giao_hang.KH_MA', $KH_MA)
        ->where('sach.SACH_TEN', 'like', '%'.$keywords.'%')
        ->orderby('don_dat_hang.DDH_NGAYDAT','desc')->get();
        
        $group_DDH = DB::table('don_dat_hang')
        ->join('chi_tiet_don_dat_hang','don_dat_hang.DDH_MA','=','chi_tiet_don_dat_hang.DDH_MA')
        ->join('sach','sach.SACH_MA','=','chi_tiet_don_dat_hang.SACH_MA')
        ->join('dia_chi_giao_hang','dia_chi_giao_hang.DCGH_MA','=','don_dat_hang.DCGH_MA')
        ->where('dia_chi_giao_hang.KH_MA', $KH_MA)->get();

        return view('pages.cart.search_in_order')->with('category', $all_category_product)
        ->with('all_DDH', $all_DDH)->with('group_DDH', $group_DDH);
    }

    public function cancel_order($DDH_MA){
        $this->AuthLogin();
        
        $data = array();
        $data['TT_MA'] = 5;

        DB::table('don_dat_hang')->where('DDH_MA', $DDH_MA)->update($data);
        Session::put('message','Huỷ đơn hàng thành công');
        
        return Redirect::to('show-detail-bill/'.$DDH_MA);
    }
}
