<?php
//nhà xuất bản 
namespace App\Http\Controllers;

use DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
session_start();

use Illuminate\Http\Request;

class nhaxuatban extends Controller
{

// /*-----------------------------------*\
//   #FRONTEND
// \*-----------------------------------*/

//     // Danh mục sản phẩm trang chủ
//     public function show_nhaxuatban_home($NXB_MA){ ///
//         $all_nhaxuatban = DB::table('nha_xuat_ban')->get();

//         $nhaxuatban_by_id = DB::table('sach')
//         ->join('thuoc_the_loai', 'sach.SACH_MA', '=', 'thuoc_the_loai.SACH_MA')
//         ->join('nha_xuat_ban', 'nha_xuat_ban.NXB_MA', '=', 'thuoc_the_loai.NXB_MA')
//         ->orderby('sach.SACH_NGAYTAO','desc')->where('nha_xuat_ban.NXB_MA', $NXB_MA)->paginate(16);

//         $nhaxuatban_name = DB::table('nha_xuat_ban')->where('nha_xuat_ban.NXB_MA', $NXB_MA )->get();

//         return view('pages.nhaxuatban.show_nhaxuatban')->with('nhaxuatban', $all_nhaxuatban)
//         ->with('nhaxuatban_by_id', $nhaxuatban_by_id)->with('nhaxuatban_name', $nhaxuatban_name);
//     }

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


    
    public function add_nhaxuatban(){
        $this->AuthLoginChu();
        return view('admin.nhaxuatban.add_nhaxuatban');

    }

    public function all_nhaxuatban(){
        $this->AuthLoginChu();
        $all_nhaxuatban = DB::table('nha_xuat_ban')->paginate(10);
        $manager_nhaxuatban = view('admin.nhaxuatban.all_nhaxuatban')->with('all_nhaxuatban', $all_nhaxuatban);
                
        $count_nhaxuatban = DB::table('nha_xuat_ban')->count('NXB_MA');
        Session::put('count_nhaxuatban',$count_nhaxuatban);
        return view('admin-layout')->with('admin.nhaxuatban.all_nhaxuatban', $manager_nhaxuatban);
    }

    public function save_nhaxuatban(Request $request){
        $this->AuthLoginChu();
        $data = array();
        $data['NXB_TEN'] = $request->NXB_TEN;
        $data['NXB_SODIENTHOAI'] = $request->NXB_SODIENTHOAI;
        $data['NXB_DIACHI'] = $request->NXB_DIACHI;
        $data['NXB_EMAIL'] = $request->NXB_EMAIL;

        //Kiểm tra unique
        $check_unique = DB::table('nha_xuat_ban')->get();
        foreach($check_unique as $key => $unique){
            if(strtolower($unique->NXB_TEN)==strtolower($request->NXB_TEN)){
                Session::put('message','Tên nhà xuất bản không thể trùng');
                return Redirect::to('add-nhaxuatban');
            }
        }

        DB::table('nha_xuat_ban')->insert($data);
        Session::put('message','Thêm nhà xuất bản thành công');
        return Redirect::to('add-nhaxuatban');
    }

    public function edit_nhaxuatban($NXB_MA){
        $this->AuthLoginChu();
        $edit_nhaxuatban = DB::table('nha_xuat_ban')->where('NXB_MA',$NXB_MA)->get();
        $manager_nhaxuatban = view('admin.nhaxuatban.edit_nhaxuatban')->with('edit_nhaxuatban', $edit_nhaxuatban);
        //!!!return view('admin-layout-detail')->with('admin.nhaxuatban.edit_nhaxuatban', $manager_nhaxuatban);
        return view('admin-layout')->with('admin.nhaxuatban.edit_nhaxuatban', $manager_nhaxuatban);
    }

    public function update_nhaxuatban(Request $request, $NXB_MA){
        $this->AuthLoginChu();
        $data = array();
        $data['NXB_TEN'] = $request->NXB_TEN;
        $data['NXB_SODIENTHOAI'] = $request->NXB_SODIENTHOAI;
        $data['NXB_DIACHI'] = $request->NXB_DIACHI;
        $data['NXB_EMAIL'] = $request->NXB_EMAIL;
        //Kiểm tra unique
        $check_unique = DB::table('nha_xuat_ban')->get();
        foreach($check_unique as $key => $unique){
            if(strtolower($unique->NXB_TEN)==strtolower($request->NXB_TEN)){
                Session::put('message','Tên nhà xuất bản không thể trùng');
                return Redirect::to('all-nhaxuatban');
            }
        }

        DB::table('nha_xuat_ban')->where('NXB_MA',$NXB_MA)->update($data);
        Session::put('message','Cập nhật nhà xuất bản thành công');
        return Redirect::to('all-nhaxuatban');
    }

    public function delete_nhaxuatban($NXB_MA){
        $this->AuthLoginChu();
        
        $checkforeign = DB::table('nha_xuat_ban')
        ->join('sach','sach.NXB_MA','=','nha_xuat_ban.NXB_MA')
        ->where('nha_xuat_ban.NXB_MA',$NXB_MA)->count();

        if($checkforeign != 0){
            Session::put('message','Có sách thuộc nhà xuất bản này, nhà xuất bản này không thể xoá');
            return Redirect::to('all-nhaxuatban');
        }

        
        DB::table('nha_xuat_ban')->where('NXB_MA',$NXB_MA)->delete();
        Session::put('message','Xóa nhà xuất bản  thành công');
        return Redirect::to('all-nhaxuatban');

       
    }
}

