<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\GV_SV_LV;
use App\SinhVien;
use App\GiangVien;
use App\LuanVan;
use App\SV_BV_LV;

class GV_SV_LVController extends Controller
{
    public function getDanhSach()
    {
    	$huongdan = GV_SV_LV::all();
    	return view('admin.gv_sv_lv.danhsach',compact('huongdan'));
    }

    public function getThem(Request $request)
    {
    	$sinhvien = SinhVien::all();
    	$giangvien = GiangVien::all();
    	$luanvan = LuanVan::all();
    	return view('admin.gv_sv_lv.them',compact('sinhvien','giangvien','luanvan'));
    }
    public function getquaylai()    {
        return view('admin.gv_sv_lv.xoatiep');
    }
    public function postSua(Request $request, $id, $idgv, $idlv)
    {
        $this-> validate($request,
            [
             'ngaybd' => 'required|date|date_format:"d-m-Y"',
             'ngaykt' => 'required|date|date_format:"d-m-Y"|after:ngaybd',
             'phantramhd' => 'required|numeric'
             
            ],

            [
                'required' => ':attribute không được để trống',
                'date' => ':attribute sai định dạng',
                'date_format'=>':attribute sai định dạng',
                'numeric' => ':attribute phải là số',
                'after' => ':attribute phải sau ngày bắt đầu'
            ],

            [
                'ngaybd' => 'Ngày bắt đầu',
                'ngaykt' => 'Ngày kết thúc',
                'phantramhd' => 'Phần trăm hướng dẫn'
            ]
        );
        //dd($request->magv);
        $huongdan = GV_SV_LV::where('masv',$id)
                            ->where('magv',$idgv)
                            ->where('malv',$idlv)->first();
                            //dd($huongdan);
        $lv=LuanVan::find($idlv);
        $malv=$request->malv;
        $luanvan=LuanVan::find($malv);
        $ngaykt=$huongdan-> ngaykt;
        $ngaybd=$huongdan-> ngaybd;
        $bd=date('d-m-Y', strtotime($ngaybd));
        $kt=date('d-m-Y', strtotime($ngaykt));
        $pt=$huongdan-> phantramhd;
        $pt1=$request->phantramhd;
        $tnop=date('m-Y', strtotime($lv->thangnam));
        $thangnop=substr($tnop,0,2);
        $namnop=substr($tnop,5,2);
        $thanglv=date('m',strtotime($lv->thangnam));
        $namlv=date('y',strtotime($lv->thangnam));
        $namlv1=date('y',strtotime($lv->thangnam));
        $thanghd=date('m',strtotime($request->ngaybd));
        $namhd=date('y',strtotime($request->ngaybd));
        $namhd1=date('y',strtotime($request->ngaybd));
        $magv=substr($request->magv,0,5);
        $ngaybatdau=date('Y-m-d', strtotime($request->ngaybd));
        $ngayketthuc=date('Y-m-d', strtotime($request->ngaykt));
        $masvhide=$request->masvhide;
        $magvhide=$request->magvhide;
        $malvhide=$request->malvhide;
        if($request->phantramhd<100)
        {

            $giangvien=giangvien::all();
            return view('admin/gv_sv_lv/suathem',compact('huongdan','giangvien','tnop','thangnop','namnop','bd','kt','pt','pt1','thanglv','namlv','malv','luanvan','magv','ngaybatdau','ngayketthuc','malvhide','magvhide','masvhide'));
        } 
        else 
        {$hd = GV_SV_LV::where('masv',$id)
                            ->where('magv',$idgv)
                            ->where('malv',$idlv)
                            ->update(['masv'=> substr($request-> masv,0,10),
                             'magv'=> substr($request-> magv,0,5),
                             'malv'=> substr($request-> malv,0,8),
                             'ngaybd'=> date('Y-m-d', strtotime($request-> ngaybd)),
                             'ngaykt'=> date('Y-m-d', strtotime($request-> ngaykt)),
                             'phantramhd'=> $request-> phantramhd
                            ]);
        $hd3 =GV_SV_LV::where('masv',$id)
                            ->where('magv','!=',$idgv)
                            ->where('malv',$idlv)
                            ->update(['masv'=> substr($request-> masv,0,10),
                             'magv'=> $request-> gv1,
                             'malv'=> substr($request-> malv,0,8),
                             'ngaybd'=> date('Y-m-d', strtotime($request-> bd1)),
                             'ngaykt'=> date('Y-m-d', strtotime($request-> kt1)),
                             'phantramhd'=> $request-> pt1
                            ]);
        return redirect()->route('gv_sv_lv.danhsach')->with('thongbao','Sửa thành công');}
    }   
     public function postSua1(Request $request, $id, $idgv, $idlv)
    {
        $this-> validate($request,
            [
             'ngaybd' => 'required|date|date_format:"d-m-Y"',
             'ngaykt' => 'required|date|date_format:"d-m-Y"|after:ngaybd',
             'phantramhd' => 'required|numeric'
            ],

            [
                'required' => ':attribute không được để trống',
                'date' => ':attribute sai định dạng',
                'date_format'=>':attribute sai định dạng',
                'numeric' => ':attribute phải là số',
                'after' => ':attribute phải sau ngày bắt đầu'
            ],

            [
                'ngaybd' => 'Ngày bắt đầu',
                'ngaykt' => 'Ngày kết thúc',
                'phantramhd' => 'Phần trăm hướng dẫn'
            ]
        );
        $lv=LuanVan::find($idlv);
        $thanglv=date('m',strtotime($lv->thangnam));
        $namlv=date('y',strtotime($lv->thangnam));
        $namlv1=date('y',strtotime($lv->thangnam));
        $thanghd=date('m',strtotime($request->ngaybd));
        $namhd=date('y',strtotime($request->ngaybd));
        $namhd1=date('y',strtotime($request->ngaybd));  
        $hd = GV_SV_LV::where('masv',$id)
                            ->where('magv',$idgv)
                            ->where('malv',$idlv)
                            ->update(['masv'=> substr($request-> masv,0,10),
                             'magv'=> substr($request-> magv,0,5),
                             'malv'=> substr($request-> malv,0,8),
                             'ngaybd'=> date('Y-m-d', strtotime($request-> ngaybd)),
                             'ngaykt'=> date('Y-m-d', strtotime($request-> ngaykt)),
                             'phantramhd'=> $request-> phantramhd
                            ]);
        $hd1 =GV_SV_LV::where('masv',$id)
                            ->where('magv','!=',$idgv)
                            ->where('malv',$idlv)
                            ->update(['masv'=> substr($request-> masv,0,10),
                             'magv'=> $request-> gv1,
                             'malv'=> substr($request-> malv,0,8),
                             'ngaybd'=> date('Y-m-d', strtotime($request-> bd1)),
                             'ngaykt'=> date('Y-m-d', strtotime($request-> kt1)),
                             'phantramhd'=> $request-> pt1
                            ]);
        return redirect()->route('gv_sv_lv.danhsach')->with('thongbao','Sửa thành công');
    }
    public function postThem(Request $request)
    {
    	$this-> validate($request,
    		[
             'ngaybd' => 'required|date|date_format:"d-m-Y"',
             'ngaykt' => 'required|date|date_format:"d-m-Y"|after:ngaybd',
             'phantramhd' => 'required|numeric|min:1|max:100',
             'malv' => 'required'
            ],

            [
                'required' => ':attribute không được để trống',
                'date_format' => ':attribute sai định dạng',
                'date' => ':attribute sai định dạng',
                'numeric' => ':attribute phải là số',
                'after' => ':attribute phải sau ngày bắt đầu',
                'min' => ':attribute thấp nhất phải là 1',
                'max' => ':attribute không được lớn hơn 100'
            ],

            [
                'ngaybd' => 'Ngày bắt đầu',
                'ngaykt' => 'Ngày kết thúc',
                'phantramhd' => 'Phần trăm hướng dẫn',
                'malv' => 'Mã luận văn'
            ]
    	);
        $sinhv = GV_SV_LV::where('masv', $request-> masv)
                        ->where('malv', $request-> malv)
                        ->first();
        if(isset($sinhv))
            return redirect()->back()->with('thongbao','Sinh viên thực hiện luận văn này đã đủ 100% hướng dẫn rồi');
        $lv=LuanVan::find($request-> malv);
        $thanglv=date('m',strtotime($lv->thangnam));
        $namlv=date('y',strtotime($lv->thangnam));
        $namlv1=date('y',strtotime($lv->thangnam));
        $thanghd=date('m',strtotime($request->ngaybd));
        $namhd=date('y',strtotime($request->ngaybd));
        $namhd1=date('y',strtotime($request->ngaybd));
        $thangkt=date('m',strtotime($request->ngaykt));
        $namkt=date('y',strtotime($request->ngaykt));
        $magv=$request->magv;
        //dd($namkt,$namlv,$thanglv,$thangkt);
        if($namkt!=$namlv )
        {
            return redirect()->back()->with('thongbao','Năm kết thúc phải trùng với năm nộp luận văn');
        }
        if($thanglv!=$thangkt)
        {
            return redirect()->back()->with('thongbao','Tháng  kết thúc phải trùng với tháng nộp luận văn');
        }
        if($thanglv==1 ) 
        { if(($thanglv-$thanghd)==-9 || ($thanglv-$thanghd)==-10 || ($thanglv-$thanghd)==-11  && $namlv=$namhd1-1)
            {
        $huongdan = new GV_SV_LV;
        $huongdan-> masv = $request-> masv;
        $huongdan-> magv = $request-> magv;
        $huongdan-> malv = $request-> malv;
        $huongdan-> ngaybd = date('Y-m-d', strtotime($request-> ngaybd));
        $huongdan-> ngaykt = date('Y-m-d', strtotime($request-> ngaykt));
        $huongdan-> phantramhd = $request-> phantramhd;
        if($huongdan-> phantramhd<100)
        {
            $masv=$huongdan-> masv;
            $magv=$huongdan-> magv;
            $malv=$huongdan-> malv;
            $ngaykt=$huongdan-> ngaykt;
            $ngaybd=$huongdan-> ngaybd;
            $pt=$huongdan-> phantramhd;
            $bd=date('d-m-Y', strtotime($ngaybd));
            $bd1=date('m',strtotime($bd));
            $kt=date('d-m-Y', strtotime($ngaykt));
            $kt1=$bt1=date('Y',strtotime($kt));
            $sinhvien = SinhVien::find($masv);
            $giangvien = GiangVien::all();
            $luanvan = LuanVan::find($malv);
            $huongdan = GV_SV_LV::where('masv',$huongdan-> masv)->where('magv',$huongdan-> magv)->where('malv',$huongdan-> malv)->get();
            return view('admin.gv_sv_lv.nhaplai',compact('huongdan','masv','magv','malv','sinhvien','giangvien','luanvan','bd','kt','bd1','kt1','pt','thanglv','thanghd','namlv','namhd','magv'));
        }
        $huongdan-> save();
        return redirect()->route('gv_sv_lv.danhsach')->with('thongbao','Thêm thành công');}
        if(($thanglv-$thanghd)==0 && $namlv==$namhd)
            {
        $huongdan = new GV_SV_LV;
        $huongdan-> masv = $request-> masv;
        $huongdan-> magv = $request-> magv;
        $huongdan-> malv = $request-> malv;
        $huongdan-> ngaybd = date('Y-m-d', strtotime($request-> ngaybd));
        $huongdan-> ngaykt = date('Y-m-d', strtotime($request-> ngaykt));
        $huongdan-> phantramhd = $request-> phantramhd;
        if($huongdan-> phantramhd<100)
        {
            $masv=$huongdan-> masv;
            $magv=$huongdan-> magv;
            $malv=$huongdan-> malv;
            $ngaykt=$huongdan-> ngaykt;
            $ngaybd=$huongdan-> ngaybd;
            $pt=$huongdan-> phantramhd;
            $bd=date('d-m-Y', strtotime($ngaybd));
            $bd1=date('m',strtotime($bd));
            $kt=date('d-m-Y', strtotime($ngaykt));
            $kt1=$bt1=date('Y',strtotime($kt));
            $sinhvien = SinhVien::find($masv);
            $giangvien = GiangVien::all();
            $luanvan = LuanVan::find($malv);
            $huongdan = GV_SV_LV::where('masv',$huongdan-> masv)->where('magv',$huongdan-> magv)->where('malv',$huongdan-> malv)->get();
            return view('admin.gv_sv_lv.nhaplai',compact('huongdan','masv','magv','malv','sinhvien','giangvien','luanvan','bd','kt','bd1','kt1','pt','thanglv','thanghd','namlv','namhd','magv'));
        }
        $huongdan-> save();

        return redirect()->route('gv_sv_lv.danhsach')->with('thongbao','Thêm thành công');}

        return redirect()->back()->with('thongbao','Tháng hướng dẫn phải trước tháng nộp ít nhất 4 tháng');
    }
    if($thanglv==2 ) 
        { if(($thanglv-$thanghd)==-9 || ($thanglv-$thanghd)==-10 || ($thanglv-$thanghd)==-8  && $namlv=$namhd1-1)
            {
        $huongdan = new GV_SV_LV;
        $huongdan-> masv = $request-> masv;
        $huongdan-> magv = $request-> magv;
        $huongdan-> malv = $request-> malv;
        $huongdan-> ngaybd = date('Y-m-d', strtotime($request-> ngaybd));
        $huongdan-> ngaykt = date('Y-m-d', strtotime($request-> ngaykt));
        $huongdan-> phantramhd = $request-> phantramhd;
        if($huongdan-> phantramhd<100)
        {
            $masv=$huongdan-> masv;
            $magv=$huongdan-> magv;
            $malv=$huongdan-> malv;
            $ngaykt=$huongdan-> ngaykt;
            $ngaybd=$huongdan-> ngaybd;
            $pt=$huongdan-> phantramhd;
            $bd=date('d-m-Y', strtotime($ngaybd));
            $bd1=date('m',strtotime($bd));
            $kt=date('d-m-Y', strtotime($ngaykt));
            $kt1=$bt1=date('Y',strtotime($kt));
            $sinhvien = SinhVien::find($masv);
            $giangvien = GiangVien::all();
            $luanvan = LuanVan::find($malv);
            $huongdan = GV_SV_LV::where('masv',$huongdan-> masv)->where('magv',$huongdan-> magv)->where('malv',$huongdan-> malv)->get();
            return view('admin.gv_sv_lv.nhaplai',compact('huongdan','masv','magv','malv','sinhvien','giangvien','luanvan','bd','kt','bd1','kt1','pt','thanglv','thanghd','namlv','namhd','magv'));
        }
        $huongdan-> save();
        return redirect()->route('gv_sv_lv.danhsach')->with('thongbao','Thêm thành công');}
        if(($thanglv-$thanghd)==0 && $namlv==$namhd)
            {
        $huongdan = new GV_SV_LV;
        $huongdan-> masv = $request-> masv;
        $huongdan-> magv = $request-> magv;
        $huongdan-> malv = $request-> malv;
        $huongdan-> ngaybd = date('Y-m-d', strtotime($request-> ngaybd));
        $huongdan-> ngaykt = date('Y-m-d', strtotime($request-> ngaykt));
        $huongdan-> phantramhd = $request-> phantramhd;
        if($huongdan-> phantramhd<100)
        {
            $masv=$huongdan-> masv;
            $magv=$huongdan-> magv;
            $malv=$huongdan-> malv;
            $ngaykt=$huongdan-> ngaykt;
            $ngaybd=$huongdan-> ngaybd;
            $pt=$huongdan-> phantramhd;
            $bd=date('d-m-Y', strtotime($ngaybd));
            $bd1=date('m',strtotime($bd));
            $kt=date('d-m-Y', strtotime($ngaykt));
            $kt1=$bt1=date('Y',strtotime($kt));
            $sinhvien = SinhVien::find($masv);
            $giangvien = GiangVien::all();
            $luanvan = LuanVan::find($malv);
            $huongdan = GV_SV_LV::where('masv',$huongdan-> masv)->where('magv',$huongdan-> magv)->where('malv',$huongdan-> malv)->get();
            return view('admin.gv_sv_lv.nhaplai',compact('huongdan','masv','magv','malv','sinhvien','giangvien','luanvan','bd','kt','bd1','kt1','pt','thanglv','thanghd','namlv','namhd','magv'));
        }
        $huongdan-> save();

        return redirect()->route('gv_sv_lv.danhsach')->with('thongbao','Thêm thành công');}

        return redirect()->back()->with('thongbao','Tháng hướng dẫn phải trước tháng nộp ít nhất 4 tháng');
    }
    if($thanglv==7 ) 
        { if(($thanglv-$thanghd)<=3 && ($thanglv-$thanghd)>=0 && $namlv==$namhd)
            {
        $huongdan = new GV_SV_LV;
        $huongdan-> masv = $request-> masv;
        $huongdan-> magv = $request-> magv;
        $huongdan-> malv = $request-> malv;
        $huongdan-> ngaybd = date('Y-m-d', strtotime($request-> ngaybd));
        $huongdan-> ngaykt = date('Y-m-d', strtotime($request-> ngaykt));
        $huongdan-> phantramhd = $request-> phantramhd;
        if($huongdan-> phantramhd<100)
        {
            $masv=$huongdan-> masv;
            $magv=$huongdan-> magv;
            $malv=$huongdan-> malv;
            $ngaykt=$huongdan-> ngaykt;
            $ngaybd=$huongdan-> ngaybd;
            $pt=$huongdan-> phantramhd;
            $bd=date('d-m-Y', strtotime($ngaybd));
            $bd1=date('m',strtotime($bd));
            $kt=date('d-m-Y', strtotime($ngaykt));
            $kt1=$bt1=date('Y',strtotime($kt));
            $sinhvien = SinhVien::find($masv);
            $giangvien = GiangVien::all();
            $luanvan = LuanVan::find($malv);
            $huongdan = GV_SV_LV::where('masv',$huongdan-> masv)->where('magv',$huongdan-> magv)->where('malv',$huongdan-> malv)->get();
            return view('admin.gv_sv_lv.nhaplai',compact('huongdan','masv','magv','malv','sinhvien','giangvien','luanvan','bd','kt','bd1','kt1','pt','thanglv','thanghd','namlv','namhd','magv'));
        }
        $huongdan-> save();

        return redirect()->route('gv_sv_lv.danhsach')->with('thongbao','Thêm thành công');} 
        return redirect()->back()->with('thongbao','Tháng hướng dẫn phải trước tháng nộp ít nhất 4 tháng ');
    }
    if($thanglv==8 ) 
        { if(($thanglv-$thanghd)<=4 && ($thanglv-$thanghd)>=0 && $namlv==$namhd)
            {
        $huongdan = new GV_SV_LV;
        $huongdan-> masv = $request-> masv;
        $huongdan-> magv = $request-> magv;
        $huongdan-> malv = $request-> malv;
        $huongdan-> ngaybd = date('Y-m-d', strtotime($request-> ngaybd));
        $huongdan-> ngaykt = date('Y-m-d', strtotime($request-> ngaykt));
        $huongdan-> phantramhd = $request-> phantramhd;
        if($huongdan-> phantramhd<100)
        {
            $masv=$huongdan-> masv;
            $magv=$huongdan-> magv;
            $malv=$huongdan-> malv;
            $ngaykt=$huongdan-> ngaykt;
            $ngaybd=$huongdan-> ngaybd;
            $pt=$huongdan-> phantramhd;
            $bd=date('d-m-Y', strtotime($ngaybd));
            $bd1=date('m',strtotime($bd));
            $kt=date('d-m-Y', strtotime($ngaykt));
            $kt1=$bt1=date('Y',strtotime($kt));
            $sinhvien = SinhVien::find($masv);
            $giangvien = GiangVien::all();
            $luanvan = LuanVan::find($malv);
            $huongdan = GV_SV_LV::where('masv',$huongdan-> masv)->where('magv',$huongdan-> magv)->where('malv',$huongdan-> malv)->get();
            return view('admin.gv_sv_lv.nhaplai',compact('huongdan','masv','magv','malv','sinhvien','giangvien','luanvan','bd','kt','bd1','kt1','pt','thanglv','thanghd','namlv','namhd','magv'));
        }
        $huongdan-> save();

        return redirect()->route('gv_sv_lv.danhsach')->with('thongbao','Thêm thành công');} 
        return redirect()->back()->with('thongbao','Tháng hướng dẫn phải trước tháng nộp ít nhất 4 tháng ');
    }
    }

