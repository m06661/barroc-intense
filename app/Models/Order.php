<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Auditable;

class Order extends Model
{
    use HasFactory, Auditable;

    protected $fillable = [
<<<<<<< HEAD
        'customer_id',
        'order_date',
        'status',
        'priority',
        'total_amount'
    ];
=======
    'customer_id',
    'order_date',
    'status',
    'priority',
    'total_amount',
    'delivered_at',
    'delivered_by',
    'delivery_proof'
];

>>>>>>> fc103701f61737b18e290a33a7c7db087c184e80

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
    public function deliveredBy()
    {
        return $this->belongsTo(User::class, 'delivered_by');
    }

}
