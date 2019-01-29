<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GiangVien extends Model
{
    protected $table ="giangvien";
    public $primaryKey= 'magv';
    public $incrementing = false;
    public function gv_sv_lv()
    {
    	return $this->hasMany('App\GV_SV_LV','magv', 'magv');
    }
    
    public function gv_sdt()
    {
    	return $this->hasMany('App\GV_SDT','magv','magv');
    }

    public function gv_quyen()
    {
        return $this->hasMany('App\GV_Quyen','magv','magv');
    }
}
