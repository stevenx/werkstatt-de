<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TuvDetail extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'location_id',
        'inspection_types',
        'appointment_required',
        'average_inspection_duration',
        'online_booking_available',
        'evening_hours',
        'weekend_hours',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'inspection_types' => 'array',
            'appointment_required' => 'boolean',
            'online_booking_available' => 'boolean',
            'evening_hours' => 'boolean',
            'weekend_hours' => 'boolean',
            'average_inspection_duration' => 'integer',
        ];
    }

    /**
     * Get the location that owns the TUV detail.
     */
    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }
}
