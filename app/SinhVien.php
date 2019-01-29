<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class SinhVien extends Model
{
    protected $table ="sinhvien";
    public $primaryKey= 'masv';
    public $incrementing = false;
    
    public function gv_sv_lv()
    {
    	return $this->hasMany('App\GV_SV_LV','masv', 'masv');
    }

    public function sv_bv_lv()
    {
    	return $this->hasMany('App\SV_BV_LV','masv','masv');
    }
    public function quyen()
    {
        return $this->hasOne('App\Quyen','maquyen','maquyen');
    }
}
