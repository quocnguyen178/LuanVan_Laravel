<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\GV_SV_LV;
use App\luanvan;
class AjaxController extends Controller
{
    public function getGiangVien($masv, $malv)
    {
    	$giangvien = GV_SV_LV::where('masv', $masv)-> where('malv',$malv)-> get();
    	$dem = count($giangvien);
    	$i= 1;
    	if($dem == 0)
    	{
    		echo "<span>Chưa có giảng viên hướng dẫn</span>";
    	}else{
    		foreach ($giangvien as $gv) {
	    		echo "<span>".$gv-> giangvien-> hotengv."</span>";
	    		if($i >= 1 && $i < $dem ){
	    			echo " - ";
	    		}
	    		$i++;
    		}
    	}	
    }
    public function getLuanVan($masv)
    {
    	$luanvan = GV_SV_LV::where('masv', $masv)-> get();
		foreach ($luanvan as $lv) {
    		echo "<option value=".$lv -> malv .">".$lv -> malv ."-". $lv-> luanvan-> tenlv."</option>";
		}
    		
    }
     public function getthangnop($malv)
    {
        $lv=luanvan::where('malv', $malv)-> first();//dd($lv);
        $a=date('m-Y', strtotime($lv-> thangnam));
            //dd($lv->luanvan-> thangnam);
            echo "<span>".$a."</span>";       
    }
}
