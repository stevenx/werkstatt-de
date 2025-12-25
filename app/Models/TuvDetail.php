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
