<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'contact_person',
        'email',
        'phone',
        'iban',
        'contract_type',
        'status',
        'funnel_stage',
        'last_contact_date',
        'assigned_to',
    ];

    protected $casts = [
        'last_contact_date' => 'date',
    ];

    // ========== RELATIES ==========

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function documents()
    {
        return $this->hasMany(CustomerDocument::class);
    }

    public function machines()
    {
        return $this->hasMany(Machine::class);
    }

    /**
     * VOORKOMT:
     * Call to undefined relationship [feedback]
     */
    public function feedback()
    {
        return $this->hasMany(Feedback::class);
    }

    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function activities()
    {
        return $this->hasMany(CustomerActivity::class)
            ->orderBy('created_at', 'desc');
    }

    // ========== HELPERS ==========

    public function getFunnelStageLabel(): string
    {
        return [
            'lead'       => 'Lead',
            'prospect'   => 'Prospect',
            'quote_sent' => 'Offerte Verstuurd',
            'customer'   => 'Klant',
            'delivered'  => 'Geleverd',
        ][$this->funnel_stage] ?? 'Onbekend';
    }

    public function getFunnelStageColor(): string
    {
        return [
            'lead'       => 'bg-gray-500',
            'prospect'   => 'bg-blue-500',
            'quote_sent' => 'bg-yellow-500',
            'customer'   => 'bg-green-500',
            'delivered'  => 'bg-purple-500',
        ][$this->funnel_stage] ?? 'bg-gray-400';
    }

    public function getFunnelStageIcon(): string
    {
        return [
            'lead'       => '🔍',
            'prospect'   => '💼',
            'quote_sent' => '📄',
            'customer'   => '✅',
            'delivered'  => '🚚',
        ][$this->funnel_stage] ?? '❓';
    }

    public function daysSinceLastContact(): ?int
    {
        if (!$this->last_contact_date) {
            return null;
        }

        return now()->diffInDays(
            Carbon::parse($this->last_contact_date)
        );
    }
}
