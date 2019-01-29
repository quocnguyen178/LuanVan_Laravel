<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\SinhVien;
use App\GV_SDT;
use App\GV_SV_LV;

class SinhVienController extends Controller
{
    public function getDanhSach()
    {
    	$sinhvien = SinhVien::All();
    	return view('admin.sinhvien.danhsach',compact('sinhvien'));
    }

    public function getThem()
    {
    	return view('admin.sinhvien.them');
    }
    public function postThem(Request $request)
    {
   
        $this->validate($request,
            [
             'masv' => array('required','min:10','max:10','unique:sinhvien,masv','regex:/(DH5)|(CD5)[0-9]{7}/'),
             'hotensv' => array('required','required','regex:/^[\pL\s\-]+$/u'),// u: là cho phép unicode,\s: cho phép khoảng trắng,\-: kiểm tra từng ký tự,\pL: kiểm tra từng ký tự unicode bất kì
             'lop' => array('required','regex:/^(D)[0-9]{2}(_TH)[0-9]{2}$|^(C)[0-9]{2}(_TH)[0-9]{2}$/'),
             'sdt' => 'required|numeric|unique:sinhvien,sdt|unique:giangvien,sdt1|unique:giangvien,sdt2',
             'email' => 'required|email|unique:sinhvien,email|unique:giangvien,email'
            ],

            [
                'required' => ':attribute không được để trống',
                'min' => ':attribute không được nhỏ hơn :min ký tự',
                'max' => ':attribute không được lớn hơn :max ký tự',
                'numeric' => ':attribute chỉ được nhập số',
                'unique' => ':attribute đã tồn tại',
                'hotensv.regex' => ':attribute không hợp lệ',
                'masv.regex' => ':attribute phải nhập đúng định dạng sau: DH5yyxxxxx hoặc CD5yyxxxxx ( trong đó: yy là khóa học, xxxxx là mssv )',
                'lop.regex' => ':attribute phải nhập đúng định dạng sau: Dyy_THxx hoặc Cyy_THxx ( trong đó: yy là khóa học, xx là số lớp )',
                'email' => 'Địa chỉ :attribute không hợp lệ'
            ],

            [
                'masv' => 'Mã số sinh viên',
                'hotensv' => 'Họ tên sinh viên',
                'lop' => 'Lớp',
                'sdt' => 'Số điện thoại',
                'email' => 'Email'
            ]
        );
    	$sinhvien = new SinhVien;
    	$sinhvien-> masv = $request-> masv;
    	$sinhvien-> hotensv = mb_convert_case($request-> hotensv, MB_CASE_TITLE, "UTF-8");
    	$sinhvien-> lop = $request-> lop;
    	$sinhvien-> sdt = $request-> sdt;
    	$sinhvien-> email = $request-> email;
        $sinhvien-> matkhau = md5($request-> masv);
        $sinhvien-> maquyen = 3;
    	$sinhvien-> save();
    	return redirect()->route('sinhvien.danhsach')->with('thongbao','Thêm sinh viên thành công');
    }
    public function getSua($id)
    {
    	$sinhvien = SinhVien::find($id);
    	return view('admin.sinhvien.sua', compact('sinhvien'));
    }
    public function postSua(Request $request, $id)
    {
        $this->validate($request,
            [
             'masv' => Rule::unique('sinhvien')->ignore($id, 'masv'),
             'hotensv' => array('required','regex:/^[\pL\s\-]+$/u'),// u: là cho phép unicode,\s: cho phép khoảng trắng,\-: kiểm tra từng ký tự,\pL: kiểm tra từng ký tự unicode bất kì
             'lop' => array('required','regex:/^(D)[0-9]{2}(_TH)[0-9]{2}$|^(C)[0-9]{2}(_TH)[0-9]{2}$/'),
             'sdt' => 'required|numeric|unique:giangvien,sdt1|unique:giangvien,sdt2',
             'sdt' => Rule::unique('sinhvien')->ignore($id, 'masv'),
             // 'sdt' => Rule::unique('giangvien')->ignore($id, 'magv'),
             'email' => 'required|email',
             'email' => Rule::unique('sinhvien')->ignore($id, 'masv'),
             'email' => Rule::unique('giangvien')->ignore($id, 'magv')
            ],

            [
                'required' => ':attribute không được để trống',
                'numeric' => ':attribute chỉ được nhập số',
                'unique' => ':attribute đã tồn tại',
                'hotensv.regex' => ':attribute không hợp lệ',
                'masv.regex' => ':attribute phải nhập đúng định dạng sau: DH5yyxxxxx ( trong đó: yy là khóa học, xxxxx là mssv )',
                'lop.regex' => ':attribute phải nhập đúng định dạng sau: Dyy_THxx ( trong đó: yy là khóa học, xx là số lớp )',
                'email' => 'Địa chỉ :attribute không hợp lệ'
            ],

            [
                'masv' => 'Mã số sinh viên',
                'hotensv' => 'Họ tên sinh viên',
                'lop' => 'Lớp',
                'sdt' => 'Số điện thoại',
                'email' => 'Email'
            ]
        );
    	$sinhvien = SinhVien::find($id);
    	$sinhvien-> masv = $request-> masv;
    	$sinhvien-> hotensv = mb_convert_case($request-> hotensv, MB_CASE_TITLE, "UTF-8");
    	$sinhvien-> lop = $request-> lop;
    	$sinhvien-> sdt = $request-> sdt;
    	$sinhvien-> email = $request-> email;
    	$sinhvien-> save();
    	return redirect()->route('sinhvien.danhsach')->with('thongbao','Sửa sinh viên thành công');

    }
    public function getXoa($id)
    {
    	$sinhvien = SinhVien::find($id);
        $sv_hd = GV_SV_LV::where('masv',$id)-> first();
        if(is_null($sv_hd)){
    	   $sinhvien-> delete();
    	   return redirect()->route('sinhvien.danhsach')->with('thongbao','Xóa sinh viên thành công');
        }else{
            return redirect()->route('sinhvien.danhsach')->with('thongbao','Không thể xóa sinh viên này vì đã thực hiện luận văn');
        }
    }
}
