<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Auditable;

class Order extends Model
{
    use HasFactory, Auditable;

    protected $fillable = [
        'customer_id',
        'order_date',
        'status',
        'priority',
        'total_amount'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function feedback()
    {
        return $this->hasMany(Feedback::class);
    }
}
