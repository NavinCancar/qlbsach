<?php

namespace App\Http\Controllers;

use DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;

use Carbon\Carbon;
session_start();

use Illuminate\Http\Request;

class Chitietlonhap extends Controller 
{
/*-----------------------------------*\
  #BACKEND <FOR CHỦ CỬA HÀNG + NV KIỂM KHO>
\*-----------------------------------*/

    public function AuthLogin(){
        $NV_MA = Session::get('NV_MA');
        if($NV_MA){
            return Redirect::to('dashboard');
        }else{
            return Redirect::to('admin')->send();
        }
    }

    public function add_chitiet_lonhap($LN_MA){ 
        $this->AuthLogin(); 
        $sach = DB::table('sach')->orderby('SACH_TEN')->get(); 
        Session::put('LN_MA',$LN_MA);
        return view('admin.chitiet-lonhap.add_chitiet_lonhap')->with('sach', $sach); 
    }

    public function all_chitiet_lonhap($LN_MA){ 
        $this->AuthLogin(); 
        
        $all_chitiet_lonhap = DB::table('chi_tiet_lo_nhap')
        ->join('sach','sach.SACH_MA','=','chi_tiet_lo_nhap.SACH_MA')
        ->where('LN_MA',$LN_MA)
        ->orderby('sach.SACH_MA','desc')->get();
        Session::put('LN_MA',$LN_MA);
        $manager_chitiet_lonhap = view('admin.chitiet-lonhap.all_chitiet_lonhap')->with('all_chitiet_lonhap', $all_chitiet_lonhap);
        return view('admin-layout')->with('admin.chitiet-lonhap.all_chitiet_lonhap', $manager_chitiet_lonhap); 
    }

    public function save_chitiet_lonhap(Request $request, $LN_MA){
        $this->AuthLogin();
        $data = array();
        $data['LN_MA'] = $LN_MA; 
        $data['SACH_MA'] = $request->SACH_MA; 
        $data['CTLN_SOLUONG'] = $request->CTLN_SOLUONG; 
        $data['CTLN_GIA'] = $request->CTLN_GIA; 

        DB::table('chi_tiet_lo_nhap')->insert($data);
        Session::put('message','Thêm chi tiết lô thành công');
        return Redirect::to('all-chitiet-lonhap/'.$LN_MA);
    }

    public function edit_chitiet_lonhap($LN_MA, $SACH_MA){
        $sach = DB::table('sach')->orderby('SACH_MA')->get();
        $edit_lonhap = DB::table('chi_tiet_lo_nhap')->where('LN_MA',$LN_MA)->where('SACH_MA',$SACH_MA)->get();
        Session::put('LN_MA',$LN_MA);
        $manager_product = view('admin.chitiet-lonhap.edit_chitiet_lonhap')->with('edit_lonhap', $edit_lonhap)->with('sach',$sach);
        return view('admin-layout')->with('admin.chitiet-lonhap.edit_chitiet_lonhap', $manager_product);

    }

    public function update_chitiet_lonhap(Request $request, $LN_MA, $SACH_MA){
        $this->AuthLogin();
        $data = array(); 
        $data['CTLN_SOLUONG'] = $request->CTLN_SOLUONG; 
        $data['CTLN_GIA'] = $request->CTLN_GIA;

        DB::table('chi_tiet_lo_nhap')->where('LN_MA',$LN_MA)->where('SACH_MA',$SACH_MA)->update($data);
        Session::put('message','Cập nhật chi tiết lô nhập thành công');
        return Redirect::to('all-chitiet-lonhap/'.$LN_MA);

    }

    public function delete_chitiet_lonhap($LN_MA, $SACH_MA){
        $this->AuthLogin();
        DB::table('chi_tiet_lo_nhap')->where('LN_MA',$LN_MA)->where('SACH_MA',$SACH_MA)->delete();
        Session::put('message','Xóa chi tiết lô nhập thành công');
        return Redirect::to('all-chitiet-lonhap/'.$LN_MA);

    }
}