<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sensor extends Model
{
    use SoftDeletes;
    protected $guarded = [];
    public function department(){ return $this->belongsTo(Department::class, 'id_department'); }
    public function data(){ return $this->hasMany(SensorData::class, 'id_sensor'); }
}