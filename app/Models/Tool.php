<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tool extends Model
{
    use HasFactory;

    public const CONDITION_GOOD = 'baik';
    public const CONDITION_DAMAGED = 'rusak';

    public const AVAILABILITY_AVAILABLE = 'tersedia';
    public const AVAILABILITY_BORROWED = 'dipinjam';
    public const AVAILABILITY_MAINTENANCE = 'perbaikan';
    public const AVAILABILITY_INACTIVE = 'tidak_aktif';

    protected $fillable = [
        'asset_no',
        'barcode',
        'tool_name',
        'category_id',
        'location_id',
        'condition_status',
        'availability_status',
        'notes',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(ToolCategory::class, 'category_id');
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(ToolLocation::class, 'location_id');
    }

    public function borrowItems(): HasMany
    {
        return $this->hasMany(BorrowRequestItem::class);
    }

    public static function conditionOptions(): array
    {
        return [
            self::CONDITION_GOOD => 'Baik',
            self::CONDITION_DAMAGED => 'Rusak',
        ];
    }

    public static function availabilityOptions(): array
    {
        return [
            self::AVAILABILITY_AVAILABLE => 'Tersedia',
            self::AVAILABILITY_BORROWED => 'Dipinjam',
            self::AVAILABILITY_MAINTENANCE => 'Perbaikan',
            self::AVAILABILITY_INACTIVE => 'Tidak Aktif',
        ];
    }
}
