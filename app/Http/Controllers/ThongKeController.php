<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Khill\Lavacharts\Lavacharts;
use App\PhanLoai_LV;
use App\LuanVan;
use App\SV_BV_LV;
use App\SinhVien;
use App\GiangVien;
use DB;

class ThongKeController extends Controller
{
    public function getLLV(Request $request)
    {
        $thang = $request-> thang;
        $nam = $request-> nam;
        $loailv = $request-> loailv;
        //$loailuanvan= PhanLoai_LV::all();
        $loailuanvan= PhanLoai_LV::find($loailv);
        if($thang==null && $nam==null && $loailv!=null){
            $data = DB::table('phanloai_lv')
                ->join('luanvan', 'phanloai_lv.maloailv', '=', 'luanvan.maloailv')
                ->select('*')
                ->where('luanvan.maloailv',$loailv)
                ->paginate(10);
                //dd($data,$thang,$nam,$loailv,$loailuanvan);
        return view('pages.thongke.loailuanvan',compact('data','thang','nam','loailv'));
        }
         if($thang==null && $nam!=null && $loailv==null){
            $data = DB::table('phanloai_lv')
                ->join('luanvan', 'phanloai_lv.maloailv', '=', 'luanvan.maloailv')
                ->select('*')
                ->whereYear('luanvan.thangnam',$nam)
                ->paginate(10);
        return view('pages.loailuanvan',compact('data','thang','nam','loailv','loailuanvan'));
        }
         if($thang==null && $nam!=null && $loailv!=null){
            $data = DB::table('phanloai_lv')
                ->join('luanvan', 'phanloai_lv.maloailv', '=', 'luanvan.maloailv')
                ->select('*')
                ->whereYear('luanvan.thangnam',$nam)
                ->where('luanvan.maloailv',$loailv)
                ->paginate(10);
        return view('pages.loailuanvan',compact('data','thang','nam','loailv','loailuanvan'));
        }
         if($thang!=null && $nam==null && $loailv==null){
            $data = DB::table('phanloai_lv')
                ->join('luanvan', 'phanloai_lv.maloailv', '=', 'luanvan.maloailv')
                ->select('*')
                ->whereMonth('luanvan.thangnam',$thang)
                ->paginate(10);
        return view('pages.loailuanvan',compact('data','thang','nam','loailv','loailuanvan'));
        }
         if($thang!=null && $nam==null && $loailv!=null){
            $data = DB::table('phanloai_lv')
                ->join('luanvan', 'phanloai_lv.maloailv', '=', 'luanvan.maloailv')
                ->select('*')
                ->whereMonth('luanvan.thangnam',$thang)
                ->where('luanvan.maloailv',$loailv)
                ->paginate(10);
        return view('pages.loailuanvan',compact('data','thang','nam','loailv','loailuanvan'));
        }
         if($thang!=null && $nam!=null && $loailv==null){
            $data = DB::table('phanloai_lv')
                ->join('luanvan', 'phanloai_lv.maloailv', '=', 'luanvan.maloailv')
                ->select('*')
                ->whereYear('luanvan.thangnam',$nam)
                ->whereMonth('luanvan.thangnam',$thang)
                ->paginate(10);
        return view('pages.loailuanvan',compact('data','thang','nam','loailv','loailuanvan'));
        }
         if($thang!=null && $nam!=null && $loailv!=null){
            $data = DB::table('phanloai_lv')
                ->join('luanvan', 'phanloai_lv.maloailv', '=', 'luanvan.maloailv')
                ->select('*')
                ->whereYear('luanvan.thangnam',$nam)
                ->whereMonth('luanvan.thangnam',$thang)
                ->where('luanvan.maloailv',$loailv)
                ->paginate(10);
        return view('pages.loailuanvan',compact('data','thang','nam','loailv','loailuanvan'));
        }
         if($thang==null && $nam==null && $loailv==null){
            $data = DB::table('phanloai_lv')
                ->join('luanvan', 'phanloai_lv.maloailv', '=', 'luanvan.maloailv')
                ->select('*')
                ->whereYear('luanvan.thangnam',$nam)
                ->whereMonth('luanvan.thangnam',$thang)
                ->where('luanvan.maloailv',$loailv)
                ->paginate(10);
        return view('pages.loailuanvan',compact('data','thang','nam','loailv','loailuanvan'));
        }}
    public function getLoailvAll()
    {
        $luanvan = LuanVan::all();
        $arr=[];
        $arrnam=[];
        foreach ($luanvan as $lv) {
            $thang = substr( $lv-> thangnam,5,2);
            $nam = substr( $lv-> thangnam,0,4);
            $arr[$thang] = $thang;
            foreach ($arr as $v) {
                if($v != $thang)
                    $arr[$thang] = $thang;
            }
            $arrnam[$nam] = $nam;
            foreach ($arrnam as $v) {
                if($v != $nam)
                    $arr[$nam] = $nam;
            }
        }
        sort($arr);
        sort($arrnam);
    	return view('admin.thongke.loailv', compact('arr','arrnam'));
    }

