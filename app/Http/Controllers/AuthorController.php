<?php
//Tác giả
namespace App\Http\Controllers;

use DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
session_start();

use Illuminate\Http\Request;

class AuthorController extends Controller
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

    public function add_author(){
        $this->AuthLoginChu();
        return view('admin.author.add_author');

    }

    public function all_author(){ 
        $this->AuthLoginChu();
        $all_author = DB::table('tac_gia')->paginate(10);
        $manager_author = view('admin.author.all_author')->with('all_author', $all_author);
                
        $count_author = DB::table('tac_gia')->count('TG_MA');
        Session::put('count_author',$count_author);
        return view('admin-layout')->with('admin.author.all_author', $manager_author);
    }

    public function save_author(Request $request){
        $this->AuthLoginChu();
        $data = array();
        $data['TG_BUTDANH'] = $request->TG_BUTDANH;
        $data['TG_MOTA'] = $request->TG_MOTA;

        //Kiểm tra unique
        $check_unique = DB::table('tac_gia')->get();
        foreach($check_unique as $key => $unique){
            if(strtolower($unique->TG_BUTDANH)==strtolower($request->TG_BUTDANH)){
                Session::put('message','Tên tác giả không thể trùng');
                return Redirect::to('add-author');
            }
        }

        DB::table('tac_gia')->insert($data);
        Session::put('message','Thêm tác giả thành công');
        return Redirect::to('add-author'); 
    }

    public function edit_author($TG_MA){
        $this->AuthLoginChu();
        $edit_author = DB::table('tac_gia')->where('TG_MA',$TG_MA)->get();
        $manager_author = view('admin.author.edit_author')->with('edit_author', $edit_author);
        //!!!return view('admin-layout-detail')->with('admin.author.edit_author', $manager_author);
        return view('admin-layout')->with('admin.author.edit_author', $manager_author);
    }

    public function update_author(Request $request, $TG_MA){
        $this->AuthLoginChu();
        $data = array();
        $data['TG_BUTDANH'] = $request->TG_BUTDANH;
        $data['TG_MOTA'] = $request->TG_MOTA;

        //Kiểm tra unique
        $check_unique = DB::table('tac_gia')->get();
        foreach($check_unique as $key => $unique){
            if($unique->TG_MA!=$TG_MA && strtolower($unique->TG_BUTDANH)==strtolower($request->TG_BUTDANH)){
                Session::put('message','Tên tác giả không thể trùng');
                return Redirect::to('all-author');
            }
        }

        DB::table('tac_gia')->where('TG_MA',$TG_MA)->update($data);
        Session::put('message','Cập nhật tác giả thành công');
        return Redirect::to('all-author');
    }

    public function delete_author($TG_MA){
        $this->AuthLoginChu();
        
        $checkforeign = DB::table('tac_gia')
        ->join('cua_sach','tac_gia.TG_MA','=','cua_sach.TG_MA')
        ->where('tac_gia.TG_MA',$TG_MA)->count();

        if($checkforeign != 0){
            Session::put('message','Có sách thuộc tác giả này, tác giả này không thể xoá');
            return Redirect::to('all-author');
        }

        DB::table('tac_gia')->where('TG_MA',$TG_MA)->delete();
        Session::put('message','Xóa tác giả thành công');
        return Redirect::to('all-author');
    }
}

