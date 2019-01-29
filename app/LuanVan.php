<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LuanVan extends Model
{
    protected $table="luanvan";
    public $primaryKey= 'malv';
    public $incrementing = false;

    public function gv_sv_lv()
    {
    	return $this-> hasMany('App\GV_SV_LV','malv','malv');
    }
    public function sv_bv_lv()
    {
    	return $this-> hasMany('App\SV_BV_LV','malv','malv');
    }
    public function phanloai_lv()
    {
    	return $this-> belongsTo('App\PhanLoai_LV','maloailv','maloailv');
    }
    public function dialuanvan()
    {
    	return $this->hasOne('App\DiaLuanVan','malv','malv');
    }
}
