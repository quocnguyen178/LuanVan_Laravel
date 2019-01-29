<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\GiangVien;
use App\SinhVien;
use App\LuanVan;
use App\GV_SV_LV;
class PageController extends Controller
{
    public function getIndex()
    {
        $data1 = DB::table('sinhvien')
                ->join('gv_sv_lv', 'gv_sv_lv.masv', '=', 'sinhvien.masv')
                ->join('giangvien', 'gv_sv_lv.magv', '=', 'giangvien.magv')
                ->join('luanvan', 'gv_sv_lv.malv', '=', 'luanvan.malv')
                ->join('phanloai_lv', 'phanloai_lv.maloailv', '=', 'luanvan.maloailv')
                ->select('*')
                ->get();
                //dd($data1);
        return view('pages.trangchu',compact('data1'));
    }

    public function postIndex(Request $request)
    {
        $thang = $request-> thang;
        $nam = $request-> nam;
        if($thang==null && $nam!=null)
        {
        $data = DB::table('giangvien')
                ->join('gv_sv_lv', 'gv_sv_lv.magv', '=', 'giangvien.magv')
                ->join('sinhvien', 'gv_sv_lv.masv', '=', 'sinhvien.masv')
                ->join('luanvan', 'luanvan.malv', '=', 'gv_sv_lv.malv')
                ->join('dialuanvan', 'luanvan.malv', '=', 'dialuanvan.malv')
                ->join('sv_bv_lv', 'sv_bv_lv.masv', '=', 'sinhvien.masv')
                ->join('phanloai_lv', 'luanvan.maloailv', '=', 'phanloai_lv.maloailv')
                ->select('*')
                ->where(function($query) use ($nam)  {
                    return $query->whereYear('luanvan.thangnam',$nam);
                })
                /*->paginate(10);*/
                ->get();
                /*dd($data);*/
        return redirect()-> back()-> with(['data'=>$data,'thang'=>$thang,'nam'=>$nam]);}
        if($thang!=null && $nam==null)
        {
        $data = DB::table('giangvien')
                ->join('gv_sv_lv', 'gv_sv_lv.magv', '=', 'giangvien.magv')
                ->join('sinhvien', 'gv_sv_lv.masv', '=', 'sinhvien.masv')
                ->join('luanvan', 'luanvan.malv', '=', 'gv_sv_lv.malv')
                ->join('dialuanvan', 'luanvan.malv', '=', 'dialuanvan.malv')
                ->join('sv_bv_lv', 'sv_bv_lv.masv', '=', 'sinhvien.masv')
                ->join('phanloai_lv', 'luanvan.maloailv', '=', 'phanloai_lv.maloailv')
                ->select('*')
                ->where(function($query) use ($thang)  {
                    return $query->whereMonth('luanvan.thangnam',$thang);
                })
                /*->paginate(10);*/
                ->get();
                /*dd($data);*/
        return redirect()-> back()-> with(['data'=>$data,'thang'=>$thang,'nam'=>$nam]);}
        if($thang!=null && $nam!=null)
        {
        $data = DB::table('giangvien')
                ->join('gv_sv_lv', 'gv_sv_lv.magv', '=', 'giangvien.magv')
                ->join('sinhvien', 'gv_sv_lv.masv', '=', 'sinhvien.masv')
                ->join('luanvan', 'luanvan.malv', '=', 'gv_sv_lv.malv')
                ->join('dialuanvan', 'luanvan.malv', '=', 'dialuanvan.malv')
                ->join('sv_bv_lv', 'sv_bv_lv.masv', '=', 'sinhvien.masv')
                ->join('phanloai_lv', 'luanvan.maloailv', '=', 'phanloai_lv.maloailv')
                ->select('*')
                ->where(function($query) use ($nam)  {
                    return $query->whereYear('luanvan.thangnam',$nam);
                })
                ->where(function($query) use ($thang)  {
                    return $query->whereMonth('luanvan.thangnam',$thang);
                })
                /*->paginate(10);*/
                ->get();
                /*dd($data);*/
        return redirect()-> back()-> with(['data'=>$data,'thang'=>$thang,'nam'=>$nam]);}
        if($thang==null && $nam==null)
        {
        $data = DB::table('giangvien')
                ->join('gv_sv_lv', 'gv_sv_lv.magv', '=', 'giangvien.magv')
                ->join('sinhvien', 'gv_sv_lv.masv', '=', 'sinhvien.masv')
                ->join('luanvan', 'luanvan.malv', '=', 'gv_sv_lv.malv')
                ->join('dialuanvan', 'luanvan.malv', '=', 'dialuanvan.malv')
                ->join('sv_bv_lv', 'sv_bv_lv.masv', '=', 'sinhvien.masv')
                ->join('phanloai_lv', 'luanvan.maloailv', '=', 'phanloai_lv.maloailv')
                ->select('*')
                ->where(function($query) use ($nam)  {
                    return $query->whereYear('luanvan.thangnam',$nam);
                })
                ->where(function($query) use ($thang)  {
                    return $query->whereMonth('luanvan.thangnam',$thang);
                })
                /*->paginate(10);*/
                ->get();
                /*dd($data);*/
        return redirect()-> back()-> with(['data'=>$data,'thang'=>$thang,'nam'=>$nam]);}
        /*return view('pages.trangchu',compact('data'));*/
    }
    function getallluanvan()
    {
        $dataalllv = DB::table('sinhvien')
                ->join('gv_sv_lv', 'gv_sv_lv.masv', '=', 'sinhvien.masv')
                ->join('giangvien', 'gv_sv_lv.magv', '=', 'giangvien.magv')
                ->join('luanvan', 'gv_sv_lv.malv', '=', 'luanvan.malv')
                ->join('dialuanvan', 'luanvan.malv', '=', 'dialuanvan.malv')
                ->join('phanloai_lv', 'phanloai_lv.maloailv', '=', 'luanvan.maloailv')
                ->select('*')
                ->paginate(10);
                //dd($data1);
        //return view('pages.trangchu',compact('data1'));
                return view('pages.thongke.allluanvan',compact('dataalllv'));
    }
}
