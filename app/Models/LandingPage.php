<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LandingPage extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'slug',
        'description',
        'content',
        'status',
    ];

    /**
     * Get the metrics for the landing page.
     */
    public function metrics(): HasMany
    {
        return $this->hasMany(LandingPageMetric::class);
    }
}
