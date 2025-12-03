<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Auditable;

class Technician extends Model
{

    use HasFactory, Auditable;

    protected $fillable = ['name', 'region'];

    public function maintenance()
    {
        return $this->hasMany(Maintenance::class);
    }

    public function schedule()
    {
        return $this->hasMany(Schedule::class);
    }
}