    public function postLoailvAll(Request $request)
    {
    	$thang = $request-> thang;
    	$nam = $request-> nam;
    	$data = DB::table('phanloai_lv')
    			->join('luanvan', 'phanloai_lv.maloailv', '=', 'luanvan.maloailv')
    			->select('tenloailv',DB::raw('count(*) as soluong'))
    			->whereYear('luanvan.thangnam',$request-> nam)
    			->when($thang,function($query) use ($thang)  {
					return $query->whereMonth('luanvan.thangnam',$thang);
				})
    			->groupBy('luanvan.maloailv','tenloailv')
    			->get();
        //khai báo biến biểu đồ
    	$lava = new Lavacharts; // See note below for Laravel
        $chart = $lava->DataTable();
        $chart-> addStringColumn("Tên")
                -> addNumberColumn('Số lượng');
        foreach ($data as $value) {
            $chart ->addRow([$value-> tenloailv,$value-> soluong,]);
        }
        if($thang==''){
	        $lava->ColumnChart('Column',$chart,[
	            'title' => "Loại luận văn năm $nam",
	            'colors' => ['#76A7FA']
	        ]);
	    }
	    else{
	    	$lava->ColumnChart('Column',$chart,[
	            'title' => "Loại luận văn tháng $thang năm $nam",
	            'colors' => ['#76A7FA']
	        ]);
	    }
        if(!count($data))
            return redirect()->back()->with('thongbao','Không tìm thấy kết quả');
        else
            return redirect()->back()->with('lava',$lava);
    }

    public function getDiemsvAll()
    {
        $luanvan = LuanVan::all();
        $arr=[];
        $arrnam=[];
        foreach ($luanvan as $lv) {
            $thang = substr( $lv-> thangnam,5,2);
            $nam = substr( $lv-> thangnam,0,4);
            $arr[$thang] = $thang;
            foreach ($arr as $v) {
                if($v != $thang)
                    $arr[$thang] = $thang;
            }
            $arrnam[$nam] = $nam;
            foreach ($arrnam as $v) {
                if($v != $nam)
                    $arr[$nam] = $nam;
            }
        }
        sort($arr);
        sort($arrnam);
    	return view('admin.thongke.diemsv', compact('arr','arrnam'));
    }

    public function postDiemsvAll(Request $request)
    {
    	$thang = $request-> thang;
    	$nam = $request-> nam;
    	$data = DB::table('sv_bv_lv')
    			->join('sinhvien', 'sinhvien.masv', '=', 'sv_bv_lv.masv')
    			->join('luanvan', 'luanvan.malv', '=', 'sv_bv_lv.malv')
    			->select('diem',DB::raw('count(*) as soluong'))
    			->where('diem','<>',null)
    			->whereYear('luanvan.thangnam',$request-> nam)
    			->when($thang,function($query) use ($thang)  {
					return $query->whereMonth('luanvan.thangnam',$thang);
				})
    			->groupBy('sv_bv_lv.diem')
    			->get();

    	$lava = new Lavacharts; // See note below for Laravel
        $chart = $lava->DataTable();
        $chart-> addStringColumn("Tên")
                -> addNumberColumn('Sinh Viên');
        foreach ($data as $value) {
            $chart ->addRow(['Điểm '.$value-> diem,$value-> soluong,]);
        }
        if($thang==''){
	        $lava->ColumnChart('Column',$chart,[
	            'title' => "Điểm sinh viên làm luận văn năm $nam",
	            'colors' => ['#76A7FA']
	        ]);
	    }
	    else{
	    	$lava->ColumnChart('Column',$chart,[
	            'title' => "Điểm sinh viên làm luận văn tháng $thang năm $nam",
	            'colors' => ['#76A7FA']
	        ]);
	    }
        if(!count($data))
            return redirect()->back()->with('thongbao','Không tìm thấy kết quả');
        else
            return redirect()->back()->with('lava',$lava);
    }

