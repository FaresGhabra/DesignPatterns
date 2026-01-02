<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Rennokki\QueryCache\Traits\QueryCacheable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, QueryCacheable;
    public $cacheFor = 21600; // For 6 hours
    protected static $flushCacheOnUpdate = true;
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_active'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function accounts()
    {
        return $this->hasMany(Account::class);
    }

    public function changeRequests()
    {
        return $this->hasMany(ChangeRequest::class, 'requester_id');
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }
}