<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BorrowRequestItem extends Model
{
    use HasFactory;

 protected $fillable = ['borrow_request_id','tool_id'];

    public function borrowRequest()
    {
        return $this->belongsTo(BorrowRequest::class);
    }

    public function tool()
    {
        return $this->belongsTo(Tool::class);
    }
}
