<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Auditable;

class Product extends Model
{
    use HasFactory, Auditable;

    protected $fillable = ['name', 'sku', 'price', 'minimum_stock', 'reorder_quantity', 'stock'];

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

    // Check of voorraad laag is
    public function isLowStock()
    {
        return $this->stock <= $this->minimum_stock;
    }

    // Check of voorraad kritiek laag is
    public function isCriticalStock()
    {
        return $this->stock <= ($this->minimum_stock / 2);
    }

    // Bereken hoeveel je moet bestellen
    public function suggestedReorderQuantity()
    {
        if (!$this->isLowStock()) {
            return 0;
        }

        $shortage = $this->minimum_stock - $this->stock;
        return max($this->reorder_quantity, $shortage + $this->reorder_quantity);
    }
}
