<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorkshopDetail extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'location_id',
        'specializations',
        'brands_serviced',
        'services',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'specializations' => 'array',
            'brands_serviced' => 'array',
            'services' => 'array',
        ];
    }

    /**
     * Get the location that owns the workshop detail.
     */
    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }
}
