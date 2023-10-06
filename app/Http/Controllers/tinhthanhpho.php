<?php
//tỉnh/thành phố 
namespace App\Http\Controllers;

use DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
session_start();

use Illuminate\Http\Request;

class tinhthanhpho extends Controller
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

    public function add_tinhthanhpho(){
        $this->AuthLoginChu();
        return view('admin.tinhthanhpho.add_tinhthanhpho');

    }

    public function all_tinhthanhpho(){
        $this->AuthLoginChu();
        $all_tinhthanhpho = DB::table('tinh_thanh_pho')->paginate(10);
        $manager_tinhthanhpho = view('admin.tinhthanhpho.all_tinhthanhpho')->with('all_tinhthanhpho', $all_tinhthanhpho);
                
        $count_tinhthanhpho = DB::table('tinh_thanh_pho')->count('TTP_MA');
        Session::put('count_tinhthanhpho',$count_tinhthanhpho);
        return view('admin-layout')->with('admin.tinhthanhpho.all_tinhthanhpho', $manager_tinhthanhpho);
    }

    public function save_tinhthanhpho(Request $request){
        $this->AuthLoginChu();
        $data = array();
        $data['TTP_TEN'] = $request->TTP_TEN;
        $data['TTP_CHIPHIGIAOHANG'] = $request->TTP_CHIPHIGIAOHANG;

        //Kiểm tra unique
        $check_unique = DB::table('tinh_thanh_pho')->get();
        foreach($check_unique as $key => $unique){
            if(strtolower($unique->TTP_TEN)==strtolower($request->TTP_TEN)){
                Session::put('message','Tên tỉnh/thành phố  không thể trùng');
                return Redirect::to('add-tinhthanhpho');
            }
        }

        DB::table('tinh_thanh_pho')->insert($data);
        Session::put('message','Thêm tỉnh/thành phố thành công');
        return Redirect::to('add-tinhthanhpho');
    }

    public function edit_tinhthanhpho($TTP_MA){
        $this->AuthLoginChu();
        $edit_tinhthanhpho = DB::table('tinh_thanh_pho')->where('TTP_MA',$TTP_MA)->get();
        $manager_tinhthanhpho = view('admin.tinhthanhpho.edit_tinhthanhpho')->with('edit_tinhthanhpho', $edit_tinhthanhpho);
        //!!!return view('admin-layout-detail')->with('admin.tinhthanhpho.edit_tinhthanhpho', $manager_tinhthanhpho);
        return view('admin-layout')->with('admin.tinhthanhpho.edit_tinhthanhpho', $manager_tinhthanhpho);
    }

    public function update_tinhthanhpho(Request $request, $TTP_MA){
        $this->AuthLoginChu();
        $data = array();
        $data['TTP_TEN'] = $request->TTP_TEN;
        $data['TTP_CHIPHIGIAOHANG'] = $request->TTP_CHIPHIGIAOHANG;

        //Kiểm tra unique
        $check_unique = DB::table('tinh_thanh_pho')->get();
        foreach($check_unique as $key => $unique){
            if(strtolower($unique->TTP_TEN)==strtolower($request->TTP_TEN)){
                Session::put('message','Tên tỉnh/thành phố không thể trùng');
                return Redirect::to('all-tinhthanhpho');
            }
        }

        DB::table('tinh_thanh_pho')->where('TTP_MA',$TTP_MA)->update($data);
        Session::put('message','Cập nhật tỉnh/thành phố thành công');
        return Redirect::to('all-tinhthanhpho');
    }

    public function delete_tinhthanhpho($TTP_MA){
        $this->AuthLoginChu();
        
        $checkforeign = DB::table('tinh_thanh_pho')
        ->join('dia_chi_giao_hang','dia_chi_giao_hang.TTP_MA','=','tinh_thanh_pho.TTP_MA')
        ->where('tinh_thanh_pho.TTP_MA',$TTP_MA)->count();

        if($checkforeign != 0){
            Session::put('message','Có địa chỉ giao hàng thuộc tỉnh/thành phố này, tỉnh/thành phố này không thể xoá');
            return Redirect::to('all-tinhthanhpho');
        }

        
        DB::table('tinh_thanh_pho')->where('TTP_MA',$TTP_MA)->delete();
        Session::put('message','Xóa tỉnh/thành phố  thành công');
        return Redirect::to('all-tinhthanhpho');

       
    }
}

