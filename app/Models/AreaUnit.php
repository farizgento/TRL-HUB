<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AreaUnit extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'unit'];

    public function tools()
    {
        return $this->hasMany(Tool::class, 'current_location_id');
    }
}
