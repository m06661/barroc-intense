<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Auditable;

class Schedule extends Model
{

    use HasFactory, Auditable;

    protected $fillable = ['technician_id', 'date', 'region', 'route', 'overlap_alert'];

    public function technician()
    {
        return $this->belongsTo(Technician::class);
    }
}
