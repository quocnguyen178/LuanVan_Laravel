<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class GV_SV_LV extends Model
{
    protected $table='gv_sv_lv';

    public function giangvien()
    {
    	return $this->belongsTo('App\GiangVien','magv', 'magv');
    }

    public function sinhvien()
    {
    	return $this-> belongsTo('App\SinhVien', 'masv', 'masv');
    }

    public function luanvan()
    {
    	return $this-> belongsTo('App\LuanVan','malv','malv');
    }
}
