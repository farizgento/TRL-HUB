<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tool extends Model
{
    use HasFactory;
    protected $fillable = [
        'name','nomer_asset','barcode',
        'current_location_id','current_status',
        'condition','notes'
    ];

    public function location()
    {
        return $this->belongsTo(AreaUnit::class, 'current_location_id');
    }

    public function images()
    {
        return $this->hasMany(ToolImage::class);
    }

}
