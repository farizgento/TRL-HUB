<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SendingPlanItem extends Model
{
    use HasFactory;
     protected $fillable = [
        'sending_plan_id','tool_id','area_unit_id'
    ];

    public function sendingPlan()
    {
        return $this->belongsTo(SendingPlan::class);
    }

    public function tool()
    {
        return $this->belongsTo(Tool::class);
    }

    public function areaUnit()
    {
        return $this->belongsTo(AreaUnit::class, 'area_unit_id');
    }
}
