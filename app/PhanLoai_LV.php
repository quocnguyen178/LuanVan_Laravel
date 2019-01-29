<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PhanLoai_LV extends Model
{
    protected $table='phanloai_lv';
    public $primaryKey= 'maloailv';
    public $incrementing = false;

    public function luanvan()
    {
    	return $this->hasMany('App\LuanVan', 'maloailv','maloailv');
    }

    public function gv_sv_lv()
    {
    	return $this->hasManyThrough('App\GV_SV_LV', 'App\LuanVan', 'maloailv','malv','maloailv');
    }
}
