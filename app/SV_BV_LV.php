<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SV_BV_LV extends Model
{
    protected $table='sv_bv_lv';
    

    public function sinhvien()
    {
    	return $this-> belongsTo('App\SinhVien','masv','masv');
    }
    public function luanvan()
    {
    	return $this-> belongsTo('App\LuanVan','malv','malv');
    }
}