    public function getMauBialvAll()
    {
        $luanvan = LuanVan::all();
        $arr=[];
        $arrnam=[];
        foreach ($luanvan as $lv) {
            $thang = substr( $lv-> thangnam,5,2);
            $nam = substr( $lv-> thangnam,0,4);
            $arr[$thang] = $thang;
            foreach ($arr as $v) {
                if($v != $thang)
                    $arr[$thang] = $thang;
            }
            $arrnam[$nam] = $nam;
            foreach ($arrnam as $v) {
                if($v != $nam)
                    $arr[$nam] = $nam;
            }
        }
        sort($arr);
        sort($arrnam);
    	return view('admin.thongke.maubialv', compact('arr','arrnam'));
    }

    public function postMauBialvAll(Request $request)
    {
    	$thang = $request-> thang;
    	$nam = $request-> nam;
    	$data = DB::table('luanvan')
    			->select('maubia',DB::raw('count(*) as soluong'))
    			->whereYear('luanvan.thangnam',$request-> nam)
    			->when($thang,function($query) use ($thang)  {
					return $query->whereMonth('luanvan.thangnam',$thang);
				})
    			->groupBy('maubia')
    			->get();

    	$lava = new Lavacharts; // See note below for Laravel
        $chart = $lava->DataTable();
        $chart-> addStringColumn("Tên")
                -> addNumberColumn('Số lượng');
        foreach ($data as $value) {
            $chart ->addRow([$value-> maubia,$value-> soluong,]);
        }
        if($thang==''){
	        $lava->ColumnChart('Column',$chart,[
	            'title' => "Màu bìa luận văn năm $nam",
	            'colors' => ['#76A7FA']
	        ]);
	    }
	    else{
	    	$lava->ColumnChart('Column',$chart,[
	            'title' => "Màu bìa luận văn tháng $thang năm $nam",
	            'colors' => ['#76A7FA']
	        ]);
	    }
        if(!count($data))
            return redirect()->back()->with('thongbao','Không tìm thấy kết quả');
        else
            return redirect()->back()->with('lava',$lava);
    }