     public function getxoa1($id,$idgv,$idlv)
    {
        //$sinhvien = SinhVien::find($id);
        $giangvien = GiangVien::all();
        $luanvan = LuanVan::find($idlv);
        $thanglv=date('m',strtotime($luanvan->thangnam));
        $namlv=date('y',strtotime($luanvan->thangnam));
        $huongdan = GV_SV_LV::where('masv',$id)
                             ->where('malv',$idlv)
                             ->where('magv',$idgv)->first();

        $bd=date('d-m-Y', strtotime($huongdan->ngaybd));
        $kt=date('d-m-Y', strtotime($huongdan->ngaykt));
        /*$hd = GV_SV_LV::where('masv',$id)
         ->where('malv',$idlv)
         ->where('magv','!=',$idgv)->first();*/
        $pt=$huongdan->phantramhd;
        return view('admin.gv_sv_lv.xoathem',compact('huongdan','sinhvien','giangvien','luanvan','thanglv','namlv','pt','bd','kt'));
    }
     public function getxoa3(Request $request,$id,$idgv,$idlv)
    {
        $huongdan = GV_SV_LV::where('masv',$id)
                             ->where('malv',$idlv)
                             ->where('magv',$idgv) ->update([
                             'masv' => substr($request-> masv,0,10),
                             'magv' => substr($request-> magv,0,5),
                             'malv' => substr($request-> malv,0,8),
                             'ngaybd'=> date('Y-m-d', strtotime($request-> ngaybd)),
                             'ngaykt'=> date('Y-m-d', strtotime($request-> ngaykt)),
                             'phantramhd'=> $request->phantramhd
                            ]);
       return redirect()->route('gv_sv_lv.danhsach')->with('thongbao','Xóa thành công');
    }
    public function getxoa2(Request $request,$id,$idgv,$idlv)
    {
        $giangvien = GiangVien::all();
        $luanvan = LuanVan::find($idlv);
        $thanglv=date('m',strtotime($luanvan->thangnam));
        $namlv=date('y',strtotime($luanvan->thangnam));
        $hd = GV_SV_LV::where('masv',$id)
                             ->where('malv',$idlv)
                             ->where('magv',$idgv)->delete();
        $huongdan = new GV_SV_LV;
        $huongdan-> masv = substr($request-> masv,0,10);
        $huongdan-> magv = $request-> magv;
        $huongdan-> malv = substr($request-> malv,0,5);
        $huongdan-> ngaybd = date('Y-m-d', strtotime($request-> ngaybd));
        $huongdan-> ngaykt = date('Y-m-d', strtotime($request-> ngaykt));
        $huongdan-> phantramhd = $request-> phantramhd;
        $huongdan->save();
        return redirect()->route('gv_sv_lv.danhsach')->with('thongbao','Thêm thành công');
    }

