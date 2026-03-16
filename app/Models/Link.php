<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    protected $fillable = [
        'user_id', 'original_url', 'short_code',
        'title', 'is_active', 'expires_at',
    ];

    protected $casts = [
        'is_active'  => 'boolean',
        'expires_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function clicks()
    {
        return $this->hasMany(LinkClick::class);
    }

    // الرابط القصير الكامل
    public function getShortUrlAttribute(): string
    {
        return url('/r/' . $this->short_code);
    }

    // هل الرابط لسه شغال؟
    public function isExpired(): bool
    {
        return $this->expires_at && $this->expires_at->isPast();
    }

    // إحصائيات سريعة
    public function getTotalClicksAttribute(): int
    {
        return $this->clicks()->count();
    }

    public function getClicksTodayAttribute(): int
    {
        return $this->clicks()->whereDate('clicked_at', today())->count();
    }
}
