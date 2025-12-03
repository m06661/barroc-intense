<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    protected $fillable = [
        'user_id',
        'model',
        'record_id',
        'action',
    ];

    // Relatie naar User
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
}
