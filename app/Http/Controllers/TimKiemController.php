<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\GiangVien;
use App\GV_SV_LV;
use App\SinhVien;
use App\LuanVan;
use App\PhanLoai_LV;
use App\GV_SDT;
use App\User;
use App\Quyen;
use App\DiaLuanVan;
use DB;
class TimKiemController extends Controller
{
    public function getGVTimKiem(Request $request)
    {
    	// removing symbols used by MySQL
        $reservedSymbols = ['-', '+', '<', '>', '@', '(', ')', '~'];
        $query = str_replace($reservedSymbols, '', $request-> search);
    	$timkiem= $request-> search;
        $chon = $request-> sel;
        $data='';
        if($query=="")
            $data=null;
        elseif($request-> sel == 'Tất cả'){
            $data = DB::table('giangvien')
        			->join('gv_sv_lv', 'gv_sv_lv.magv', '=', 'giangvien.magv')
        			->join('sinhvien', 'gv_sv_lv.masv', '=', 'sinhvien.masv')
        			->join('luanvan', 'luanvan.malv', '=', 'gv_sv_lv.malv')
                    ->join('dialuanvan', 'luanvan.malv', '=', 'dialuanvan.malv')
        			->join('sv_bv_lv', 'sv_bv_lv.masv', '=', 'sinhvien.masv')
        			->join('phanloai_lv', 'luanvan.maloailv', '=', 'phanloai_lv.maloailv')
        			
        			->select('*')

        			->whereRaw("MATCH (giangvien.hotengv) AGAINST ( ? IN BOOLEAN MODE)", array($query))
        			->orwhereRaw("MATCH (sinhvien.hotensv) AGAINST ( ? IN BOOLEAN MODE)", array($query))
        			->orwhereRaw("MATCH (luanvan.tenlv) AGAINST ( ? IN BOOLEAN MODE)", array($query))
        			->orwhereRaw("MATCH (luanvan.noidungtomtat) AGAINST ( ? IN BOOLEAN MODE)", array($query))
        			->orwhereRaw("MATCH (phanloai_lv.tenloailv) AGAINST ( ? IN BOOLEAN MODE)", array($query))
        			->orWhere('sv_bv_lv.diem',$query)
        			->orWhere('luanvan.malv','like','%'.$query.'%')
                    ->orWhere('sinhvien.masv','like','%'.$query.'%')
                    ->orWhere(function($query_thangnam) use ($query)  {
    					$query_thangnam->whereMonth('luanvan.thangnam',$query);
    				 })
    				->orWhere(function($query_thangnam) use ($query)  {
    					$query_thangnam->whereYear('luanvan.thangnam',$query);
    				 })
        			->paginate(10);
        }
        elseif($request-> sel == 'GVHD'){
            $data = DB::table('giangvien')
                    ->join('gv_sv_lv', 'gv_sv_lv.magv', '=', 'giangvien.magv')
                    ->join('sinhvien', 'gv_sv_lv.masv', '=', 'sinhvien.masv')
                    ->join('luanvan', 'luanvan.malv', '=', 'gv_sv_lv.malv')
                    ->join('dialuanvan', 'luanvan.malv', '=', 'dialuanvan.malv')
                    ->join('sv_bv_lv', 'sv_bv_lv.masv', '=', 'sinhvien.masv')
                    ->join('phanloai_lv', 'luanvan.maloailv', '=', 'phanloai_lv.maloailv')
                    
                    ->select('*')

                    ->whereRaw("MATCH (giangvien.hotengv) AGAINST ( ? IN BOOLEAN MODE)", array($query))
                    // ->orwhereRaw("MATCH (luanvan.noidungtomtat) AGAINST ( ? IN BOOLEAN MODE)", array($query))
                    // ->orwhereRaw("MATCH (phanloai_lv.tenloailv) AGAINST ( ? IN BOOLEAN MODE)", array($query))
                    // ->orWhere('sv_bv_lv.diem',$query)
                    // ->orWhere('luanvan.malv','like','%'.$query.'%')
                    // ->orWhere('sinhvien.masv','like','%'.$query.'%')
                    // ->orWhere(function($query_thangnam) use ($query)  {
                    //     $query_thangnam->whereMonth('luanvan.thangnam',$query);
                    //  })
                    // ->orWhere(function($query_thangnam) use ($query)  {
                    //     $query_thangnam->whereYear('luanvan.thangnam',$query);
                    //  })
                    ->paginate(10);
        }
        elseif($request-> sel == 'Sinh viên'){
            $data = DB::table('giangvien')
                    ->join('gv_sv_lv', 'gv_sv_lv.magv', '=', 'giangvien.magv')
                    ->join('sinhvien', 'gv_sv_lv.masv', '=', 'sinhvien.masv')
                    ->join('luanvan', 'luanvan.malv', '=', 'gv_sv_lv.malv')
                    ->join('dialuanvan', 'luanvan.malv', '=', 'dialuanvan.malv')
                    ->join('sv_bv_lv', 'sv_bv_lv.masv', '=', 'sinhvien.masv')
                    ->join('phanloai_lv', 'luanvan.maloailv', '=', 'phanloai_lv.maloailv')
                    
                    ->select('*')

                    ->whereRaw("MATCH (sinhvien.hotensv) AGAINST ( ? IN BOOLEAN MODE)", array($query))
                    // ->orwhereRaw("MATCH (luanvan.noidungtomtat) AGAINST ( ? IN BOOLEAN MODE)", array($query))
                    // ->orwhereRaw("MATCH (phanloai_lv.tenloailv) AGAINST ( ? IN BOOLEAN MODE)", array($query))
                    // ->orWhere('sv_bv_lv.diem',$query)
                    // ->orWhere('luanvan.malv','like','%'.$query.'%')
                    // ->orWhere('sinhvien.masv','like','%'.$query.'%')
                    // ->orWhere(function($query_thangnam) use ($query)  {
                    //     $query_thangnam->whereMonth('luanvan.thangnam',$query);
                    //  })
                    // ->orWhere(function($query_thangnam) use ($query)  {
                    //     $query_thangnam->whereYear('luanvan.thangnam',$query);
                    //  })
                    ->paginate(10);
        }


    	return view('pages.timkiem',compact('data','timkiem','chon'));
    }
    public function getSVTimKiem(Request $request)
    {
        
    	// removing symbols used by MySQL
        $reservedSymbols = ['-', '+', '<', '>', '@', '(', ')', '~'];
        $query = str_replace($reservedSymbols, '', $request-> search);
    	$timkiem= $request-> search;
        $chon = $request-> sel;
        $data='';
        if($query=="")
            $data=null;
        elseif($request-> sel == 'Tất cả'){
            $data = DB::table('giangvien')
                    ->join('gv_sv_lv', 'gv_sv_lv.magv', '=', 'giangvien.magv')
                    ->join('sinhvien', 'gv_sv_lv.masv', '=', 'sinhvien.masv')
                    ->join('luanvan', 'luanvan.malv', '=', 'gv_sv_lv.malv')
                    ->join('dialuanvan', 'luanvan.malv', '=', 'dialuanvan.malv')
                    ->join('sv_bv_lv', 'sv_bv_lv.masv', '=', 'sinhvien.masv')
                    ->join('phanloai_lv', 'luanvan.maloailv', '=', 'phanloai_lv.maloailv')
        			
        			->select('*')

        			->whereRaw("MATCH (giangvien.hotengv) AGAINST ( ? IN BOOLEAN MODE)", array($query))
        			->orwhereRaw("MATCH (sinhvien.hotensv) AGAINST ( ? IN BOOLEAN MODE)", array($query))
        			->orwhereRaw("MATCH (luanvan.tenlv) AGAINST ( ? IN BOOLEAN MODE)", array($query))
        			->orwhereRaw("MATCH (luanvan.noidungtomtat) AGAINST ( ? IN BOOLEAN MODE)", array($query))
        			->orwhereRaw("MATCH (phanloai_lv.tenloailv) AGAINST ( ? IN BOOLEAN MODE)", array($query))
                    ->orWhere('luanvan.malv','like','%'.$query.'%')
        			->orWhere('sinhvien.masv','like','%'.$query.'%')
    				->orWhere(function($query_thangnam) use ($query)  {
    					$query_thangnam->whereMonth('luanvan.thangnam',$query);
    				 })
    				->orWhere(function($query_thangnam) use ($query)  {
    					$query_thangnam->whereYear('luanvan.thangnam',$query);
    				 })
        			->paginate(10);
        }
        elseif($request-> sel == 'GVHD'){
            $data = DB::table('giangvien')
                    ->join('gv_sv_lv', 'gv_sv_lv.magv', '=', 'giangvien.magv')
                    ->join('sinhvien', 'gv_sv_lv.masv', '=', 'sinhvien.masv')
                    ->join('luanvan', 'luanvan.malv', '=', 'gv_sv_lv.malv')
                    ->join('dialuanvan', 'luanvan.malv', '=', 'dialuanvan.malv')
                    ->join('sv_bv_lv', 'sv_bv_lv.masv', '=', 'sinhvien.masv')
                    ->join('phanloai_lv', 'luanvan.maloailv', '=', 'phanloai_lv.maloailv')
                    
                    ->select('*')

                    ->whereRaw("MATCH (giangvien.hotengv) AGAINST ( ? IN BOOLEAN MODE)", array($query))
                    // ->orwhereRaw("MATCH (luanvan.noidungtomtat) AGAINST ( ? IN BOOLEAN MODE)", array($query))
                    // ->orwhereRaw("MATCH (phanloai_lv.tenloailv) AGAINST ( ? IN BOOLEAN MODE)", array($query))
                    // ->orWhere('luanvan.malv','like','%'.$query.'%')
                    // ->orWhere('sinhvien.masv','like','%'.$query.'%')
                    // ->orWhere(function($query_thangnam) use ($query)  {
                    //     $query_thangnam->whereMonth('luanvan.thangnam',$query);
                    //  })
                    // ->orWhere(function($query_thangnam) use ($query)  {
                    //     $query_thangnam->whereYear('luanvan.thangnam',$query);
                    //  })
                    ->paginate(10);
        }
        elseif($request-> sel == 'Sinh viên'){
            $data = DB::table('giangvien')
                    ->join('gv_sv_lv', 'gv_sv_lv.magv', '=', 'giangvien.magv')
                    ->join('sinhvien', 'gv_sv_lv.masv', '=', 'sinhvien.masv')
                    ->join('luanvan', 'luanvan.malv', '=', 'gv_sv_lv.malv')
                    ->join('dialuanvan', 'luanvan.malv', '=', 'dialuanvan.malv')
                    ->join('sv_bv_lv', 'sv_bv_lv.masv', '=', 'sinhvien.masv')
                    ->join('phanloai_lv', 'luanvan.maloailv', '=', 'phanloai_lv.maloailv')
                    
                    ->select('*')

                    ->whereRaw("MATCH (sinhvien.hotensv) AGAINST ( ? IN BOOLEAN MODE)", array($query))
                    // ->orwhereRaw("MATCH (luanvan.noidungtomtat) AGAINST ( ? IN BOOLEAN MODE)", array($query))
                    // ->orwhereRaw("MATCH (phanloai_lv.tenloailv) AGAINST ( ? IN BOOLEAN MODE)", array($query))
                    // ->orWhere('luanvan.malv','like','%'.$query.'%')
                    // ->orWhere('sinhvien.masv','like','%'.$query.'%')
                    // ->orWhere(function($query_thangnam) use ($query)  {
                    //     $query_thangnam->whereMonth('luanvan.thangnam',$query);
                    //  })
                    // ->orWhere(function($query_thangnam) use ($query)  {
                    //     $query_thangnam->whereYear('luanvan.thangnam',$query);
                    //  })
                    ->paginate(10);
        }
         
    	return view('pages.timkiem',compact('data','timkiem','chon'));
    }
}
