<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Feedback extends Model
{
    use HasFactory;

    protected $table = 'feedback'; // laat zo als je tabel echt 'feedback' heet

    protected $fillable = [
        'customer_id',
        'order_id',
        'technician_id',
        'machine_id',
        'score',
        'comments',
        'feedback_requested_at',
        'submitted_at', // <-- handig als je dit veld hebt / wilt
    ];

    protected $casts = [
        'score' => 'integer',
        'feedback_requested_at' => 'datetime',
        'submitted_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    // BELANGRIJK: technician hoort meestal een User te zijn
    public function technician()
    {
        return $this->belongsTo(\App\Models\Technician::class, 'technician_id');
    }


    public function machine(): BelongsTo
    {
        return $this->belongsTo(Machine::class);
    }

    public function isFeedbackGiven(): bool
    {
        return !is_null($this->score);
    }
}
