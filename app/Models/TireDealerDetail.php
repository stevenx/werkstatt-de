<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TireDealerDetail extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'location_id',
        'tire_brands',
        'services',
        'tire_storage_available',
        'wheel_alignment',
        'balancing_available',
        'run_flat_specialist',
        'mobile_service',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'tire_brands' => 'array',
            'services' => 'array',
            'tire_storage_available' => 'boolean',
            'wheel_alignment' => 'boolean',
            'balancing_available' => 'boolean',
            'run_flat_specialist' => 'boolean',
            'mobile_service' => 'boolean',
        ];
    }

    /**
     * Get the location that owns the tire dealer detail.
     */
    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }
}