    public function postsuaThemhd(Request $request)
     {
        $this-> validate($request,
            [
             'phantramhd' => 'required|numeric|min:1|max:100',
             'magv' =>'required'
            ],

            [
                'required' => ':attribute không được để trống',
                'numeric' => ':attribute phải là số',
                'min' => ':attribute thấp nhất phải là 1',
                'max' => ':attribute không được lớn hơn 100'
            ],

            [
                'phantramhd' => 'Phần trăm hướng dẫn',
                'magv' => 'Giảng viên'
            ]
        );
        
        $hd1 = gv_sv_lv::where('masv',$request-> masvhide)
                        ->where('magv',$request-> magvhide)
                        ->where('malv',$request-> malvhide)
                        ->update([
                             'masv' => substr( $request-> masv,  0, 10),
                             'magv' => substr( $request-> magv,  0, 5),
                             'malv' => substr( $request-> malv,  0, 8),
                             'ngaybd'=> date('Y-m-d', strtotime($request-> ngaybd)),
                             'ngaykt'=> date('Y-m-d', strtotime($request-> ngaykt)),
                             'phantramhd'=> $request->pt
                            ]);
        // $huongdan1=new gv_sv_lv;
        // $huongdan1->masv=substr( $request-> masv,  0, 10);
        // $huongdan1->magv=substr( $request-> magv,  0, 5);
        // $huongdan1->malv=substr( $request-> malv,  0, 8);
        // $huongdan1->ngaybd=date('Y-m-d', strtotime($request->ngaybatdau));
        // $huongdan1->ngaykt=date('Y-m-d', strtotime($request->ngayketthuc));
        // $huongdan1->phantramhd=$request->pt;

        $huongdan2=new gv_sv_lv;
        $huongdan2->masv=substr( $request-> masv,  0, 10);
        $huongdan2->magv=substr( $request-> gv1,  0, 5);
        $huongdan2->malv=substr( $request-> malv,  0, 8);
        $huongdan2->ngaybd=date('Y-m-d', strtotime($request->ngaybd));
        $huongdan2->ngaykt=date('Y-m-d', strtotime($request->ngaykt));
        $huongdan2->phantramhd=$request->phantramhd;
        $huongdan2-> save();
         return redirect()->route('gv_sv_lv.danhsach')->with('thongbao','Sửa thành công');
     } 

