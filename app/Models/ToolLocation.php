<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ToolLocation extends Model
{
    use HasFactory;

    protected $fillable = [
        'location_code',
        'location_name',
    ];

    public function tools(): HasMany
    {
        return $this->hasMany(Tool::class, 'location_id');
    }
}
