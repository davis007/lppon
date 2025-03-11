<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LandingPageMetric extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'landing_page_id',
        'visitor_id',
        'device_type',
        'read_through_rate',
        'scroll_depth_25',
        'scroll_depth_50',
        'scroll_depth_75',
        'scroll_depth_100',
        'time_spent',
        'exit_scroll_position',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'scroll_depth_25' => 'boolean',
        'scroll_depth_50' => 'boolean',
        'scroll_depth_75' => 'boolean',
        'scroll_depth_100' => 'boolean',
        'read_through_rate' => 'float',
        'time_spent' => 'integer',
        'exit_scroll_position' => 'integer',
    ];

    /**
     * Get the landing page that owns the metric.
     */
    public function landingPage(): BelongsTo
    {
        return $this->belongsTo(LandingPage::class);
    }
}
