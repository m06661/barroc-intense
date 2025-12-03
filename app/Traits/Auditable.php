<?php

namespace App\Traits;

use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;

trait Auditable
{
    protected static function bootAuditable()
    {
        static::created(function ($model) {
            AuditLog::create([
                'user_id' => Auth::id(),
                'model' => get_class($model),
                'record_id' => $model->id,
                'action' => 'created',
            ]);
        });

        static::updated(function ($model) {
            AuditLog::create([
                'user_id' => Auth::id(),
                'model' => get_class($model),
                'record_id' => $model->id,
                'action' => 'updated',
            ]);
        });

        static::deleted(function ($model) {
            AuditLog::create([
                'user_id' => Auth::id(),
                'model' => get_class($model),
                'record_id' => $model->id,
                'action' => 'deleted',
            ]);
        });
    }
}
