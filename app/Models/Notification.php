<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'text',
        'expires_at',
        'user_id',
        'is_for_all',
    ];

    protected function casts(): array
    {
        return [
            'expires_at' => 'datetime',
            'is_for_all' => 'boolean',
        ];
    }

    /**
     * Get the user that owns the notification
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get users who have read this notification
     */
    public function readByUsers()
    {
        return $this->belongsToMany(User::class, 'notification_reads')
                    ->withPivot('read_at')
                    ->withTimestamps();
    }

    /**
     * Scope to get notifications for a specific user
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where(function ($q) use ($userId) {
            $q->where('user_id', $userId)
              ->orWhere('is_for_all', true);
        });
    }

    /**
     * Scope to get unexpired notifications
     */
    public function scopeUnexpired($query)
    {
        return $query->where('expires_at', '>', now());
    }

    /**
     * Scope to get unread notifications for a user
     */
    public function scopeUnreadForUser($query, $userId)
    {
        return $query->forUser($userId)
                    ->unexpired()
                    ->whereDoesntHave('readByUsers', function ($q) use ($userId) {
                        $q->where('user_id', $userId);
                    });
    }
}
