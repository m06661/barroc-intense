<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Auditable;

class Customer extends Model
{

    use HasFactory, Auditable;

    protected $fillable = [
        'name', 'address', 'contact_person', 'email', 'phone', 'iban',
        'contract_type', 'status'
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function maintenance()
    {
        return $this->hasMany(Maintenance::class);
    }

    public function feedback()
    {
        return $this->hasMany(Feedback::class);
    }

    public function documents()
    {
        return $this->hasMany(CustomerDocument::class);
    }

}
