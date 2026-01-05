<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BorrowReturn extends Model
{
    use HasFactory;
    protected $fillable = [
        'sending_plan_id','item_condition','note'
    ];

    public function sendingPlan()
    {
        return $this->belongsTo(SendingPlan::class);
    }
}
