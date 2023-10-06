<?php
//lô nhập
namespace App\Http\Controllers;

use DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
session_start();

use Illuminate\Http\Request;

class Lonhap extends Controller
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

    public function add_lo_nhap(){
        $this->AuthLogin();
        $all_nhan_vien = DB::table('nhan_vien')->get();
        return view('admin.lo-nhap.add_lo_nhap')->with('all_nhan_vien', $all_nhan_vien);

    }

    public function all_lo_nhap(){
        $this->AuthLogin();
        $all_lo_nhap = DB::table('lo_nhap')
        ->join('nhan_vien','lo_nhap.NV_MA','=','nhan_vien.NV_MA')
        ->orderby('LN_MA','desc')
        ->paginate(10);
        $manager_lo_nhap = view('admin.lo-nhap.all_lo_nhap')->with('all_lo_nhap', $all_lo_nhap);
                
        return view('admin-layout')->with('admin.lo-nhap.all_lo_nhap', $manager_lo_nhap);
    }

    public function save_lo_nhap(Request $request){
        $this->AuthLogin();
        $data = array();
        $data['NV_MA'] = $request->NV_MA;
        $data['LN_NGAYNHAP'] = $request->LN_NGAYNHAP;
        $data['LN_NOIDUNG'] = $request->LN_NOIDUNG;

        DB::table('lo_nhap')->insert($data);
        Session::put('message','Thêm lô nhập thành công');
        return Redirect::to('add-lo-nhap');
    }

    public function edit_lo_nhap($LN_MA){
        $this->AuthLogin();
        $edit_lo_nhap = DB::table('lo_nhap')->where('LN_MA',$LN_MA)->get();
        $all_nhan_vien = DB::table('nhan_vien')->get();
        $manager_lo_nhap = view('admin.lo-nhap.edit_lo_nhap')->with('edit_lo_nhap', $edit_lo_nhap)->with('all_nhan_vien', $all_nhan_vien);;
        //!!!return view('admin-layout-detail')->with('admin.lo-nhap.edit_lo_nhap', $manager_lo_nhap);
        return view('admin-layout')->with('admin.lo-nhap.edit_lo_nhap', $manager_lo_nhap);
    }

    public function update_lo_nhap(Request $request, $LN_MA){
        $this->AuthLogin();
        $data = array();
        $data['NV_MA'] = $request->NV_MA;
        $data['LN_NGAYNHAP'] = $request->LN_NGAYNHAP;
        $data['LN_NOIDUNG'] = $request->LN_NOIDUNG;

        DB::table('lo_nhap')->where('LN_MA',$LN_MA)->update($data);
        Session::put('message','Cập nhật lô nhập thành công');
        return Redirect::to('all-lo-nhap');
    }

    public function delete_lo_nhap($LN_MA){
        $this->AuthLogin();
        
        $checkforeign = DB::table('lo_nhap')
        ->join('chi_tiet_lo_nhap','lo_nhap.LN_MA','=','chi_tiet_lo_nhap.LN_MA')
        ->where('lo_nhap.LN_MA',$LN_MA)->count();

        if($checkforeign != 0){
            Session::put('message','Có sách thuộc lô nhập này, lô nhập này không thể xoá');
            return Redirect::to('all-lo-nhap');
        }

        DB::table('lo_nhap')->where('LN_MA',$LN_MA)->delete();
        Session::put('message','Xóa lô nhập thành công');
        return Redirect::to('all-lo-nhap');
    }
}

