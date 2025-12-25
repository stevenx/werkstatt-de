<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

class Location extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
        'type',
        'street',
        'house_number',
        'city',
        'postal_code',
        'state',
        'latitude',
        'longitude',
        'phone',
        'email',
        'website',
        'opening_hours',
        'osm_id',
        'osm_type',
        'last_synced_at',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'opening_hours' => 'array',
            'type' => 'string',
            'latitude' => 'decimal:7',
            'longitude' => 'decimal:7',
            'last_synced_at' => 'datetime',
        ];
    }

    /**
     * Boot the model.
     */
    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (Location $location) {
            if (empty($location->slug)) {
                $location->slug = Str::slug($location->name);
            }
        });

        static::updating(function (Location $location) {
            if ($location->isDirty('name')) {
                $location->slug = Str::slug($location->name);
            }
        });
    }

    /**
     * Get the workshop detail for this location.
     */
    public function workshopDetail(): HasOne
    {
        return $this->hasOne(WorkshopDetail::class);
    }

    /**
     * Get the TUV detail for this location.
     */
    public function tuvDetail(): HasOne
    {
        return $this->hasOne(TuvDetail::class);
    }

    /**
     * Get the tire dealer detail for this location.
     */
    public function tireDealerDetail(): HasOne
    {
        return $this->hasOne(TireDealerDetail::class);
    }

    /**
     * Scope a query to only include workshops.
     */
    public function scopeWorkshops($query)
    {
        return $query->where('type', 'workshop');
    }

    /**
     * Scope a query to only include TUV locations.
     */
    public function scopeTuv($query)
    {
        return $query->where('type', 'tuv');
    }

    /**
     * Scope a query to only include tire dealers.
     */
    public function scopeTireDealers($query)
    {
        return $query->where('type', 'tire_dealer');
    }

    /**
     * Get the formatted address.
     */
    public function getFormattedAddressAttribute(): string
    {
        $streetAddress = trim(($this->street ?? '') . ' ' . ($this->house_number ?? ''));

        $parts = array_filter([
            $streetAddress,
            trim(($this->postal_code ?? '') . ' ' . ($this->city ?? '')),
            $this->state,
        ]);

        return implode(', ', $parts);
    }
}
