<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SendingPlan extends Model
{
    use HasFactory;
     protected $fillable = [
        'send_date','borrow_request_id',
        'status_approval','approved_by'
    ];

    public function items()
    {
        return $this->hasMany(SendingPlanItem::class);
    }

    public function borrowRequest()
    {
        return $this->belongsTo(BorrowRequest::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
