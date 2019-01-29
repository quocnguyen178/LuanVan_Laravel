<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\GiangVien;
use App\GV_SDT;
use App\SinhVien;
use App\GV_SV_LV;
use App\GV_Quyen;

class GiangVienController extends Controller
{
    public function getDanhSach()
    {
    	$giangvien = GiangVien::All();
    	return view('admin.giangvien.danhsach',compact('giangvien'));
    }

    public function getThem()
    {
        //Lấy mã tự tăng cuối cùng trong database
        $gv_temp= GiangVien::orderBy('magv','desc')->first();
        $magv='';
        if(is_null($gv_temp))
        {
            $magv="TH001";  
        }else
        {
            //lấy tiền tố GV
            $tiento = substr( $gv_temp-> magv,  0, 2);
            // độ dài của mã = 5(GV001)
            $len = $gv_temp-> magv;
            //cắt bỏ tiền tố 'GV'-> 001 + 1 = 2 
            $next= substr( $gv_temp-> magv,  2, 3) + 1;
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
                    $magv = $tiento.$zero.$next;
                }
            }
        }
    	return view('admin.giangvien.them',compact('magv'));
    }
    public function postThem(Request $request)
    {
        //Lấy mã tự tăng cuối cùng trong database
        $gv_temp= GiangVien::orderBy('magv','desc')->first();
        $magv='';
        if(is_null($gv_temp))
        {
            $magv="TH001";  
        }else
        {
            //lấy tiền tố GV
            $tiento = substr( $gv_temp-> magv,  0, 2);
            // độ dài của mã = 5(GV001)
            $len = $gv_temp-> magv;
            //cắt bỏ tiền tố 'GV'-> 001 + 1 = 2 
            $next= substr( $gv_temp-> magv,  2, 3) + 1;
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
                    $magv = $tiento.$zero.$next;
                }
            }
        }
		$this->validate($request,
            [
			 'hotengv' => 'required',
             'hotengv' => array('regex:/^[\pL\s\-]+$/u'),// u: là cho phép unicode,\s: cho phép khoảng trắng,\-: kiểm tra từng ký tự,\pL: kiểm tra từng ký tự unicode bất kì
			 'email' => 'required|email|unique:giangvien,email|unique:sinhvien,email',
			 'sdt1' => 'required|unique:giangvien,sdt1|numeric|unique:sinhvien,sdt',
			 'sdt2' => 'nullable|unique:giangvien,sdt2|numeric|unique:sinhvien,sdt'
            ],

            [
                'required' => ':attribute không được để trống',
                'hotengv.regex' => ':attribute không hợp lệ',
                'numeric' => ':attribute chỉ được nhập số',
                'unique' => ':attribute đã tồn tại',
                'email' => 'Địa chỉ :attribute không hợp lệ'
            ],

            [
                'hotengv' => 'Họ tên giảng viên',
                'email' => 'Email',
                'sdt1' => 'Số điện thoại 1',
                'sdt2' => 'Số điện thoại 2'
            ]
        );
		$giangvien = new GiangVien;
		$giangvien-> magv = $magv;
		$giangvien-> hotengv = mb_convert_case($request-> hotengv, MB_CASE_TITLE, "UTF-8");
		$giangvien-> hocham = $request-> hocham;
		$giangvien-> hocvi = $request-> hocvi;
		$giangvien-> loaigv = $request-> loaigv;
		$giangvien-> email = $request-> email;
        $giangvien-> matkhau = md5($magv);
        $giangvien-> sdt1 = $request-> sdt1;
        $request-> sdt2 = isset($request-> sdt2)? $request-> sdt2 : '';
        $giangvien-> sdt2 = $request-> sdt2;
		$giangvien-> save();
		if($request-> maquyen == 0)
        {
    		$gv_quyen = new GV_Quyen;
            $gv_quyen-> magv = $magv;
            $gv_quyen-> maquyen = 2;
            $gv_quyen-> save();
        }else{
            $gv_quyen2 = new GV_Quyen;
            $gv_quyen2-> magv = $magv;
            $gv_quyen2-> maquyen = 2;
            $gv_quyen2-> save();
            $gv_quyen1 = new GV_Quyen;
            $gv_quyen1-> magv = $magv;
            $gv_quyen1-> maquyen = 1;
            $gv_quyen1-> save();
        }
		
		return redirect()->route('giangvien.danhsach')->with('thongbao','Thêm giảng viên thành công');
    }

    public function getXoa($id)
    {
    	$giangvien = GiangVien::find($id);
        $gv_hd = GV_SV_LV::where('magv',$id)-> first();
        if(is_null($gv_hd)){
    	   $giangvien->delete();
    	   return redirect()->route('giangvien.danhsach')->with('thongbao','Xóa giảng viên thành công');
        }else{
            return redirect()->route('giangvien.danhsach')->with('thongbaokhongthe','Không thể xóa vì giảng viên này đã hướng dẫn sinh viên');
        }
    }

    public function getSua($id)
    {
    	$giangvien = GiangVien::find($id);
    	return view('admin.giangvien.sua', compact('giangvien'));
    }
    public function postSua(Request $request, $id)
    {
		$this->validate($request,
            [
			 'hotengv' => 'required',
             'hotengv' => array('regex:/^[\pL\s\-]+$/u'),// u: là cho phép unicode,\s: cho phép khoảng trắng,\-: kiểm tra từng ký tự,\pL: kiểm tra từng ký tự unicode bất kì
			 'email' => 'required|email',
			 'email' => Rule::unique('giangvien')->ignore($id, 'magv'),
             'email' => Rule::unique('sinhvien')->ignore($id, 'masv'),
			 'sdt1' => 'required|numeric',
			 'sdt2' => 'nullable|numeric',
			 'sdt1' => Rule::unique('giangvien')->ignore($id, 'magv'),
			 'sdt2' => Rule::unique('giangvien')->ignore($id, 'magv')
            ],

            [
                'required' => ':attribute không được để trống',
                'hotengv.regex' => ':attribute không hợp lệ',
                'numeric' => ':attribute chỉ được nhập số',
                'unique' => ':attribute đã tồn tại',
                'email' => 'Địa chỉ :attribute không hợp lệ'
            ],

            [
                'hotengv' => 'Họ tên giảng viên',
                'email' => 'Email',
                'sdt1' => 'Số điện thoại 1',
                'sdt2' => 'Số điện thoại 2'
            ]
        );
        $giangvien = GiangVien::find($id);
		$giangvien-> hotengv = mb_convert_case($request-> hotengv, MB_CASE_TITLE, "UTF-8");
		$giangvien-> hocham = $request-> hocham;
		$giangvien-> hocvi = $request-> hocvi;
		$giangvien-> loaigv = $request-> loaigv;
		$giangvien-> email = $request-> email;
        $giangvien-> sdt1 = $request-> sdt1;
        $request-> sdt2 = isset($request-> sdt2)? $request-> sdt2 : '';
        $giangvien-> sdt2 = $request-> sdt2;
		$giangvien-> save();

        $gv_maquyen = GV_Quyen::where('magv',$id)-> where('maquyen', 1)-> first();
        if(is_null($gv_maquyen)){
            if($request-> maquyen == 1)
            {
                $quyen = new GV_Quyen;
                $quyen-> magv = $id;
                $quyen-> maquyen = 1;
                $quyen-> save();
            }
        }
        else{
            if($request-> maquyen == 0)
                $quyen = GV_Quyen::where('magv',$id)->where('maquyen', 1)-> delete();
        }
		return redirect()->route('giangvien.danhsach')->with('thongbao','Sửa giảng viên thành công');
    }
}
