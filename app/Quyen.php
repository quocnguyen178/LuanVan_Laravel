<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quyen extends Model
{
    protected $table='quyen';
    public $primaryKey= 'maquyen';
    public $incrementing = false;

    public function user()
    {
    	return $this->hasMany('App\User','maquyen','maquyen');
    }
    public function sinhvien()
    {
    	return $this-> belongsTo('App\SinhVien','maquyen','maquyen');
    }
    public function gv_quyen()
    {
        return $this-> hasMany('App\GV_Quyen','maquyen','maquyen');
    }
}
