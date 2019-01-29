<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use PHPExcel;
use PHPExcel_IOFactory; 
use PHPExcel_Cell;
use PHPExcel_Shared_Date;
use App\LuanVan;
use App\PhanLoai_LV;
use App\GV_SV_LV;
use DB;

class LuanVanController extends Controller
{
    public function getDanhSach()
    {
    	$luanvan = LuanVan::all();
    	return view('admin.luanvan.danhsach', compact('luanvan'));
    }

    public function getThem()
    {
        $lv_temp= LuanVan::orderBy('malv','desc')->first();
        $malv='';
        //lấy ra năm hiện tại
        $namlv = date("y");//18
        if(is_null($lv_temp))
       {
           $malv="LV".$namlv."0001";  
       }else
       {
            //lấy tiền tố LV
            $tiento = substr( $lv_temp-> malv,  0, 2);
            //lấy năm nộp LV
            $nam = substr( $lv_temp-> malv,  2, 2);
            // độ dài của mã = 8(LV180001)
            $len = $lv_temp-> malv;
            //cắt bỏ tiền tố 'GV'-> 0001 + 1 = 2 
            $next= substr( $lv_temp-> malv,  4, 4) + 1;
            //lấy độ dài mã trừ độ dài tiền tố 8-2=5
            $lenght= strlen($len) - strlen($tiento) -strlen($nam);
            //chuỗi chứa dãy số 0
            $zero='';
            for ($i=1; $i <= $lenght ; $i++) { 
            //pow(10,i) lấy bình phương 10^i
                if($next < pow(10,$i)){
                    for ($j=1; $j <= $lenght - $i  ; $i++) {
                        $zero .="0";
                    }
                    $malv = $tiento.$nam.$zero.$next;
                }
            }
          
        }
    	$loailv = PhanLoai_LV::all();
    	return view('admin.luanvan.them',compact('loailv','malv'));
    }

    public function postThem(Request $request)
    {
    	$this->validate($request,
            [
             'tenlv' => 'required',
             'loailv' => 'nullable',
             'thangnam' => 'required|date_format:"m-Y"',
             'maubia' => 'required|regex:/^[\pL\s\-]+$/u',
             'noidungtt' => 'nullable'
            ],

            [
                'required' => ':attribute không được để trống',
                'maubia.regex' => ':attribute không hợp lệ',
                'date_format' => ':attribute sai định dạng'
            ],

            [
                'tenlv' => 'Tên luận văn',
                'thangnam' => 'Tháng năm nộp luận văn',
                'maubia' => 'Màu bìa',
                'noidungtt' => 'Nội dung tóm tắt'
            ]
        );
        // Lấy mã luận văn cuối cùng ra
        $lv_temp= LuanVan::orderBy('malv','desc')->first();
        $malv='';
        //lấy ra năm
        $namlv = date("y");//18
        if(is_null($lv_temp))
       {
           $malv="LV".$namlv."0001";  
       }else
       {
            //lấy tiền tố LV
            $tiento = substr( $lv_temp-> malv,  0, 2);
            //lấy năm nộp LV
            $nam = substr( $lv_temp-> malv,  2, 2);
            // độ dài của mã = 8(LV180001)
            $len = $lv_temp-> malv;
            //cắt bỏ tiền tố 'GV'-> 0001 + 1 = 2 
            $next= substr( $lv_temp-> malv,  4, 4) + 1;
            //lấy độ dài mã trừ độ dài tiền tố 8-2=5
            $lenght= strlen($len) - strlen($tiento) -strlen($nam);
            //chuỗi chứa dãy số 0
            $zero='';
            for ($i=1; $i <= $lenght ; $i++) { 
            //pow(10,i) lấy bình phương 10^i
                if($next < pow(10,$i)){
                    for ($j=1; $j <= $lenght - $i  ; $i++) {
                        $zero .="0";
                    }
                    $malv = $tiento.$nam.$zero.$next;
                }
            }
          
        }
        //nối chuổi tháng năm bên hàm thêm thành ngày tháng năm
        $request-> thangnam= '01-'.$request-> thangnam;
        $request-> noidungtt = isset($request-> noidungtt) ? $request-> noidungtt : '';
        $luanvan = new LuanVan;
        $luanvan-> malv = $malv;
        $luanvan-> tenlv = mb_convert_case($request-> tenlv, MB_CASE_TITLE, "UTF-8");
        $luanvan-> maloailv = $request-> maloailv;
        $luanvan-> thangnam = date('Y-m-d', strtotime($request-> thangnam));
        $luanvan-> maubia = mb_convert_case($request-> maubia, MB_CASE_TITLE, "UTF-8");
        $luanvan-> noidungtomtat = $request-> noidungtt;
        $luanvan->save();

        return redirect()->route('luanvan.danhsach')->with('thongbao','Thêm luận văn thành công');
    }

    public function getXoa($id)
    {
    	$luanvan = LuanVan::find($id);
        $lv_hd = GV_SV_LV::where('malv',$id)-> first();
        if(is_null($lv_hd)){
        	$luanvan->delete();
        	return redirect()->route('luanvan.danhsach')->with('thongbao','Xóa luận văn thành công');
        }else{
            return redirect()->route('luanvan.danhsach')->with('thongbao','Không thể xóa');
        }
    }

    public function getSua($id)
    {
    	$luanvan = LuanVan::find($id);
    	$loailv = PhanLoai_LV::all();
    	return view('admin.luanvan.sua',compact('luanvan','loailv'));
    }

    public function postSua(Request $request, $id)
    {
    	$this->validate($request,
            [
             'malv' => Rule::unique('luanvan')->ignore($id, 'malv'),
             'tenlv' => 'required',
             'thangnam' => 'required|date_format:"m-Y"',
             'maubia' => 'required|regex:/^[\pL\s\-]+$/u',
             'noidungtt' => 'nullable'
            ],

            [
                'required' => ':attribute không được để trống',
                'maubia.regex' => ':attribute không hợp lệ',
                'date_format' => ':attribute sai định dạng'
            ],

            [
                'tenlv' => 'Tên luận văn',
                //'loailv' => 'Loại luận văn',
                'thangnam' => 'Tháng năm nộp luận văn',
                'maubia' => 'Màu bìa',
                'noidungtt' => 'Nội dung tóm tắt'
            ]
        );
        $request-> thangnam= '01-'.$request-> thangnam;
        $luanvan = LuanVan::find($id);
        $request-> noidungtt = isset($request-> noidungtt) ? $request-> noidungtt : '';
        $luanvan-> tenlv = mb_convert_case($request-> tenlv, MB_CASE_TITLE, "UTF-8");
        $luanvan-> maloailv = $request-> maloailv;
        $luanvan-> thangnam = date('Y-m-d', strtotime($request-> thangnam));
        $luanvan-> maubia = mb_convert_case($request-> maubia, MB_CASE_TITLE, "UTF-8");
        $luanvan-> noidungtomtat = $request-> noidungtt;
        $luanvan->save();
        return redirect()->route('luanvan.danhsach')->with('thongbao','Sửa luận văn thành công');
    }

    
}
