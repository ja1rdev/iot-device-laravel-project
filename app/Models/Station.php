<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Station extends Model
{
    use SoftDeletes;
    protected $guarded = [];
    public function city(){ return $this->belongsTo(City::class, 'id_city'); }
    public function sensorData(){ return $this->hasMany(SensorData::class, 'id_station'); }
}