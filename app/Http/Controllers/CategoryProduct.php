<?php
//Thể loại sách
namespace App\Http\Controllers;

use DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
session_start();

use Illuminate\Http\Request;

class CategoryProduct extends Controller
{

/*-----------------------------------*\
  #FRONTEND
\*-----------------------------------*/

    // Danh mục sản phẩm trang chủ
    public function show_category_home($TLS_MA){ ///ok
        $all_category_product = DB::table('the_loai_sach')->get();

        $category_by_id = DB::table('sach')
        ->join('thuoc_the_loai', 'sach.SACH_MA', '=', 'thuoc_the_loai.SACH_MA')
        ->join('the_loai_sach', 'the_loai_sach.TLS_MA', '=', 'thuoc_the_loai.TLS_MA')
        ->orderby('sach.SACH_NGAYTAO','desc')->where('the_loai_sach.TLS_MA', $TLS_MA)->paginate(16);

        $category_name = DB::table('the_loai_sach')->where('the_loai_sach.TLS_MA', $TLS_MA )->get();

        return view('pages.category.show_category')->with('category', $all_category_product)
        ->with('category_by_id', $category_by_id)->with('category_name', $category_name);
    }

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

    public function add_category_product(){
        $this->AuthLoginChu();
        return view('admin.add_category_product');

    }

    public function all_category_product(){ //Hien thi tat ca
        $this->AuthLoginChu();
        $all_category_product = DB::table('the_loai_sach')->paginate(10);
        $manager_category_product = view('admin.all_category_product')->with('all_category_product', $all_category_product);
                
        $count_category_product = DB::table('the_loai_sach')->count('TLS_MA');
        Session::put('count_category_product',$count_category_product);
        return view('admin-layout')->with('admin.all_category_product', $manager_category_product);
    }

    public function save_category_product(Request $request){
        $this->AuthLoginChu();
        $data = array();
        $data['TLS_TEN'] = $request->TLS_TEN;

        //Kiểm tra unique
        $check_unique = DB::table('the_loai_sach')->get();
        foreach($check_unique as $key => $unique){
            if(strtolower($unique->TLS_TEN)==strtolower($request->TLS_TEN)){
                Session::put('message','Tên thể loại sách không thể trùng');
                return Redirect::to('add-category-product');
            }
        }

        DB::table('the_loai_sach')->insert($data);
        Session::put('message','Thêm thể loại sách thành công');
        return Redirect::to('add-category-product');
    }

    public function edit_category_product($TLS_MA){
        $this->AuthLoginChu();
        $edit_category_product = DB::table('the_loai_sach')->where('TLS_MA',$TLS_MA)->get();
        $manager_category_product = view('admin.edit_category_product')->with('edit_category_product', $edit_category_product);
        //!!!return view('admin-layout-detail')->with('admin.edit_category_product', $manager_category_product);
        return view('admin-layout')->with('admin.edit_category_product', $manager_category_product);
    }

    public function update_category_product(Request $request, $TLS_MA){
        $this->AuthLoginChu();
        $data = array();
        $data['TLS_TEN'] = $request->TLS_TEN;

        //Kiểm tra unique
        $check_unique = DB::table('the_loai_sach')->get();
        foreach($check_unique as $key => $unique){
            if(strtolower($unique->TLS_TEN)==strtolower($request->TLS_TEN)){
                Session::put('message','Tên thể loại sách không thể trùng');
                return Redirect::to('all-category-product');
            }
        }

        DB::table('the_loai_sach')->where('TLS_MA',$TLS_MA)->update($data);
        Session::put('message','Cập nhật thể loại sách thành công');
        return Redirect::to('all-category-product');
    }

    public function delete_category_product($TLS_MA){
        $this->AuthLoginChu();
        
        $checkforeign = DB::table('the_loai_sach')
        ->join('thuoc_the_loai','the_loai_sach.TLS_MA','=','thuoc_the_loai.TLS_MA')
        ->join('sach','thuoc_the_loai.SACH_MA','=','sach.SACH_MA')
        ->where('the_loai_sach.TLS_MA',$TLS_MA)->count();

        if($checkforeign != 0){
            Session::put('message','Có sách thuộc thể loại sách này, thể loại sách này không thể xoá');
            return Redirect::to('all-category-product');
        }

        DB::table('the_loai_sach')->where('TLS_MA',$TLS_MA)->delete();
        Session::put('message','Xóa thể loại sách thành công');
        return Redirect::to('all-category-product');
    }
}

