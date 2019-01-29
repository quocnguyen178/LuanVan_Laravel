<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DiaLuanVan extends Model
{
    protected $table='dialuanvan';
    public $primaryKey= 'madia';
    public $incrementing = false;

    public function luanvan()
    {
    	return $this->belongsTo('App\LuanVan','malv','malv');
    }
}
