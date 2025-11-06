<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = ['technician_id', 'date', 'region', 'route', 'overlap_alert'];

    public function technician()
    {
        return $this->belongsTo(Technician::class);
    }
}