    public function getLoaiLuanVan()
    {
        $loailuanvan= PhanLoai_LV::all();
        return view('pages.thongke.loailuanvan', compact('loailuanvan'));
    }
    public function postLoaiLuanVan(Request $request)
    {
        $thang = $request-> thang;
        $nam = $request-> nam;
        $loailv = $request-> loailv;
        $loailuanvan= PhanLoai_LV::find($loailv);
        if($thang==null && $nam==null && $loailv!=null){
            $data = DB::table('giangvien')
                ->join('gv_sv_lv', 'gv_sv_lv.magv', '=', 'giangvien.magv')
                ->join('sinhvien', 'gv_sv_lv.masv', '=', 'sinhvien.masv')
                ->join('luanvan', 'luanvan.malv', '=', 'gv_sv_lv.malv')
                ->join('dialuanvan', 'luanvan.malv', '=', 'dialuanvan.malv')
                ->join('sv_bv_lv', 'sv_bv_lv.masv', '=', 'sinhvien.masv')
                ->join('phanloai_lv', 'luanvan.maloailv', '=', 'phanloai_lv.maloailv')
                ->select('*')
                ->where('luanvan.maloailv',$loailv)
                ->get();
        return redirect()-> back()-> with(['data'=>$data,'thang'=>$thang,'nam'=>$nam,'loailv'=>$loailv,'loailuanvan'=>$loailuanvan]);   
         /*return view('pages.thongke.loailuanvan',compact('data','thang','nam','loailv','loailuanvan')); */    
        }
         if($thang==null && $nam!=null && $loailv==null){
            $data = DB::table('giangvien')
                ->join('gv_sv_lv', 'gv_sv_lv.magv', '=', 'giangvien.magv')
                ->join('sinhvien', 'gv_sv_lv.masv', '=', 'sinhvien.masv')
                ->join('luanvan', 'luanvan.malv', '=', 'gv_sv_lv.malv')
                ->join('dialuanvan', 'luanvan.malv', '=', 'dialuanvan.malv')
                ->join('sv_bv_lv', 'sv_bv_lv.masv', '=', 'sinhvien.masv')
                ->join('phanloai_lv', 'luanvan.maloailv', '=', 'phanloai_lv.maloailv')
                ->select('*')
                ->whereYear('luanvan.thangnam',$nam)
                ->get();
        return redirect()-> back()-> with(['data'=>$data,'thang'=>$thang,'nam'=>$nam,'loailv'=>$loailv,'loailuanvan'=>$loailuanvan]);
        }
         if($thang==null && $nam!=null && $loailv!=null){
            $data = DB::table('giangvien')
                ->join('gv_sv_lv', 'gv_sv_lv.magv', '=', 'giangvien.magv')
                ->join('sinhvien', 'gv_sv_lv.masv', '=', 'sinhvien.masv')
                ->join('luanvan', 'luanvan.malv', '=', 'gv_sv_lv.malv')
                ->join('dialuanvan', 'luanvan.malv', '=', 'dialuanvan.malv')
                ->join('sv_bv_lv', 'sv_bv_lv.masv', '=', 'sinhvien.masv')
                ->join('phanloai_lv', 'luanvan.maloailv', '=', 'phanloai_lv.maloailv')
                ->select('*')
                ->whereYear('luanvan.thangnam',$nam)
                ->where('luanvan.maloailv',$loailv)
                ->get();
        return redirect()-> back()-> with(['data'=>$data,'thang'=>$thang,'nam'=>$nam,'loailv'=>$loailv,'loailuanvan'=>$loailuanvan]);
        }
         if($thang!=null && $nam==null && $loailv==null){
            $data = DB::table('giangvien')
                ->join('gv_sv_lv', 'gv_sv_lv.magv', '=', 'giangvien.magv')
                ->join('sinhvien', 'gv_sv_lv.masv', '=', 'sinhvien.masv')
                ->join('luanvan', 'luanvan.malv', '=', 'gv_sv_lv.malv')
                ->join('dialuanvan', 'luanvan.malv', '=', 'dialuanvan.malv')
                ->join('sv_bv_lv', 'sv_bv_lv.masv', '=', 'sinhvien.masv')
                ->join('phanloai_lv', 'luanvan.maloailv', '=', 'phanloai_lv.maloailv')
                ->select('*')
                ->whereMonth('luanvan.thangnam',$thang)
                ->get();
        return redirect()-> back()-> with(['data'=>$data,'thang'=>$thang,'nam'=>$nam,'loailv'=>$loailv,'loailuanvan'=>$loailuanvan]);
        }
         if($thang!=null && $nam==null && $loailv!=null){
            $data = DB::table('giangvien')
                ->join('gv_sv_lv', 'gv_sv_lv.magv', '=', 'giangvien.magv')
                ->join('sinhvien', 'gv_sv_lv.masv', '=', 'sinhvien.masv')
                ->join('luanvan', 'luanvan.malv', '=', 'gv_sv_lv.malv')
                ->join('dialuanvan', 'luanvan.malv', '=', 'dialuanvan.malv')
                ->join('sv_bv_lv', 'sv_bv_lv.masv', '=', 'sinhvien.masv')
                ->join('phanloai_lv', 'luanvan.maloailv', '=', 'phanloai_lv.maloailv')
                ->select('*')
                ->whereMonth('luanvan.thangnam',$thang)
                ->where('luanvan.maloailv',$loailv)
                ->get();
       return redirect()-> back()-> with(['data'=>$data,'thang'=>$thang,'nam'=>$nam,'loailv'=>$loailv,'loailuanvan'=>$loailuanvan]);
        }
         if($thang!=null && $nam!=null && $loailv==null){
            $data = DB::table('giangvien')
                ->join('gv_sv_lv', 'gv_sv_lv.magv', '=', 'giangvien.magv')
                ->join('sinhvien', 'gv_sv_lv.masv', '=', 'sinhvien.masv')
                ->join('luanvan', 'luanvan.malv', '=', 'gv_sv_lv.malv')
                ->join('dialuanvan', 'luanvan.malv', '=', 'dialuanvan.malv')
                ->join('sv_bv_lv', 'sv_bv_lv.masv', '=', 'sinhvien.masv')
                ->join('phanloai_lv', 'luanvan.maloailv', '=', 'phanloai_lv.maloailv')
                ->select('*')
                ->whereYear('luanvan.thangnam',$nam)
                ->whereMonth('luanvan.thangnam',$thang)
                ->get();
        return redirect()-> back()-> with(['data'=>$data,'thang'=>$thang,'nam'=>$nam,'loailv'=>$loailv,'loailuanvan'=>$loailuanvan]);
        }
         if($thang!=null && $nam!=null && $loailv!=null){
            $data =
                DB::table('giangvien')
                ->join('gv_sv_lv', 'gv_sv_lv.magv', '=', 'giangvien.magv')
                ->join('sinhvien', 'gv_sv_lv.masv', '=', 'sinhvien.masv')
                ->join('luanvan', 'luanvan.malv', '=', 'gv_sv_lv.malv')
                ->join('dialuanvan', 'luanvan.malv', '=', 'dialuanvan.malv')
                ->join('sv_bv_lv', 'sv_bv_lv.masv', '=', 'sinhvien.masv')
                ->join('phanloai_lv', 'luanvan.maloailv', '=', 'phanloai_lv.maloailv')
                ->select('*')
                ->whereYear('luanvan.thangnam',$nam)
                ->whereMonth('luanvan.thangnam',$thang)
                ->where('luanvan.maloailv',$loailv)
                ->get();
        return redirect()-> back()-> with(['data'=>$data,'thang'=>$thang,'nam'=>$nam,'loailv'=>$loailv,'loailuanvan'=>$loailuanvan]);
        }
         if($thang==null && $nam==null && $loailv==null){
            $data = DB::table('giangvien')
                ->join('gv_sv_lv', 'gv_sv_lv.magv', '=', 'giangvien.magv')
                ->join('sinhvien', 'gv_sv_lv.masv', '=', 'sinhvien.masv')
                ->join('luanvan', 'luanvan.malv', '=', 'gv_sv_lv.malv')
                ->join('dialuanvan', 'luanvan.malv', '=', 'dialuanvan.malv')
                ->join('sv_bv_lv', 'sv_bv_lv.masv', '=', 'sinhvien.masv')
                ->join('phanloai_lv', 'luanvan.maloailv', '=', 'phanloai_lv.maloailv')
                ->select('*')
                ->whereYear('luanvan.thangnam',$nam)
                ->whereMonth('luanvan.thangnam',$thang)
                ->where('luanvan.maloailv',$loailv)
                ->get();
        return redirect()-> back()-> with(['data'=>$data,'thang'=>$thang,'nam'=>$nam,'loailv'=>$loailv,'loailuanvan'=>$loailuanvan]);
        }
        
        
    }

