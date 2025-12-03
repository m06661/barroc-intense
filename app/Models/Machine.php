<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Machine extends Model
{
    protected $fillable = [
        'customer_id', 'serial_number', 'type', 'location', 'installed_at', 'status'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function issues()
    {
        return $this->hasMany(Issue::class);
    }
}
