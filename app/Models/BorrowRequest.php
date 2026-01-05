<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BorrowRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'request_date',
        'area_unit_id',
        'requester',
        'borrow_date',
        'return_date'
    ];

    // ================= RELATIONS =================

    public function items()
    {
        return $this->hasMany(BorrowRequestItem::class);
    }

    public function area()
    {
        return $this->belongsTo(AreaUnit::class, 'area_unit_id');
    }

    public function requesterUser()
    {
        return $this->belongsTo(User::class, 'requester');
    }

    /**
     * BorrowRequest punya satu Sending Plan
     */
    public function sendingPlan()
    {
        return $this->hasOne(SendingPlan::class);
    }

    /**
     * BorrowRequest punya satu Borrow Return (kalau sudah dikembalikan)
     */
    public function borrowReturn()
    {
        return $this->hasOne(BorrowReturn::class);
    }
}
