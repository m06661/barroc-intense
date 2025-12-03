<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Auditable;

class Role extends Model
{

    use HasFactory, Auditable;
    protected $fillable = ['name','description'];
    public function users(){ return $this->hasMany(User::class); }
}