    public function postnhaplai(Request $request)
    {
        $this-> validate($request,
            [
             'phantramhd' => 'required|numeric|min:1|max:100',
             'magv' =>'required'
            ],

            [
                'required' => ':attribute không được để trống',
                'numeric' => ':attribute phải là số',
                'min' => ':attribute thấp nhất phải là 1',
                'max' => ':attribute không được lớn hơn 100'
            ],

            [
                'phantramhd' => 'Phần trăm hướng dẫn',
                'magv' => 'Giảng viên'
            ]
        );
        $huongdan1=new gv_sv_lv;
        $huongdan1->masv=substr( $request-> masv,  0, 10);
        $huongdan1->magv=substr( $request-> magv1,  0, 5);
        $huongdan1->malv=substr( $request-> malv,  0, 8);
        $huongdan1->ngaybd=date('Y-m-d', strtotime($request->bd1));
        $huongdan1->ngaykt=date('Y-m-d', strtotime($request->kt1));
        $huongdan1->phantramhd=$request->pt1;

        $huongdan2=new gv_sv_lv;
        $huongdan2->masv=substr( $request-> masv,  0, 10);
        $huongdan2->magv=substr( $request-> magv,  0, 5);
        $huongdan2->malv=substr( $request-> malv,  0, 8);
        $huongdan2->ngaybd=date('Y-m-d', strtotime($request->ngaybd));
        $huongdan2->ngaykt=date('Y-m-d', strtotime($request->ngaykt));
        $huongdan2->phantramhd=$request->phantramhd;

        $huongdan2->save();
        $huongdan1->save();
        return redirect()->route('gv_sv_lv.danhsach')->with('thongbao','Thêm thành công');
    }
    public function getXoa($id, $idgv, $idlv)
    {
        $kt = SV_BV_LV::where('masv',$id)
                ->where('malv',$idlv)
                ->first();
        if(isset($kt))
            return redirect()->back()-> with('thongbao', 'Không thể xóa hướng dẫn này do sinh viên đã có điểm');
    	$huongdan=GV_SV_LV::where('masv',$id)
                ->where('magv',$idgv)
                ->where('malv',$idlv)->first();
        if($huongdan->phantramhd==100)
        {$huongdan=GV_SV_LV::where('masv',$id)
                ->where('magv',$idgv)
                ->where('malv',$idlv)->delete();
        return redirect()->route('gv_sv_lv.danhsach')->with('thongbao','Xóa thành công');}
        else
        {
            return view('admin.gv_sv_lv.xoatiep',compact('huongdan','id','idgv','idlv'));
        }        
                
    	
    }

