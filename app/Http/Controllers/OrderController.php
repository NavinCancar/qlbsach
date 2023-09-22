<?php

namespace App\Http\Controllers;

use DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;

use PDF;

use Carbon\Carbon;
session_start();

class OrderController extends Controller
{//Backend--Chủ cửa hàng + Bán hàng-------------------------------------------------------
    
    public function AuthLogin(){
        $NV_MA = Session::get('NV_MA');
        $CV_MA = DB::table('nhan_vien')->where('NV_MA',$NV_MA)->first();
        if($NV_MA){
            if($CV_MA->CV_MA != 1 && $CV_MA->CV_MA != 3){
                return Redirect::to('dashboard')->send();
            }
        }else{
            return Redirect::to('admin')->send();
        }
    }

    //Tất cả trạng thái
    public function all_status(){
        $this->AuthLogin();
        $all_status = DB::table('trang_thai')->get();

        $all_DDH=  DB::table('don_dat_hang')
        ->join('trang_thai', 'trang_thai.TT_MA', '=', 'don_dat_hang.TT_MA')
        ->orderby('don_dat_hang.DDH_MA','desc')->paginate(10);
        $group_DDH = DB::table('don_dat_hang')
        ->join('chi_tiet_don_dat_hang','don_dat_hang.DDH_MA','=','chi_tiet_don_dat_hang.DDH_MA')
        ->join('sach','sach.SACH_MA','=','chi_tiet_don_dat_hang.SACH_MA')->get();

        return view('admin.order.all_order')->with('all_status', $all_status)
        ->with('all_DDH', $all_DDH)->with('group_DDH', $group_DDH);
    }

    //Danh mục trạng thái
    public function show_status_order($TT_MA){
        $this->AuthLogin();
        $all_status = DB::table('trang_thai')->get();

        $status_by_id = DB::table('don_dat_hang')
        ->join('trang_thai', 'trang_thai.TT_MA', '=', 'don_dat_hang.TT_MA')
        ->orderby('don_dat_hang.DDH_MA','desc')
        ->where('trang_thai.TT_MA', $TT_MA)->paginate(10);

        $status_name = DB::table('trang_thai')->where('trang_thai.TT_MA', $TT_MA )->get();

        $all_DDH=  DB::table('don_dat_hang')->orderby('don_dat_hang.DDH_MA','desc')->get();

        $group_DDH = DB::table('don_dat_hang')
        ->join('chi_tiet_don_dat_hang','don_dat_hang.DDH_MA','=','chi_tiet_don_dat_hang.DDH_MA')
        ->join('sach','sach.SACH_MA','=','chi_tiet_don_dat_hang.SACH_MA')->get();

        return view('admin.order.show_status_order')->with('all_status', $all_status)
        ->with('id_status', $status_by_id)->with('status_name', $status_name)
        ->with('all_DDH', $all_DDH)->with('group_DDH', $group_DDH);
    }

    //Tìm kiếm sản phẩm trong tất cả các đơn đặt hàng
    public function search_all_order(Request $request){
        $this->AuthLogin();

        $all_status = DB::table('trang_thai')->get();

        $keywords = $request ->keywords_submit;

        $all_DDH=  DB::table('don_dat_hang')
        //->join('chi_tiet_don_dat_hang','don_dat_hang.DDH_MA','=','chi_tiet_don_dat_hang.DDH_MA')
        //->join('sach','sach.SACH_MA','=','chi_tiet_don_dat_hang.SACH_MA')
        ->join('trang_thai', 'trang_thai.TT_MA', '=', 'don_dat_hang.TT_MA')
        //->where('sach.SACH_MA', 'like', '%'.$keywords.'%')
        ->where('don_dat_hang.DDH_MA', '=', $keywords)
        ->orderby('don_dat_hang.DDH_MA','desc')->get();

        $group_DDH = DB::table('don_dat_hang')
        ->join('chi_tiet_don_dat_hang','don_dat_hang.DDH_MA','=','chi_tiet_don_dat_hang.DDH_MA')
        ->join('sach','sach.SACH_MA','=','chi_tiet_don_dat_hang.SACH_MA')->get();

        return view('admin.order.search_all_order')->with('all_status', $all_status)
        ->with('all_DDH', $all_DDH)->with('group_DDH', $group_DDH);
    }

    //Xem chi tiết đơn hàng
    public function show_detail($DDH_MA){
        $this->AuthLogin();
        $all_category_product = DB::table('the_loai_sach')->get();
        $all_DDH=  DB::table('don_dat_hang')
        ->join('dia_chi_giao_hang','dia_chi_giao_hang.DCGH_MA','=','don_dat_hang.DCGH_MA')
        ->join('khach_hang','khach_hang.KH_MA','=','dia_chi_giao_hang.KH_MA')
        ->join('hinh_thuc_thanh_toan','hinh_thuc_thanh_toan.HTTT_MA','=','don_dat_hang.HTTT_MA')
        ->join('tinh_thanh_pho','dia_chi_giao_hang.TTP_MA','=','tinh_thanh_pho.TTP_MA')
        ->where('don_dat_hang.DDH_MA', $DDH_MA)->get();

        $group_DDH = DB::table('chi_tiet_don_dat_hang')
        ->join('sach','sach.SACH_MA','=','chi_tiet_don_dat_hang.SACH_MA')
        ->where('chi_tiet_don_dat_hang.DDH_MA', $DDH_MA)->get();

        $TT_MA = Session::get('TT_MA');

        $all_status = DB::table('trang_thai')
        ->where('trang_thai.TT_MA', $TT_MA)->get();

        return view('admin.order.show_detail_order')->with('category', $all_category_product)
        ->with('all_DDH', $all_DDH)->with('group_DDH', $group_DDH)->with('all_status', $all_status);
    }



