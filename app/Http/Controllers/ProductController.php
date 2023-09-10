<?php

namespace App\Http\Controllers;

use DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;

use Carbon\Carbon;
session_start();

use Illuminate\Http\Request;

class ProductController extends Controller
{

/*-----------------------------------*\
  #FRONTEND
\*-----------------------------------*/

    //Chi Tiet San Pham
    public function detail_product($SACH_MA){
        $all_category_product = DB::table('the_loai_sach')->get();

        $details_product = DB::table('sach')
        ->join('nha_xuat_ban','nha_xuat_ban.NXB_MA','=','sach.NXB_MA')
        ->where('sach.SACH_MA', $SACH_MA)->get();

        $category_product = DB::table('sach')
        ->join('thuoc_the_loai', 'sach.SACH_MA', '=', 'thuoc_the_loai.SACH_MA')
        ->join('the_loai_sach', 'the_loai_sach.TLS_MA', '=', 'thuoc_the_loai.TLS_MA')
        ->where('sach.SACH_MA', $SACH_MA)->get();

        $author_product = DB::table('sach')
        ->join('cua_sach', 'sach.SACH_MA', '=', 'cua_sach.SACH_MA')
        ->join('tac_gia', 'tac_gia.TG_MA', '=', 'cua_sach.TG_MA')
        ->where('sach.SACH_MA', $SACH_MA)->get();

        foreach($category_product as $key => $value){
            $TLS_MA = $value->TLS_MA;
        }

        $related_product = DB::table('sach')
        ->join('nha_xuat_ban','nha_xuat_ban.NXB_MA','=','sach.NXB_MA')
        ->join('thuoc_the_loai', 'sach.SACH_MA', '=', 'thuoc_the_loai.SACH_MA')
        ->join('the_loai_sach', 'the_loai_sach.TLS_MA', '=', 'thuoc_the_loai.TLS_MA')
        ->join('cua_sach', 'sach.SACH_MA', '=', 'cua_sach.SACH_MA')
        ->join('tac_gia', 'tac_gia.TG_MA', '=', 'cua_sach.TG_MA')
        ->where('the_loai_sach.TLS_MA', $TLS_MA)
        ->whereNotIn('sach.SACH_MA', [$SACH_MA])
        ->limit(4)->get();

        //Show đánh giá cũ
        $danh_gia = DB::table('danh_gia')
        ->join('khach_hang','khach_hang.KH_MA','=','danh_gia.KH_MA')
        ->where('SACH_MA', $SACH_MA)->orderby('DG_MA','desc')->get();

        $countdg = DB::table('danh_gia')
        ->join('khach_hang','khach_hang.KH_MA','=','danh_gia.KH_MA')
        ->where('SACH_MA', $SACH_MA)->count();

        Session::put('countdg',$countdg);

        //Cho phép nhập đánh giá mới
        $KH_MA = Session::get('KH_MA');
        Session::put('kh',$KH_MA);
        
        $binh_luan=  DB::table('khach_hang')
        ->join('dia_chi_giao_hang','dia_chi_giao_hang.KH_MA','=','khach_hang.KH_MA')
        ->join('don_dat_hang','dia_chi_giao_hang.DCGH_MA','=','don_dat_hang.DCGH_MA')
        ->join('chi_tiet_don_dat_hang','chi_tiet_don_dat_hang.DDH_MA','=','don_dat_hang.DDH_MA')
        ->where('TT_MA', 4)->where('SACH_MA', $SACH_MA)->get();
        
        //Số lượng tồn

        $ddh = DB::table('chi_tiet_don_dat_hang')
            ->join('don_dat_hang','chi_tiet_don_dat_hang.DDH_MA','=','don_dat_hang.DDH_MA')
            ->where('TT_MA', '!=', 5)
            ->where('SACH_MA', $SACH_MA)->sum('CTDDH_SOLUONG');
        Session::put('ban',$ddh);

        $nhap = DB::table('chi_tiet_lo_nhap')
            ->where('SACH_MA', $SACH_MA)->sum('CTLN_SOLUONG');
        $xuat = DB::table('chi_tiet_lo_xuat')
            ->where('SACH_MA', $SACH_MA)->sum('CTLX_SOLUONG');

        Session::put('ton',$nhap-$xuat-$ddh);

        return view('pages.product.show_details_product')->with('category', $all_category_product)
        ->with('product_detail', $details_product)
        ->with('product_relate', $related_product)
        ->with('category_product', $category_product)
        ->with('author_product', $author_product)
        ->with('binh_luan', $binh_luan)
        ->with('danh_gia', $danh_gia);
    }

    public function danh_gia(Request $request, $SACH_MA){ ///ok //ONLY KHÁCH THÀNH VIÊN NHƯNG GIỚI HẠN TRONG CODE
        //Cho phép nhập đánh giá mới
        $KH_MA = Session::get('KH_MA');
        $check= DB::table('danh_gia')->where('KH_MA',$KH_MA)->where('SACH_MA',$SACH_MA)->delete();
        
        $data = array();
        //$data['SACH_MA'] = $request->product_desc;
        $data['KH_MA'] = $KH_MA;
        $data['SACH_MA'] = $SACH_MA;
        $data['DG_NOIDUNG'] = $request->DG_NOIDUNG;
        $data['DG_DIEM'] = $request->DG_DIEM;
        $data['DG_THOIGIAN'] =  Carbon::now('Asia/Ho_Chi_Minh');
        DB::table('danh_gia')->insert($data);
        Session::put('message','Đánh giá sách thành công');
        return Redirect::to('chi-tiet-san-pham/'.$SACH_MA);
    }
    
}
