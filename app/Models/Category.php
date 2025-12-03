<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Auditable;

class Category extends Model
{
    use HasFactory;
    use HasFactory, Auditable;

    protected $fillable = ['name', 'description'];
}

