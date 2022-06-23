<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AreaServices extends Model
{
    use HasFactory;
    protected $table = 'area_services';
    protected $fillable =[
        'area_id',
        'service_id',
        'is_sending',
        'is_resiving',
    ];

    public function Area(){
        return $this->belongsTo(Area::class);
    }
}
