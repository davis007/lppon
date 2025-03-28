<?php

namespace Davis007\LandingPageManager\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'page_view_count',
        'visit_duration',
        'is_converted',
        'last_activity_at',
        // 他の必要なフィールドがあれば追加
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_converted' => 'boolean',
        'last_activity_at' => 'datetime',
    ];

    /**
     * このメトリクスが関連するランディングページを取得
     */
    public function landingPage()
    {
        return $this->belongsTo(LandingPage::class);
    }
}

