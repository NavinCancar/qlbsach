<?php

namespace App\Http\Controllers;

use DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;

use Carbon\Carbon;
session_start();

use Illuminate\Http\Request;

class ProductController extends Controller
{

/*-----------------------------------*\
  #FRONTEND
\*-----------------------------------*/

    //Chi Tiet San Pham
    public function detail_product($SACH_MA){
        $all_category_product = DB::table('the_loai_sach')->get();

        $details_product = DB::table('sach')
        ->join('nha_xuat_ban','nha_xuat_ban.NXB_MA','=','sach.NXB_MA')
        ->where('sach.SACH_MA', $SACH_MA)->get();

        $category_product = DB::table('sach')
        ->join('thuoc_the_loai', 'sach.SACH_MA', '=', 'thuoc_the_loai.SACH_MA')
        ->join('the_loai_sach', 'the_loai_sach.TLS_MA', '=', 'thuoc_the_loai.TLS_MA')
        ->where('sach.SACH_MA', $SACH_MA)->get();

        $author_product = DB::table('sach')
        ->join('cua_sach', 'sach.SACH_MA', '=', 'cua_sach.SACH_MA')
        ->join('tac_gia', 'tac_gia.TG_MA', '=', 'cua_sach.TG_MA')
        ->where('sach.SACH_MA', $SACH_MA)->get();

        foreach($category_product as $key => $value){
            $TLS_MA = $value->TLS_MA;
        }

        $related_product = DB::table('sach')
        ->join('nha_xuat_ban','nha_xuat_ban.NXB_MA','=','sach.NXB_MA')
        ->join('thuoc_the_loai', 'sach.SACH_MA', '=', 'thuoc_the_loai.SACH_MA')
        ->join('the_loai_sach', 'the_loai_sach.TLS_MA', '=', 'thuoc_the_loai.TLS_MA')
        ->join('cua_sach', 'sach.SACH_MA', '=', 'cua_sach.SACH_MA')
        ->join('tac_gia', 'tac_gia.TG_MA', '=', 'cua_sach.TG_MA')
        ->where('the_loai_sach.TLS_MA', $TLS_MA)
        ->whereNotIn('sach.SACH_MA', [$SACH_MA])
        ->limit(4)->get();

        //Show đánh giá cũ
        $danh_gia = DB::table('danh_gia')
        ->join('khach_hang','khach_hang.KH_MA','=','danh_gia.KH_MA')
        ->where('SACH_MA', $SACH_MA)->orderby('DG_MA','desc')->get();

        $countdg = DB::table('danh_gia')
        ->join('khach_hang','khach_hang.KH_MA','=','danh_gia.KH_MA')
        ->where('SACH_MA', $SACH_MA)->count();

        Session::put('countdg',$countdg);

        //Cho phép nhập đánh giá mới
        $KH_MA = Session::get('KH_MA');
        Session::put('kh',$KH_MA);
        
        $binh_luan=  DB::table('khach_hang')
        ->join('dia_chi_giao_hang','dia_chi_giao_hang.KH_MA','=','khach_hang.KH_MA')
        ->join('don_dat_hang','dia_chi_giao_hang.DCGH_MA','=','don_dat_hang.DCGH_MA')
        ->join('chi_tiet_don_dat_hang','chi_tiet_don_dat_hang.DDH_MA','=','don_dat_hang.DDH_MA')
        ->where('TT_MA', 4)->where('SACH_MA', $SACH_MA)->get();
        
        //Số lượng tồn

        $ddh = DB::table('chi_tiet_don_dat_hang')
            ->join('don_dat_hang','chi_tiet_don_dat_hang.DDH_MA','=','don_dat_hang.DDH_MA')
            ->where('TT_MA', '!=', 5)
            ->where('SACH_MA', $SACH_MA)->sum('CTDDH_SOLUONG');
        Session::put('ban',$ddh);

        $nhap = DB::table('chi_tiet_lo_nhap')
            ->where('SACH_MA', $SACH_MA)->sum('CTLN_SOLUONG');
        $xuat = DB::table('chi_tiet_lo_xuat')
            ->where('SACH_MA', $SACH_MA)->sum('CTLX_SOLUONG');

        Session::put('ton',$nhap-$xuat-$ddh);

        return view('pages.product.show_details_product')->with('category', $all_category_product)
        ->with('product_detail', $details_product)
        ->with('product_relate', $related_product)
        ->with('category_product', $category_product)
        ->with('author_product', $author_product)
        ->with('binh_luan', $binh_luan)
        ->with('danh_gia', $danh_gia);
    }

