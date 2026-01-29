<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'activity_type',
        'title',
        'description',
        'created_by'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getActivityTypeLabel()
    {
        $labels = [
            'call' => 'Telefoongesprek',
            'email' => 'Email',
            'meeting' => 'Afspraak',
            'quote' => 'Offerte',
            'order' => 'Bestelling',
            'note' => 'Notitie',
            'stage_change' => 'Stadium Wijziging'
        ];

        return $labels[$this->activity_type] ?? 'Activiteit';
    }

    public function getActivityTypeIcon()
    {
        $icons = [
            'call' => '📞',
            'email' => '📧',
            'meeting' => '🤝',
            'quote' => '📄',
            'order' => '🛒',
            'note' => '📝',
            'stage_change' => '🔄'
        ];

        return $icons[$this->activity_type] ?? '📌';
    }
}