    //In hoá đơn giao hàng
    public function print_bill($DDH_MA){
        $this->AuthLogin();
        
        $pdf = \App::make('dompdf.wrapper');
		$pdf->loadHTML($this->print_bill_convert($DDH_MA));
		
		return $pdf->stream();
    }

    public function print_bill_convert($DDH_MA){

		$all_DDH=  DB::table('don_dat_hang')
        ->join('dia_chi_giao_hang','dia_chi_giao_hang.DCGH_MA','=','don_dat_hang.DCGH_MA')
        ->join('khach_hang','khach_hang.KH_MA','=','dia_chi_giao_hang.KH_MA')
        ->join('hinh_thuc_thanh_toan','hinh_thuc_thanh_toan.HTTT_MA','=','don_dat_hang.HTTT_MA')
        ->join('tinh_thanh_pho','dia_chi_giao_hang.TTP_MA','=','tinh_thanh_pho.TTP_MA')
        ->where('don_dat_hang.DDH_MA', $DDH_MA)->first();

        $group_DDH = DB::table('chi_tiet_don_dat_hang')
        ->join('sach','sach.SACH_MA','=','chi_tiet_don_dat_hang.SACH_MA')
        ->where('chi_tiet_don_dat_hang.DDH_MA', $DDH_MA)->get();

		$output = '';

        $output .= '<!DOCTYPE>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Hoá đơn giao hàng</title>
            <style>
                body {
                    font-family: DejaVu Sans;
                    margin: 0;
                    padding: 10px;
                }
                
                h2 {
                    text-align: center;
                }

                table {
                    width: 100%;
                    border-collapse: collapse;
                }

                td, th {
                    border: 1px solid #ccc;
                    padding: 5px;
                }

                .total-price {
                    margin-top: 10px;
                    text-align: right;
                }
            </style>
        </head>
        <body>
            <h2>HOÁ ĐƠN</h2>
                <h3><u>Thông tin hoá đơn</u></h3>
                <table>
                    <tr>
                        <th>Bên gửi:</th>
                        <td class="shipper-details">
                            Tên người gửi: Cửa hàng sách Bling Bling<br>
                            Số điện thoại: 0123456789<br>
                            Địa chỉ: 123, đường 3/2, Ninh Kiều, Cần Thơ
                        </td>
                    </tr>
                    <tr>
                        <th>Bên nhận:</th>
                        <td class="consignee-details">
                            Tên người nhận: '.$all_DDH->DCGH_HOTENNGUOINHAN.'<br>
                            Số điện thoại: '.$all_DDH->KH_SODIENTHOAI.'<br>
                            Địa chỉ: '.$all_DDH->DCGH_VITRICUTHE.', '.$all_DDH->TTP_TEN.'<br>
                            Ghi chú: '.$all_DDH->DCGH_GHICHU.'
                        </td>
                    </tr>
                </table>
                <br><br>
                <h3><u>Chi tiết đơn hàng</u></h3>
                <table>
                    <tr>
                        <th>Tên sản phẩm</th>
                        <th>Số lượng</th>
                    </tr>';
                    foreach ($group_DDH as $key => $ctddh){
                        $output .= '<tr>
                                        <td>'.$ctddh->SACH_TEN.'</td>
                                        <td>'.$ctddh->CTDDH_SOLUONG.'</td>
                                    </tr>';
                    }
                    
            $output .= '</table>
                <br>
                <div class="total-price">
                    <h3><u>Tổng đơn hàng: '.number_format($all_DDH->DDH_TONGTIEN).' VNĐ</u></h3>
                </div>
                <div class="total-price">
                    Hình thức thanh toán: '.$all_DDH->HTTT_TEN.'
                </div>
            </div>
            
        </body>
        </html>';
        return $output;
	}


    public function update_status_order($DDH_MA){
        $this->AuthLogin();

        $trangthai = DB::table('TRANG_THAI')->orderby('TT_MA')->get(); 
        $edit_order = DB::table('don_dat_hang')->where('DDH_MA',$DDH_MA)->get();

        $manager_order = view('admin.order.update_status_order')->with('edit_order', $edit_order)->with('trangthai',$trangthai);
        return view('admin-layout')->with('admin.order.update_status_order', $manager_order);
    }

    public function update_status(Request $request, $DDH_MA, $TT_MA){
        $this->AuthLogin();
        $NV_MA = Session::get('NV_MA');

        $data = array();
        $data['TT_MA'] = $request->TT_MA;
        DB::table('don_dat_hang')->where('DDH_MA', $request->DDH_MA)->update($data);

        Session::put('message','Cập nhật trạng thái đơn hàng thành công');
        return Redirect::to('/danh-muc-trang-thai/tat-ca');
    }
}
