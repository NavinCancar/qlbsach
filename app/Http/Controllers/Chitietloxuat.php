<?php

namespace App\Http\Controllers;

use DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;

use Carbon\Carbon;
session_start();

use Illuminate\Http\Request;

class Chitietloxuat extends Controller 
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

    public function add_chitiet_loxuat($LX_MA){ 
        $this->AuthLogin(); 
        $sach = DB::table('sach')->orderby('SACH_TEN')->get(); 
        Session::put('LX_MA',$LX_MA);
        return view('admin.chitiet-loxuat.add_chitiet_loxuat')->with('sach', $sach); 
    }

    public function all_chitiet_loxuat($LX_MA){ 
        $this->AuthLogin(); 
        
        $all_chitiet_loxuat = DB::table('chi_tiet_lo_xuat')
        ->join('sach','sach.SACH_MA','=','chi_tiet_lo_xuat.SACH_MA')
        ->where('LX_MA',$LX_MA)
        ->orderby('sach.SACH_MA','desc')->get();
        Session::put('LX_MA',$LX_MA);
        $manager_chitiet_loxuat = view('admin.chitiet-loxuat.all_chitiet_loxuat')->with('all_chitiet_loxuat', $all_chitiet_loxuat);
        return view('admin-layout')->with('admin.chitiet-loxuat.all_chitiet_loxuat', $manager_chitiet_loxuat); 
    }

    public function save_chitiet_loxuat(Request $request, $LX_MA){
        $this->AuthLogin();
        $data = array();
        $data['LX_MA'] = $LX_MA; 
        $data['SACH_MA'] = $request->SACH_MA; 
        $data['CTLX_SOLUONG'] = $request->CTLX_SOLUONG; 
        $data['CTLX_GIA'] = $request->CTLX_GIA; 

        DB::table('chi_tiet_lo_xuat')->insert($data);
        Session::put('message','Thêm chi tiết lô thành công');
        return Redirect::to('all-chitiet-loxuat/'.$LX_MA);
    }

    public function edit_chitiet_loxuat($LX_MA, $SACH_MA){
        $sach = DB::table('sach')->orderby('SACH_MA')->get();
        $edit_loxuat = DB::table('chi_tiet_lo_xuat')->where('LX_MA',$LX_MA)->where('SACH_MA',$SACH_MA)->get();
        Session::put('LX_MA',$LX_MA);
        $manager_product = view('admin.chitiet-loxuat.edit_chitiet_loxuat')->with('edit_loxuat', $edit_loxuat)->with('sach',$sach);
        return view('admin-layout')->with('admin.chitiet-loxuat.edit_chitiet_loxuat', $manager_product);

    }

    public function update_chitiet_loxuat(Request $request, $LX_MA, $SACH_MA){
        $this->AuthLogin();
        $data = array(); 
        $data['CTLX_SOLUONG'] = $request->CTLX_SOLUONG; 
        $data['CTLX_GIA'] = $request->CTLX_GIA;

        DB::table('chi_tiet_lo_xuat')->where('LX_MA',$LX_MA)->where('SACH_MA',$SACH_MA)->update($data);
        Session::put('message','Cập nhật chi tiết lô xuất thành công');
        return Redirect::to('all-chitiet-loxuat/'.$LX_MA);

    }

    public function delete_chitiet_loxuat($LX_MA, $SACH_MA){
        $this->AuthLogin();
        DB::table('chi_tiet_lo_xuat')->where('LX_MA',$LX_MA)->where('SACH_MA',$SACH_MA)->delete();
        Session::put('message','Xóa chi tiết lô xuất thành công');
        return Redirect::to('all-chitiet-loxuat/'.$LX_MA);

    }
}