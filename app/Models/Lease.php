<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lease extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'start_date',
        'end_date',
        'bkr_check',
        'customer_id'
    ];
    // Relationships
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }


    public function invoice()
    {
        return $this->hasMany(Invoice::class);
    }

}
