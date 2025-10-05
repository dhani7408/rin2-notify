<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'notification_switch',
        'phone_number',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'last_login_at' => 'datetime',
            'password' => 'hashed',
            'notification_switch' => 'boolean',
        ];
    }

    /**
     * Get notifications for this user
     */
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    /**
     * Get notifications that this user has read
     */
    public function readNotifications()
    {
        return $this->belongsToMany(Notification::class, 'notification_reads')
                    ->withPivot('read_at')
                    ->withTimestamps();
    }

    /**
     * Get unread notifications for this user
     */
    public function unreadNotifications()
    {
        return Notification::where(function ($query) {
            $query->where('user_id', $this->id)
                  ->orWhere('is_for_all', true);
        })
        ->where('expires_at', '>', now())
        ->whereDoesntHave('readByUsers', function ($query) {
            $query->where('user_id', $this->id);
        });
    }

    /**
     * Get unread notifications count for this user
     */
    public function getUnreadNotificationsCountAttribute()
    {
        $userNotifications = Notification::where(function ($query) {
            $query->where('user_id', $this->id)
                  ->orWhere('is_for_all', true);
        })
        ->where('expires_at', '>', now())
        ->whereDoesntHave('readNotifications', function ($query) {
            $query->where('user_id', $this->id);
        })
        ->count();

        return $userNotifications;
    }
}
