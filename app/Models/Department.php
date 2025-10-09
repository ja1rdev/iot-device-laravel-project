<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    use SoftDeletes;
    protected $guarded = [];
    public function country(){ return $this->belongsTo(Country::class, 'id_country'); }
    public function cities(){ return $this->hasMany(City::class, 'id_department'); }
    public function sensors(){ return $this->hasMany(Sensor::class, 'id_department'); }
}