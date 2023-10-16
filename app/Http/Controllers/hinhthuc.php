<?php
//Hình thức thanh toán
namespace App\Http\Controllers;

use DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
session_start();

use Illuminate\Http\Request;

class hinhthuc extends Controller
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
    
    public function add_hinhthuc(){
        $this->AuthLoginChu();
        return view('admin.hinhthuc.add_hinhthuc');

    }

    public function all_hinhthuc(){
        $this->AuthLoginChu();
        $all_hinhthuc = DB::table('hinh_thuc_thanh_toan')->paginate(10);
        $manager_hinhthuc = view('admin.hinhthuc.all_hinhthuc')->with('all_hinhthuc', $all_hinhthuc);
                
        $count_hinhthuc = DB::table('hinh_thuc_thanh_toan')->count('HTTT_MA');
        Session::put('count_hinhthuc',$count_hinhthuc);
        return view('admin-layout')->with('admin.hinhthuc.all_hinhthuc', $manager_hinhthuc);
    }

    public function save_hinhthuc(Request $request){
        $this->AuthLoginChu();
        $data = array();
        $data['HTTT_TEN'] = $request->HTTT_TEN;

        //Kiểm tra unique
        $check_unique = DB::table('hinh_thuc_thanh_toan')->get();
        foreach($check_unique as $key => $unique){
            if(strtolower($unique->HTTT_TEN)==strtolower($request->HTTT_TEN)){
                Session::put('message','Tên hình thức thanh toán không thể trùng');
                return Redirect::to('add-hinhthuc');
            }
        }

        DB::table('hinh_thuc_thanh_toan')->insert($data);
        Session::put('message','Thêm hình thức thanh toán thành công');
        return Redirect::to('add-hinhthuc');
    }

    public function edit_hinhthuc($HTTT_MA){
        $this->AuthLoginChu();
        $edit_hinhthuc = DB::table('hinh_thuc_thanh_toan')->where('HTTT_MA',$HTTT_MA)->get();
        $manager_hinhthuc = view('admin.hinhthuc.edit_hinhthuc')->with('edit_hinhthuc', $edit_hinhthuc);
        //!!!return view('admin-layout-detail')->with('admin.hinhthuc.edit_hinhthuc', $manager_hinhthuc);
        return view('admin-layout')->with('admin.hinhthuc.edit_hinhthuc', $manager_hinhthuc);
    }

    public function update_hinhthuc(Request $request, $HTTT_MA){
        $this->AuthLoginChu();
        $data = array();
        $data['HTTT_TEN'] = $request->HTTT_TEN;

        //Kiểm tra unique
        $check_unique = DB::table('hinh_thuc_thanh_toan')->get();
        foreach($check_unique as $key => $unique){
            if($unique->HTTT_MA!=$HTTT_MA && strtolower($unique->HTTT_TEN)==strtolower($request->HTTT_TEN)){
                Session::put('message','Tên hình thức thanh toán không thể trùng');
                return Redirect::to('all-hinhthuc');
            }
        }

        DB::table('hinh_thuc_thanh_toan')->where('HTTT_MA',$HTTT_MA)->update($data);
        Session::put('message','Cập nhật hình thức thanh toán thành công');
        return Redirect::to('all-hinhthuc');
    }

    public function delete_hinhthuc($HTTT_MA){
        $this->AuthLoginChu();
        
        $checkforeign = DB::table('hinh_thuc_thanh_toan')
        ->join('don_dat_hang','don_dat_hang.HTTT_MA','=','hinh_thuc_thanh_toan.HTTT_MA')
        ->where('hinh_thuc_thanh_toan.HTTT_MA',$HTTT_MA)->count();

        if($checkforeign != 0){
            Session::put('message','Có đơn đặt hàng thuộc hình thức thanh toán này, hình thức thanh toán này không thể xoá');
            return Redirect::to('all-hinhthuc');
        }

        //KHOA KHUM HIỂU, CÓ DÍNH FK
        DB::table('hinh_thuc_thanh_toan')->where('HTTT_MA',$HTTT_MA)->delete();
        Session::put('message','Xóa hình thức thanh toán thành công');
        return Redirect::to('all-hinhthuc');

       
    }
}

