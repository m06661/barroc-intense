<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Auditable;

class Invoice extends Model
{
    use HasFactory, Auditable;


    protected $fillable = ['order_id', 'invoice_date', 'due_date', 'status', 'amount'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
