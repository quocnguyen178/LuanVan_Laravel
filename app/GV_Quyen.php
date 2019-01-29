<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GV_Quyen extends Model
{
    protected $table= 'gv_quyen';

    public function giangvien()
    {
    	return $this-> belongsTo('App\GiangVien','magv','magv');
    }
    public function quyen()
    {
    	return $this-> belongsTo('App\Quyen','maquyen','maquyen');
    }
}
