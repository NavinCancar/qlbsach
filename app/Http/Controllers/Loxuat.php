<?php
//lô xuất
namespace App\Http\Controllers;

use DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
session_start();

use Illuminate\Http\Request;

class Loxuat extends Controller
{

/*-----------------------------------*\
  #BACKEND <FOR CHỦ CỬA HÀNG + KIỂM KHO>
\*-----------------------------------*/

    public function AuthLogin(){
        $NV_MA = Session::get('NV_MA');
        $CV_MA = DB::table('nhan_vien')->where('NV_MA',$NV_MA)->first();
        if($NV_MA){
            if($CV_MA->CV_MA != 1 && $CV_MA->CV_MA != 2){
                return Redirect::to('dashboard')->send();
            }
        }else{
            return Redirect::to('admin')->send();
        }
    }

    public function add_lo_xuat(){
        $this->AuthLogin();
        $all_nhan_vien = DB::table('nhan_vien')->get();
        return view('admin.lo-xuat.add_lo_xuat')->with('all_nhan_vien', $all_nhan_vien);

    }

    public function all_lo_xuat(){
        $this->AuthLogin();
        $all_lo_xuat = DB::table('lo_xuat')
        ->join('nhan_vien','lo_xuat.NV_MA','=','nhan_vien.NV_MA')
        ->orderby('LX_MA','desc')
        ->paginate(10);
        $manager_lo_xuat = view('admin.lo-xuat.all_lo_xuat')->with('all_lo_xuat', $all_lo_xuat);
                
        return view('admin-layout')->with('admin.lo-xuat.all_lo_xuat', $manager_lo_xuat);
    }

    public function save_lo_xuat(Request $request){
        $this->AuthLogin();
        $data = array();
        $data['NV_MA'] = $request->NV_MA;
        $data['LX_NGAYXUAT'] = $request->LX_NGAYXUAT;
        $data['LX_NOIDUNG'] = $request->LX_NOIDUNG;

        DB::table('lo_xuat')->insert($data);
        Session::put('message','Thêm lô xuất thành công');
        return Redirect::to('add-lo-xuat');
    }

    public function edit_lo_xuat($LX_MA){
        $this->AuthLogin();
        $edit_lo_xuat = DB::table('lo_xuat')->where('LX_MA',$LX_MA)->get();
        $all_nhan_vien = DB::table('nhan_vien')->get();
        $manager_lo_xuat = view('admin.lo-xuat.edit_lo_xuat')->with('edit_lo_xuat', $edit_lo_xuat)->with('all_nhan_vien', $all_nhan_vien);;
        //!!!return view('admin-layout-detail')->with('admin.lo-xuat.edit_lo_xuat', $manager_lo_xuat);
        return view('admin-layout')->with('admin.lo-xuat.edit_lo_xuat', $manager_lo_xuat);
    }

    public function update_lo_xuat(Request $request, $LX_MA){
        $this->AuthLogin();
        $data = array();
        $data['NV_MA'] = $request->NV_MA;
        $data['LX_NGAYXUAT'] = $request->LX_NGAYXUAT;
        $data['LX_NOIDUNG'] = $request->LX_NOIDUNG;

        DB::table('lo_xuat')->where('LX_MA',$LX_MA)->update($data);
        Session::put('message','Cập nhật lô xuất thành công');
        return Redirect::to('all-lo-xuat');
    }

    public function delete_lo_xuat($LX_MA){
        $this->AuthLogin();
        
        $checkforeign = DB::table('lo_xuat')
        ->join('chi_tiet_lo_xuat','lo_xuat.LX_MA','=','chi_tiet_lo_xuat.LX_MA')
        ->where('lo_xuat.LX_MA',$LX_MA)->count();

        if($checkforeign != 0){
            Session::put('message','Có sách thuộc lô xuất này, lô xuất này không thể xoá');
            return Redirect::to('all-lo-xuat');
        }

        DB::table('lo_xuat')->where('LX_MA',$LX_MA)->delete();
        Session::put('message','Xóa lô xuất thành công');
        return Redirect::to('all-lo-xuat');
    }
}

