<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BorrowRequestItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'borrow_request_id',
        'item_no',
        'permintaan_alat',
        'tool_id',
        'return_condition',
    ];

    public function request(): BelongsTo
    {
        return $this->belongsTo(BorrowRequest::class, 'borrow_request_id');
    }

    public function tool(): BelongsTo
    {
        return $this->belongsTo(Tool::class);
    }
}
