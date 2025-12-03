<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CustomerDocument extends Model
{
    use HasFactory, Auditable;
    protected $fillable = [
        'customer_id',
        'filename',
        'path',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
