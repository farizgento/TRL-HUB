<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class BorrowRequest extends Model
{
    use HasFactory;

    public const STATUS_DRAFT = 'draft';
    public const STATUS_SUBMITTED = 'submitted';
    public const STATUS_APPROVED_L1 = 'approved_l1';
    public const STATUS_APPROVED_FINAL = 'approved_final';
    public const STATUS_DISPATCHED = 'dispatched';
    public const STATUS_RETURNED = 'returned';
    public const STATUS_REJECTED = 'rejected';

    protected $fillable = [
        'request_no',
        'user_id',
        'area_unit_id',
        'job_type',
        'work_location',
        'requested_at',
        'planned_start_date',
        'planned_end_date',
        'status',
        'submitted_at',
        'approved_l1_by',
        'approved_l1_at',
        'approved_l1_note',
        'approved_final_by',
        'approved_final_at',
        'approved_final_note',
        'dispatched_by',
        'dispatched_at',
        'dispatch_note',
        'returned_by',
        'returned_at',
        'return_note',
    ];

    protected $casts = [
        'requested_at' => 'date',
        'planned_start_date' => 'date',
        'planned_end_date' => 'date',
        'submitted_at' => 'datetime',
        'approved_l1_at' => 'datetime',
        'approved_final_at' => 'datetime',
        'dispatched_at' => 'datetime',
        'returned_at' => 'datetime',
    ];

    public function borrower(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function areaUnit(): BelongsTo
    {
        return $this->belongsTo(AreaUnit::class, 'area_unit_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(BorrowRequestItem::class);
    }

    public function approvedL1By(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_l1_by');
    }

    public function approvedFinalBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_final_by');
    }

    public function dispatchedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'dispatched_by');
    }

    public function returnedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'returned_by');
    }

    public function getPeminjamDisplayNameAttribute(): string
    {
        return $this->borrower?->name ?? $this->borrower?->email ?? '-';
    }

    public static function statusLabels(): array
    {
        return [
            self::STATUS_DRAFT => 'Draft',
            self::STATUS_SUBMITTED => 'Menunggu Staff',
            self::STATUS_APPROVED_L1 => 'Menunggu Approval',
            self::STATUS_APPROVED_FINAL => 'Disetujui',
            self::STATUS_DISPATCHED => 'Dikirim',
            self::STATUS_RETURNED => 'Selesai',
            self::STATUS_REJECTED => 'Ditolak',
        ];
    }

    public function scopeVisibleTo(Builder $query, User $user): Builder
    {
        if ($user->hasRole('admin') || $user->hasRole('staff') || $user->hasRole('approval')) {
            return $query;
        }

        return $query->where('user_id', $user->id);
    }

    public static function generateRequestNo(): string
    {
        $date = now()->format('Ymd');
        $count = static::whereDate('created_at', now()->toDateString())->count() + 1;

        return sprintf('REQ-%s-%03d', $date, $count);
    }
}
