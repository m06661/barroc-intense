<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IssueAction extends Model
{
    protected $fillable = [
        'issue_id', 'technician_id', 'action_date', 'action_description', 'result', 'is_solution'
    ];

    public function technician()
    {
        return $this->belongsTo(Technician::class);
    }

    public function issue()
    {
        return $this->belongsTo(Issue::class);
    }
}
