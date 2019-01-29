<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SV_BV_LV;
use App\SinhVien;
use App\LuanVan;
use App\GV_SV_LV;

class SV_BV_LVController extends Controller
{
    public function getDanhSach()
    {
    	$svbvlv = SV_BV_LV::all();
    	return view('admin.sv_bv_lv.danhsach',compact('svbvlv'));
    }

    public function getThem()
    {
    	$sinhvien = SinhVien::all();
    	$luanvan = LuanVan::all();
    	return view('admin.sv_bv_lv.them', compact('sinhvien','luanvan'));
    }

    public function postThem(Request $request)
    {
    	$this->validate($request,
    		[
    			'diem' => 'nullable|numeric|min:0|max:10'
    		],
    		[
    			'diem.numeric' => 'Điểm bạn phải nhập số',
                'diem.min' => 'Điểm bạn nhập phải từ 0 đến 10',
                'diem.max' => 'Điểm bạn nhập phải từ 0 đến 10'   		]
    	);
        //tìm sv đã có điểm chưa. Nếu tồn tại thì không được thêm
        $temp= SV_BV_LV::where('masv',$request-> masv)->where('malv',$request-> malv)->first();
        if(isset($temp))
            return redirect()->route('sv_bv_lv.getthem')-> with('thongbao','Đã tồn tại sinh viên làm luận văn');
        // tìm sv đã có trong danh sách hướng dẫn không. Nếu không thì không được nhập điểm
        $kt = GV_SV_LV::where('masv',$request-> masv)->where('malv',$request-> malv)->first();
        if(is_null($kt))
            return redirect()->route('sv_bv_lv.getthem')-> with('thongbao','Chưa có giảng viên hướng dẫn sinh viên');
        $diem = new SV_BV_LV;
        $diem-> masv = $request-> masv;
        $diem-> malv = $request-> malv;
        $diem-> diem = $request-> diem;
        $diem-> save();

        return redirect()->route('sv_bv_lv.danhsach')-> with('thongbao','Nhập điểm thành công');
    }

    public function getXoa($id, $idlv)
    {
    	$diem = SV_BV_LV::where('masv',$id)->where('malv',$idlv)-> delete();
    	return redirect()->route('sv_bv_lv.danhsach')->with('thongbao','Xóa điểm thành công');
    }

    public function getSua($id, $idlv)
    {
    	$sinhvien = SinhVien::all();
    	$luanvan = LuanVan::all();
    	$diem = SV_BV_LV::where('masv',$id)->where('malv',$idlv)-> first();
    	return view('admin.sv_bv_lv.sua',compact('diem','sinhvien','luanvan'));
    }

    public function postSua(Request $request, $id,$idlv)
    {
        $this->validate($request,
            [
                'diem' => 'nullable|numeric|min:0|max:10'
            ],
            [
                'diem.numeric' => 'Điểm bạn phải nhập số',
                'diem.min' => 'Điểm bạn nhập phải từ 0 đến 10',
                'diem.max' => 'Điểm bạn nhập phải từ 0 đến 10'          ]
        );
        // tìm sv đã có trong danh sách hướng dẫn không. Nếu không thì không được nhập điểm
        $kt = GV_SV_LV::where('masv',$request-> masv)->where('malv',$request-> malv)->first();
        
        $request-> diem = isset($request-> diem)? $request-> diem : null;
        //Nếu sửa điểm cho chính nó
        if($id == $request-> masv && $idlv == $request-> malv)
        {
            $diem = SV_BV_LV::where('masv',$id)->where('malv',$idlv)
                        ->update(['masv' => $request-> masv,'malv'=> $request -> malv, 'diem'=> $request-> diem]);
            return redirect()->route('sv_bv_lv.danhsach')->with('thongbao','Sửa thành công');         
        }
        //khi thay đổi sv khác luận văn khác
        else{
            //tìm sv đã có người hướng dẫn chưa nếu có rồi thì k thể sửa
            $temp= SV_BV_LV::where('masv',$request-> masv)->where('malv',$request-> malv)->first();
            if(isset($temp))
                return redirect()->back()-> with('thongbao','Đã tồn tại sinh viên làm luận văn');
            // tìm sv này đã có người hướng dẫn chưa
            if(is_null($kt))
                return redirect()->back()-> with('thongbao','Chưa có giảng viên hướng dẫn sinh viên');
        	$diem = SV_BV_LV::where('masv',$id)->where('malv',$idlv)
        	->update(['masv' => $request-> masv,'malv'=> $request -> malv, 'diem'=> $request-> diem]);
            return redirect()->route('sv_bv_lv.danhsach')->with('thongbao','Sửa thành công');
        }
    }
}