    public function danh_gia(Request $request, $SACH_MA){ ///ok //ONLY KHÁCH THÀNH VIÊN NHƯNG GIỚI HẠN TRONG CODE
        //Cho phép nhập đánh giá mới
        $KH_MA = Session::get('KH_MA');
        $check= DB::table('danh_gia')->where('KH_MA',$KH_MA)->where('SACH_MA',$SACH_MA)->delete();
        
        $data = array();
        //$data['SACH_MA'] = $request->product_desc;
        $data['KH_MA'] = $KH_MA;
        $data['SACH_MA'] = $SACH_MA;
        $data['DG_NOIDUNG'] = $request->DG_NOIDUNG;
        $data['DG_DIEM'] = $request->DG_DIEM;
        $data['DG_THOIGIAN'] =  Carbon::now('Asia/Ho_Chi_Minh');
        DB::table('danh_gia')->insert($data);
        Session::put('message','Đánh giá sách thành công');
        return Redirect::to('chi-tiet-san-pham/'.$SACH_MA);
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

    public function add_product(){
        $this->AuthLoginChu();
        $nxb = DB::table('nha_xuat_ban')->orderby('NXB_TEN')->get();
        $tg = DB::table('tac_gia')->orderby('TG_BUTDANH')->get();
        $tls = DB::table('the_loai_sach')->orderby('TLS_TEN')->get();

        return view('admin.book.add_product')->with('nxb', $nxb)
        ->with('tls', $tls)->with('tg', $tg);  
    }

    public function all_product(){
        $this->AuthLoginChu();
        $all_product = DB::table('sach')
        ->join('nha_xuat_ban','sach.NXB_MA','=','nha_xuat_ban.NXB_MA')
        ->orderby('SACH_MA', 'desc')->paginate(10);

        $tls = DB::table('the_loai_sach')
        ->join('thuoc_the_loai','thuoc_the_loai.TLS_MA','=','the_loai_sach.TLS_MA')->get();

        $tg = DB::table('tac_gia')
        ->join('cua_sach','tac_gia.TG_MA','=','cua_sach.TG_MA')->get();

        $manager_product = view('admin.book.all_product')->with('all_product', $all_product)
        ->with('tls', $tls)->with('tg', $tg);        
        return view('admin-layout')->with('admin.book.all_product', $manager_product);
    }

    public function save_product(Request $request){
        $this->AuthLoginChu();

        $data = array();
        $data['SACH_TEN'] = $request->SACH_TEN;
        $data['NXB_MA'] = $request->NXB_MA;
        $data['SACH_SOTRANG'] = $request->SACH_SOTRANG;
        $data['SACH_NGONNGU'] = $request->SACH_NGONNGU;
        $data['SACH_MOTA'] = $request->SACH_MOTA;
        $data['SACH_GIA'] = $request->SACH_GIA;
        $data['SACH_ISBN'] = $request->SACH_ISBN;
        $data['SACH_NGAYCAPNHAT'] =  Carbon::now('Asia/Ho_Chi_Minh');
        $data['SACH_NGAYTAO'] =  Carbon::now('Asia/Ho_Chi_Minh');
        $data['SACH_DUONGDANANHBIA'] = "sachloi.png";
        DB::table('sach')->insert($data);

        $sach=DB::table('sach')-> where('SACH_TEN',$request->SACH_TEN)->orderby('SACH_MA','desc')->first();
        $SACH_MA=$sach->SACH_MA;

        $data2 = array();
        $get_image= $request->file('SACH_DUONGDANANHBIA');

        if ($get_image){
            /*echo '<pre>';
            print_r ($get_image);
            echo '</pre>';*/
            $name_image = $SACH_MA;
            $new_image =  'sach'.$name_image.'.'.$get_image->getClientOriginalExtension();
            $get_image->move('public/frontend/images/sach',$new_image);
            $data2['SACH_DUONGDANANHBIA'] = $new_image;
            DB::table('sach')->where('SACH_MA',$SACH_MA)->update($data2);
            Session::put('message','Thêm sách thành công');
        }
        else Session::put('message','Lỗi thêm sách');

        $tgMa = $request->input('TG_MA');
        $tlsMa = $request->input('TLS_MA');

        foreach ($tgMa as $value) {
            DB::table('cua_sach')->insert([
                'TG_MA' => $value,
                'SACH_MA' => $SACH_MA
            ]);
        }

        foreach ($tlsMa as $value) {
            DB::table('thuoc_the_loai')->insert([
                'TLS_MA' => $value,
                'SACH_MA' => $SACH_MA
            ]);
        }
        return Redirect::to('all-product');
    }

    public function edit_product($SACH_MA){
        $this->AuthLoginChu();
        $edit_product = DB::table('sach')->where('SACH_MA',$SACH_MA)->get();
        $nxb = DB::table('nha_xuat_ban')->orderby('NXB_TEN')->get();
        $tg = DB::table('tac_gia')->orderby('TG_BUTDANH')->get();
        $tls = DB::table('the_loai_sach')->orderby('TLS_TEN')->get();

        $cttg = DB::table('cua_sach')->where('SACH_MA',$SACH_MA)->get();
        $cttls = DB::table('thuoc_the_loai')->where('SACH_MA',$SACH_MA)->get();

        $manager_product = view('admin.book.edit_product')->with('edit_product', $edit_product)
        ->with('nxb', $nxb)->with('tls', $tls)->with('tg', $tg)->with('cttls', $cttls)->with('cttg', $cttg);
        return view('admin-layout')->with('admin.book.edit_product', $manager_product);
    }

    public function update_product(Request $request, $SACH_MA){
        $this->AuthLoginChu();
        $data = array();
        $data['SACH_TEN'] = $request->SACH_TEN;
        $data['NXB_MA'] = $request->NXB_MA;
        $data['SACH_SOTRANG'] = $request->SACH_SOTRANG;
        $data['SACH_NGONNGU'] = $request->SACH_NGONNGU;
        $data['SACH_MOTA'] = $request->SACH_MOTA;
        $data['SACH_GIA'] = $request->SACH_GIA;
        $data['SACH_ISBN'] = $request->SACH_ISBN;
        $data['SACH_NGAYCAPNHAT'] =  Carbon::now('Asia/Ho_Chi_Minh');

        $get_image= $request->file('SACH_DUONGDANANHBIA');

        if ($get_image){
            $name_image = $SACH_MA;
            $new_image =  'sach'.$name_image.'.'.$get_image->getClientOriginalExtension();
            $get_image->move('public/frontend/images/sach',$new_image);
            $data['SACH_DUONGDANANHBIA'] = $new_image;
        }
        DB::table('sach')->where('SACH_MA',$SACH_MA)->update($data);
        
        $tgMa = $request->input('TG_MA');
        $tlsMa = $request->input('TLS_MA');

        DB::table('cua_sach')->where('SACH_MA',$SACH_MA)->delete();
        DB::table('thuoc_the_loai')->where('SACH_MA',$SACH_MA)->delete();

        foreach ($tgMa as $value) {
            DB::table('cua_sach')->insert([
                'TG_MA' => $value,
                'SACH_MA' => $SACH_MA
            ]);
        }

        foreach ($tlsMa as $value) {
            DB::table('thuoc_the_loai')->insert([
                'TLS_MA' => $value,
                'SACH_MA' => $SACH_MA
            ]);
        }

        Session::put('message','Cập nhật sách thành công');
        return Redirect::to('all-product');
    }

    public function delete_product($SACH_MA){
        $this->AuthLoginChu();
        
        $checkforeign = DB::table('sach')
        ->join('chi_tiet_lo_nhap','sach.SACH_MA','=','chi_tiet_lo_nhap.SACH_MA')
        ->leftJoin('chi_tiet_lo_xuat','sach.SACH_MA','=','chi_tiet_lo_xuat.SACH_MA')
        ->leftJoin('chi_tiet_don_dat_hang','sach.SACH_MA','=','chi_tiet_don_dat_hang.SACH_MA')
        ->where('sach.SACH_MA',$SACH_MA)->count();

        if($checkforeign != 0){
            Session::put('message','Sách này có liên quan đến các thông tin doanh thu của cửa hàng, không thể xoá');
            return Redirect::to('all-product');
        }

        DB::table('chi_tiet_gio_hang')->where('SACH_MA',$SACH_MA)->delete();
        DB::table('cua_sach')->where('SACH_MA',$SACH_MA)->delete();
        DB::table('thuoc_the_loai')->where('SACH_MA',$SACH_MA)->delete();
        DB::table('danh_gia')->where('SACH_MA',$SACH_MA)->delete();

        DB::table('sach')->where('SACH_MA',$SACH_MA)->delete();
        Session::put('message','Xóa sách thành công');
        return Redirect::to('all-product');
    }
    
    public function show_product($SACH_MA){
        $this->AuthLoginChu();
        $edit_product = DB::table('sach')
        ->join('nha_xuat_ban','sach.NXB_MA','=','nha_xuat_ban.NXB_MA')
        ->where('SACH_MA',$SACH_MA)->get();

        $cttg = DB::table('cua_sach')
        ->join('tac_gia','cua_sach.TG_MA','=','tac_gia.TG_MA')->where('SACH_MA',$SACH_MA)->orderby('TG_BUTDANH')->get();
        $cttls = DB::table('thuoc_the_loai')
        ->join('the_loai_sach','thuoc_the_loai.TLS_MA','=','the_loai_sach.TLS_MA')->where('SACH_MA',$SACH_MA)->orderby('TLS_TEN')->get();

        $manager_product = view('admin.book.show_product')->with('edit_product', $edit_product)
        ->with('cttls', $cttls)->with('cttg', $cttg);
        return view('admin-layout')->with('admin.book.edit_product', $manager_product);
    }

    public function search_all_product(Request $request){
        $this->AuthLoginChu();

        $keywords = $request ->keywords_submit;

        $all_product = DB::table('sach')
        ->join('nha_xuat_ban','sach.NXB_MA','=','nha_xuat_ban.NXB_MA')
        ->where('SACH_TEN', 'LIKE', '%'.$keywords.'%')
        ->orderby('SACH_MA', 'desc')->paginate(10);

        $tls = DB::table('the_loai_sach')
        ->join('thuoc_the_loai','thuoc_the_loai.TLS_MA','=','the_loai_sach.TLS_MA')->get();

        $tg = DB::table('tac_gia')
        ->join('cua_sach','tac_gia.TG_MA','=','cua_sach.TG_MA')->get();

        $manager_product = view('admin.book.all_product')->with('all_product', $all_product)
        ->with('tls', $tls)->with('tg', $tg);        
        return view('admin-layout')->with('admin.book.search_all_product', $manager_product);
    }
}
