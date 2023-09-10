<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
session_start();

class HomeController extends Controller
{
    
/*-----------------------------------*\
  #ONLY FRONTEND
\*-----------------------------------*/

    public function index(){ ///ok
        $all_category_product = DB::table('the_loai_sach')->get();

        $new_product = DB::table('sach')->orderby('sach.SACH_NGAYTAO','desc')->limit(8)->get();

        $hot_product = DB::table('sach')
        ->join(DB::raw('(select `sach`.`SACH_MA`, sum(`chi_tiet_don_dat_hang`.`CTDDH_SOLUONG`) as soluongban from `sach` 
                        inner join `chi_tiet_don_dat_hang` on `chi_tiet_don_dat_hang`.`SACH_MA` = `sach`.`SACH_MA` 
                        inner join `don_dat_hang` on `don_dat_hang`.`DDH_MA` = `chi_tiet_don_dat_hang`.`DDH_MA` 
                        where `don_dat_hang`.`TT_MA` != 5 group by `sach`.`SACH_MA`) j'), 
                'j.SACH_MA', '=', 'sach.SACH_MA')
        ->orderby('soluongban','desc')->limit(8)->get();

        return view('pages.home')->with('category', $all_category_product)->with('hot_product', $hot_product)->with('new_product', $new_product);
    }

    public function all_product(){ ///ok
        $all_category_product = DB::table('the_loai_sach')->get();

        $all_product = DB::table('sach')->orderby('sach.SACH_NGAYTAO','desc')->paginate(16);
        return view('pages.show-all-product')->with('category', $all_category_product)->with('all_product', $all_product);
    }
    
    //Tìm kiếm sản phẩm
    public function search(Request $request){ ///ok
        $keyword = $request ->keyword;
        Session::put('keyword',$keyword);

        $all_category_product = DB::table('the_loai_sach')->get();

        $search_product = DB::table('sach')
        ->join('nha_xuat_ban','nha_xuat_ban.NXB_MA','=','sach.NXB_MA')
        ->join('cua_sach', 'sach.SACH_MA', '=', 'cua_sach.SACH_MA')
        ->join('tac_gia', 'tac_gia.TG_MA', '=', 'cua_sach.TG_MA')
        ->where('sach.SACH_TEN', 'like', '%'.$keyword.'%')
        ->orWhere('sach.SACH_MOTA', 'like', '%'.$keyword.'%')
        ->orWhere('nha_xuat_ban.NXB_TEN', 'like', '%'.$keyword.'%')
        ->orWhere('tac_gia.TG_BUTDANH', 'like', '%'.$keyword.'%')->get();

        return view('pages.product.search')->with('category', $all_category_product)
        ->with('search_product', $search_product);
    }
}
