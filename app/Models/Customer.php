<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\Auditable;

class Customer extends Model
{

    use HasFactory, Auditable;

    protected $fillable = [
        'name',
        'address',
        'contact_person',
        'email',
        'phone',
        'iban',
        'contract_type',
        'status',
        // Nieuwe velden
        'funnel_stage',
        'last_contact_date',
        'assigned_to'
    ];

    protected $casts = [
        'last_contact_date' => 'date'
    ];

    // ========== BESTAANDE RELATIES ==========

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function machines(): HasMany
    {
        return $this->hasMany(Machine::class);
    }

    public function feedbacks(): HasMany
    {
        return $this->hasMany(Feedback::class);
    }

    public function maintenances(): HasMany
    {
        return $this->hasMany(Maintenance::class);
    }


    // ========== NIEUWE RELATIES ==========

    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function activities()
    {
        return $this->hasMany(CustomerActivity::class)->orderBy('created_at', 'desc');
    }

    // ========== HELPER METHODS ==========

    public function getFunnelStageLabel()
    {
        $labels = [
            'lead' => 'Lead',
            'prospect' => 'Prospect',
            'quote_sent' => 'Offerte Verstuurd',
            'customer' => 'Klant',
            'delivered' => 'Geleverd'
        ];

        return $labels[$this->funnel_stage] ?? 'Onbekend';
    }

    public function getFunnelStageColor()
    {
        $colors = [
            'lead' => 'bg-gray-500',
            'prospect' => 'bg-blue-500',
            'quote_sent' => 'bg-yellow-500',
            'customer' => 'bg-green-500',
            'delivered' => 'bg-purple-500'
        ];

        return $colors[$this->funnel_stage] ?? 'bg-gray-400';
    }

    public function getFunnelStageIcon()
    {
        $icons = [
            'lead' => '🔍',
            'prospect' => '💼',
            'quote_sent' => '📄',
            'customer' => '✅',
            'delivered' => '🚚'
        ];

        return $icons[$this->funnel_stage] ?? '❓';
    }

    public function daysSinceLastContact()
    {
        if (!$this->last_contact_date) {
            return null;
        }

        return now()->diffInDays($this->last_contact_date);
    }
}