    public function getSinhVien()
    {
        $sinhvien = SinhVien::all();
        $arr=[];
        foreach ($sinhvien as $sv) {
            $khoa = substr( $sv-> masv,3,2);
            $arr[$khoa] = $khoa;
            foreach ($arr as $v) {
                if($v != $khoa)
                    $arr[$khoa] = $khoa;
            }
        }
        return view('pages.thongke.sinhvien', compact('arr'));
    }
    public function postSinhVien(Request $request)
    {
        //$thang = $request-> thang;
       // $nam = $request-> nam;
        $khoa = $request-> khoa;
        $data = DB::table('giangvien')
                ->join('gv_sv_lv', 'gv_sv_lv.magv', '=', 'giangvien.magv')
                ->join('sinhvien', 'gv_sv_lv.masv', '=', 'sinhvien.masv')
                ->join('luanvan', 'luanvan.malv', '=', 'gv_sv_lv.malv')
                ->join('dialuanvan', 'luanvan.malv', '=', 'dialuanvan.malv')
                ->join('sv_bv_lv', 'sv_bv_lv.masv', '=', 'sinhvien.masv')
                ->join('phanloai_lv', 'luanvan.maloailv', '=', 'phanloai_lv.maloailv')
                ->select('*')
                ->where('sinhvien.masv','like','DH5'.$khoa.'%')
                ->get();
        return redirect()-> back()-> with('data', $data);
    }
    public function getGiangVien()
    {
        $giangvien = GiangVien::all();
        $arr=[];
        foreach ($giangvien as $gv) {
            $hoten =$gv-> hotengv;
            $arr[$hoten] = $hoten;
            foreach ($arr as $v) {
                if($v != $hoten)
                    $arr[$hoten] = $hoten;
            }
        }
        return view('pages.thongke.giangvien', compact('arr'));
    }
    public function postGiangVien(Request $request)
    {
        $htgv = $request-> htgv;
        $data = DB::table('giangvien')
                ->join('gv_sv_lv', 'gv_sv_lv.magv', '=', 'giangvien.magv')
                ->join('sinhvien', 'gv_sv_lv.masv', '=', 'sinhvien.masv')
                ->join('luanvan', 'luanvan.malv', '=', 'gv_sv_lv.malv')
                ->join('dialuanvan', 'luanvan.malv', '=', 'dialuanvan.malv')
                ->join('sv_bv_lv', 'sv_bv_lv.masv', '=', 'sinhvien.masv')
                ->join('phanloai_lv', 'luanvan.maloailv', '=', 'phanloai_lv.maloailv')
                ->select('*')
                ->where('giangvien.hotengv','like',$htgv)
                ->get();

        return redirect()-> back()-> with('data', $data);
    }
    public function getDiem()
    {
        return view('pages.thongke.diem');
    }
    public function postDiem(Request $request)
    {
        $thang = $request-> thang;
        $nam = $request-> nam;
        $data = DB::table('sinhvien')
                ->join('gv_sv_lv', 'gv_sv_lv.masv', '=', 'sinhvien.masv')
                ->join('giangvien', 'gv_sv_lv.magv', '=', 'giangvien.magv')
                ->join('luanvan', 'gv_sv_lv.malv', '=', 'luanvan.malv')
                ->join('dialuanvan', 'dialuanvan.malv', '=', 'luanvan.malv')
                ->join('sv_bv_lv', 'sv_bv_lv.masv', '=', 'sinhvien.masv')
                ->select('*')
                ->whereYear('luanvan.thangnam',$request-> nam)
                ->when($thang,function($query) use ($thang)  {
                    return $query->whereMonth('luanvan.thangnam',$thang);
                })
                ->get();
        return redirect()-> back()-> with('data', $data);
    }
    public function getLuanVan()
    {
        return view('pages.thongke.luanvan');
    }
    public function postLuanVan(Request $request)
    {
        $thang = $request-> thang;
        $nam = $request-> nam;
        $data = DB::table('sinhvien')
                ->join('gv_sv_lv', 'gv_sv_lv.masv', '=', 'sinhvien.masv')
                ->join('giangvien', 'gv_sv_lv.magv', '=', 'giangvien.magv')
                ->join('luanvan', 'gv_sv_lv.malv', '=', 'luanvan.malv')
                ->join('phanloai_lv', 'phanloai_lv.maloailv', '=', 'luanvan.maloailv')
                ->select('*')
                ->when($nam,function($query) use ($nam)  {
                    return $query->whereYear('luanvan.thangnam','=',$nam);
                })
                ->orWhere(function($query) use ($thang)  {
                    return $query->whereMonth('luanvan.thangnam','=',$thang);
                })
                ->get();
        return redirect()-> back()-> with('data', $data);
    }

}
   /* public function kq(){
        return view('kq');
    }*/