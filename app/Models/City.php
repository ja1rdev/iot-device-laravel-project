<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model
{
    use SoftDeletes;
    protected $guarded = [];
    public function department(){ return $this->belongsTo(Department::class, 'id_department'); }
    public function stations(){ return $this->hasMany(Station::class, 'id_city'); }
}