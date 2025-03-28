<?php

namespace David007\LandingPageManager\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'template',
        'is_published',
        // 他の必要なフィールドがあれば追加
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_published' => 'boolean',
    ];

    /**
     * このランディングページに関連するメトリクスを取得
     */
    public function metrics()
    {
        return $this->hasMany(LandingPageMetric::class);
    }
}

