<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GV_SDT extends Model
{
    protected $table='gv_sdt';
    public $primaryKey = 'magv';
    public $incrementing = false;
    public function giangvien()
    {
    	return $this-> belongsTo('App\GiangVien','magv','magv');
    }
}
