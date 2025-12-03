<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Auditable;

class Product extends Model
{

    use HasFactory, Auditable;

    protected $fillable = ['name', 'sku', 'price', 'minimum_stock', 'stock'];

    // Relatie met OrderItems voor reserveringen
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Bereken totaal gereserveerd
    public function reservedQuantity()
    {
        return $this->orderItems()->sum('quantity');
    }
}
