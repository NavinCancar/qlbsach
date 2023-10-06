<?php
//trạng thái đơn hàng
namespace App\Http\Controllers;

use DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
session_start();

use Illuminate\Http\Request;

class trangthai extends Controller
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
    
    public function add_trangthai(){
        $this->AuthLoginChu();
        return view('admin.trangthai.add_trangthai');

    }

    public function all_trangthai(){
        $this->AuthLoginChu();
        $all_trangthai = DB::table('trang_thai')->paginate(10);
        $manager_trangthai = view('admin.trangthai.all_trangthai')->with('all_trangthai', $all_trangthai);
                
        $count_trangthai = DB::table('trang_thai')->count('TT_MA');
        Session::put('count_trangthai',$count_trangthai);
        return view('admin-layout')->with('admin.trangthai.all_trangthai', $manager_trangthai);
    }

    public function save_trangthai(Request $request){
        $this->AuthLoginChu();
        $data = array();
        $data['TT_TEN'] = $request->TT_TEN;

        //Kiểm tra unique
        $check_unique = DB::table('trang_thai')->get();
        foreach($check_unique as $key => $unique){
            if(strtolower($unique->TT_TEN)==strtolower($request->TT_TEN)){
                Session::put('message','Tên trạng thái đơn hàng không thể trùng');
                return Redirect::to('add-trangthai');
            }
        }

        DB::table('trang_thai')->insert($data);
        Session::put('message','Thêm trạng thái đơn hàng thành công');
        return Redirect::to('add-trangthai');
    }

    public function edit_trangthai($TT_MA){
        $this->AuthLoginChu();
        $edit_trangthai = DB::table('trang_thai')->where('TT_MA',$TT_MA)->get();
        $manager_trangthai = view('admin.trangthai.edit_trangthai')->with('edit_trangthai', $edit_trangthai);
        //!!!return view('admin-layout-detail')->with('admin.trangthai.edit_trangthai', $manager_trangthai);
        return view('admin-layout')->with('admin.trangthai.edit_trangthai', $manager_trangthai);
    }

    public function update_trangthai(Request $request, $TT_MA){
        $this->AuthLoginChu();
        $data = array();
        $data['TT_TEN'] = $request->TT_TEN;

        //Kiểm tra unique
        $check_unique = DB::table('trang_thai')->get();
        foreach($check_unique as $key => $unique){
            if(strtolower($unique->TT_TEN)==strtolower($request->TT_TEN)){
                Session::put('message','Tên trạng thái đơn hàng không thể trùng');
                return Redirect::to('all-trangthai');
            }
        }

        DB::table('trang_thai')->where('TT_MA',$TT_MA)->update($data);
        Session::put('message','Cập nhật trạng thái đơn hàng thành công');
        return Redirect::to('all-trangthai');
    }

    public function delete_trangthai($TT_MA){
        $this->AuthLoginChu();
        
        $checkforeign = DB::table('trang_thai')
        ->join('don_dat_hang','don_dat_hang.TT_MA','=','trang_thai.TT_MA')
        ->where('trang_thai.TT_MA',$TT_MA)->count();

        if($checkforeign != 0){
            Session::put('message','Có đơn đặt hàng thuộc trạng thái đơn hàng này, trạng thái đơn hàng này không thể xoá');
            return Redirect::to('all-trangthai');
        }

        DB::table('trang_thai')->where('TT_MA',$TT_MA)->delete();
        Session::put('message','Xóa trạng thái đơn hàng thành công');
        return Redirect::to('all-trangthai');

       
    }
}

