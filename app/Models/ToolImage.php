<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ToolImage extends Model
{
    use HasFactory;
    protected $fillable = ['tool_id','path'];

    public function tool()
    {
        return $this->belongsTo(Tool::class);
    }
}
