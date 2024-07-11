<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sensor extends Model
{
    use HasFactory;

    protected $fillable = [
        'device_id',
        'humidity',
        'temperature',
        'uv',
        'ldr',
        'co',
        'co_two',
        'dust'
    ];



    public function device(){
        return $this->belongsTo(Device::class);
    }
}

