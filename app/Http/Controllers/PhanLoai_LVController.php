<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PhanLoai_LV;
use App\LuanVan;

class PhanLoai_LVController extends Controller
{
    public function getDanhSach()
    {
    	$loailv = PhanLoai_LV::all();
    	return view('admin.phanloailv.danhsach', compact('loailv'));
    }

    public function getThem()
    {
        //Lấy mã tự tăng cuối cùng trong database
        $loailv_temp= PhanLoai_LV::orderBy('maloailv','desc')->first();
        $maloailv='';
        if(is_null($loailv_temp))
        {
            $maloailv="LLV001";  
        }else
        {
            //lấy tiền tố LLV
            $tiento = substr( $loailv_temp-> maloailv,  0, 3);
            // độ dài của mã = 5(LLV001)
            $len = $loailv_temp-> maloailv;
            //cắt bỏ tiền tố 'LLV'-> 001 + 1 = 2 
            $next= substr( $loailv_temp-> maloailv,  3, 3) + 1;
            //lấy độ dài mã trừ độ dài tiền tố 5-2=3
            $lenght= strlen($len) - strlen($tiento);
            //chuỗi chứa dãy số 0
            $zero='';
            for ($i=1; $i <= $lenght ; $i++) 
            { 
            //pow(10,i) lấy bình phương 10^i
                if($next < pow(10,$i)){
                    for ($j=1; $j <= $lenght - $i  ; $i++) {
                        $zero .="0";
                    }
                    $maloailv = $tiento.$zero.$next;
                }
            }
        }
    	return view('admin.phanloailv.them', compact('maloailv'));
    }

    public function postThem(Request $request)
    {
        //Lấy mã tự tăng cuối cùng trong database
        $loailv_temp= PhanLoai_LV::orderBy('maloailv','desc')->first();
        $maloailv='';
        if(is_null($loailv_temp))
        {
            $maloailv="LLV001";  
        }else
        {
            //lấy tiền tố LLV
            $tiento = substr( $loailv_temp-> maloailv,  0, 3);
            // độ dài của mã = 5(LLV001)
            $len = $loailv_temp-> maloailv;
            //cắt bỏ tiền tố 'LLV'-> 001 + 1 = 2 
            $next= substr( $loailv_temp-> maloailv,  3, 3) + 1;
            //lấy độ dài mã trừ độ dài tiền tố 5-2=3
            $lenght= strlen($len) - strlen($tiento);
            //chuỗi chứa dãy số 0
            $zero='';
            for ($i=1; $i <= $lenght ; $i++) 
            { 
            //pow(10,i) lấy bình phương 10^i
                if($next < pow(10,$i)){
                    for ($j=1; $j <= $lenght - $i  ; $i++) {
                        $zero .="0";
                    }
                    $maloailv = $tiento.$zero.$next;
                }
            }
        }
    	$this->validate($request,
            [
             'tenloailv' => 'required|unique:phanloai_lv,tenloailv|regex:/^[\pL\s\-]+$/u'
            ],

            [
                'tenloailv.required' => 'Tên loại luận văn không được để trống',
                'tenloailv.regex' => 'Tên loại luận văn không hợp lệ',
                'tenloailv.unique' => 'Tên loại luận văn này đã tồn tại'
            ]
        );

        $loailv = new PhanLoai_LV;
        $loailv-> maloailv = $maloailv;
        $loailv-> tenloailv = mb_convert_case($request-> tenloailv, MB_CASE_TITLE, "UTF-8");
        $loailv-> save();

        return redirect()-> route('phanloailv.danhsach')-> with('thongbao','Thêm loại luận văn thành công');
    }

    public function getXoa($id)
    {
    	$loailv = PhanLoai_LV::find($id);
        $llv = LuanVan::where('maloailv',$id)-> first();
        if(is_null($llv)){
    	   $loailv->delete();
    	   return redirect()-> route('phanloailv.danhsach')-> with('thongbao','Xóa loại luận văn thành công');
        }else{
            return redirect()-> route('phanloailv.danhsach')-> with('thongbao','Không thể xóa');
        }
    }

    public function getSua($id)
    {
    	$loailv = PhanLoai_LV::find($id);
    	return view('admin.phanloailv.sua', compact('loailv'));
    }

    public function postSua(Request $request, $id)
    {
    	$this->validate($request,
            [
             'tenloailv' => 'required|unique:phanloai_lv,tenloailv|regex:/^[\pL\s\-]+$/u'
            ],

            [
                'tenloailv.required' => 'Tên loại luận văn không được để trống',
                'tenloailv.regex' => 'Tên loại luận văn không hợp lệ',
                'tenloailv.unique' => 'Tên loại luận văn này đã tồn tại'
            ]
        );
        $loailv = PhanLoai_LV::find($id);
        $loailv-> tenloailv = mb_convert_case($request-> tenloailv, MB_CASE_TITLE, "UTF-8");
        $loailv-> save();

        return redirect()->route('phanloailv.danhsach')->with('thongbao','Sửa loại luận văn thành công');
    }
}
