<?php
//chức vụ
namespace App\Http\Controllers;

use DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
session_start();

use Illuminate\Http\Request;

class Chucvu extends Controller
{
/*-----------------------------------*\
  #BACKEND <FOR CHỦ CỬA HÀNG>
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

    public function add_chuc_vu(){
        $this->AuthLoginChu();
        return view('admin.chuc-vu.add_chuc_vu');

    }

    public function all_chuc_vu(){ 
        $this->AuthLoginChu();
        $all_chuc_vu = DB::table('chuc_vu')->paginate(10);
        $manager_chuc_vu = view('admin.chuc-vu.all_chuc_vu')->with('all_chuc_vu', $all_chuc_vu);
        return view('admin-layout')->with('admin.chuc-vu.all_chuc_vu', $manager_chuc_vu);
    }

    public function save_chuc_vu(Request $request){
        $this->AuthLoginChu();
        $data = array();
        $data['CV_TEN'] = $request->CV_TEN;

        //Kiểm tra unique
        $check_unique = DB::table('chuc_vu')->get();
        foreach($check_unique as $key => $unique){
            if(strtolower($unique->CV_TEN)==strtolower($request->CV_TEN)){
                Session::put('message','Tên chức vụ không thể trùng');
                return Redirect::to('add-chuc-vu');
            }
        }

        DB::table('chuc_vu')->insert($data);
        Session::put('message','Thêm chức vụ thành công');
        return Redirect::to('add-chuc-vu');
    }

    public function edit_chuc_vu($CV_MA){
        $this->AuthLoginChu();
        $edit_chuc_vu = DB::table('chuc_vu')->where('CV_MA',$CV_MA)->get();
        $manager_chuc_vu = view('admin.chuc-vu.edit_chuc_vu')->with('edit_chuc_vu', $edit_chuc_vu);
        //!!!return view('admin-layout-detail')->with('admin.chuc-vu.edit_chuc_vu', $manager_chuc_vu);
        return view('admin-layout')->with('admin.chuc-vu.edit_chuc_vu', $manager_chuc_vu);
    }

    public function update_chuc_vu(Request $request, $CV_MA){
        $this->AuthLoginChu();
        $data = array();
        $data['CV_TEN'] = $request->CV_TEN;

        //Kiểm tra unique
        $check_unique = DB::table('chuc_vu')->get();
        foreach($check_unique as $key => $unique){
            if(strtolower($unique->CV_TEN)==strtolower($request->CV_TEN)){
                Session::put('message','Tên chức vụ không thể trùng');
                return Redirect::to('all-chuc-vu');
            }
        }

        DB::table('chuc_vu')->where('CV_MA',$CV_MA)->update($data);
        Session::put('message','Cập nhật chức vụ thành công');
        return Redirect::to('all-chuc-vu');
    }

    public function delete_chuc_vu($CV_MA){
        $this->AuthLoginChu();
        
        $checkforeign = DB::table('chuc_vu')
        ->join('nhan_vien','chuc_vu.CV_MA','=','nhan_vien.CV_MA')
        ->where('chuc_vu.CV_MA',$CV_MA)->count();

        if($checkforeign != 0){
            Session::put('message','Có nhân viên thuộc chức vụ này, chức vụ này không thể xoá');
            return Redirect::to('all-chuc-vu');
        }

        DB::table('chuc_vu')->where('CV_MA',$CV_MA)->delete();
        Session::put('message','Xóa chức vụ thành công');
        return Redirect::to('all-chuc-vu');
    }
}

