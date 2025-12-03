<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Issue extends Model
{
    protected $fillable = [
        'machine_id', 'user_id', 'reported_at', 'priority', 'status', 'description'
    ];

    public function machine()
    {
        return $this->belongsTo(Machine::class);
    }

    public function actions()
    {
        return $this->hasMany(IssueAction::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