     public function getXoatiep($id, $idgv, $idlv)
    {
        //dd($id);
        $huongdan=GV_SV_LV::where('masv',$id)
                ->where('magv',$idgv)
                ->where('malv',$idlv)->delete();
        $hd=GV_SV_LV::where('masv',$id)
                            ->where('malv',$idlv)
                            ->where('magv','!=',$idgv)->delete();
         return redirect()->route('gv_sv_lv.danhsach')->with('thongbao','Xóa thành công');
        
    }
    public function getSua($id, $idgv, $idlv)
    {
    	$huongdan = GV_SV_LV::where('masv',$id)
                            ->where('magv',$idgv)
                            ->where('malv',$idlv)
                            ->first();
                            //dd($huongdan->masv);
        if($huongdan->phantramhd<100)
    	{$sinhvien = SinhVien::find($id);//dd($sinhvien);
    	$giangvien = GiangVien::all();
    	$luanvan = LuanVan::all();
        $lv=LuanVan::find($idlv);
        $tnop=date('m-Y', strtotime($lv->thangnam));
        $thangnop=substr($tnop,0,2);
        $namnop=substr($tnop,5,2);
    	return view('admin.gv_sv_lv.suatiep',compact('huongdan','sinhvien','giangvien','luanvan','lv','tnop','thangnop','namnop'));}
        else
        {
        $sinhvien = SinhVien::all();
        $giangvien = GiangVien::all();
        $luanvan = LuanVan::all();
        $lv=LuanVan::find($idlv);
        $tnop=date('m-Y', strtotime($lv->thangnam));
        $thangnop=substr($tnop,0,2);
        $namnop=substr($tnop,5,2);
        //dd($luanvan);
            return view('admin.gv_sv_lv.sua',compact('huongdan','sinhvien','giangvien','luanvan','lv','tnop','thangnop','namnop'));
        }
    }
     public function getsuatiep($id, $idgv, $idlv)
    {
       $huongdan = GV_SV_LV::where('masv',$id)
                            ->where('malv',$idlv)
                            //->last();
                            //->where('malv',$idlv)
                            ->where('magv','!=',$idgv)->first();
                            
        $hd = GV_SV_LV::where('masv',$id)
                            ->where('malv',$idlv)
                            //->last();
                            //->where('malv',$idlv)
                            ->where('magv',$idgv)->first();
        //return view('admin.gv_sv_lv.suatieptheo',compact('huongdan','hd'));
    }
    public function postsuatiep(Request $request, $id, $idgv, $idlv)
    {
        $this-> validate($request,
            [
             'ngaybd' => 'required|date|date_format:"d-m-Y"',
             'ngaykt' => 'required|date|date_format:"d-m-Y"|after:ngaybd',
             'phantramhd' => 'required|numeric'
            ],

            [
                'required' => ':attribute không được để trống',
                'date' => ':attribute sai định dạng',
                'date_format'=>':attribute sai định dạng',
                'numeric' => ':attribute phải là số',
                'after' => ':attribute phải sau ngày bắt đầu'
            ],

            [
                'ngaybd' => 'Ngày bắt đầu',
                'ngaykt' => 'Ngày kết thúc',
                'phantramhd' => 'Phần trăm hướng dẫn'
            ]
        );
        $huongdan = GV_SV_LV::where('masv',$id)
                            ->where('malv',$idlv)
                            ->where('magv','!=',$idgv)->first();
        $hd = GV_SV_LV::where('masv',$id)
                            ->where('malv',$idlv)
                            ->where('magv',$idgv)->first();
        if(($request->phantramhd )<100)
        {
            if(($request->phantramhd)+($huongdan->phantramhd)==100)
            {
                $hd = GV_SV_LV::where('masv',$id)
                            ->where('malv',$idlv)
                            ->where('magv',$idgv)->update([
                             'ngaybd'=> date('Y-m-d', strtotime($request-> ngaybd)),
                             'ngaykt'=> date('Y-m-d', strtotime($request-> ngaykt))
                            ]);
                return redirect()->route('gv_sv_lv.danhsach')->with('thongbao','Sửa thành công');
            }
            else
            {
                $a=$request->phantramhd;
                $lv=LuanVan::find($idlv);
                $tnop=date('m-Y', strtotime($lv->thangnam));
                $thangnop=substr($tnop,0,2);
                $namnop=substr($tnop,5,2);   
            return view('admin.gv_sv_lv.suatieptheo',compact('huongdan','hd','a','thangnop','namnop','tnop'));}
        }
    }
}
