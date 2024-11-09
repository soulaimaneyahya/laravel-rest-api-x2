<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasUuids, SoftDeletes;

    public const TABLE = 'users';
    public const VERIFIED_STATUS = 'verified';
    public const ROLE = 'is_admin';

    public const VERIFIED_USER = true;
    public const UNVERIFIED_USER = false;

    public const ADMIN_USER = true;
    public const REGULAR_USER = false;

    protected $table = self::TABLE;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'verification_token',
        self::VERIFIED_STATUS,
        self::ROLE,
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'email_verified_at',
        'verification_token',
        'api_token',
        'deleted_at',
        self::VERIFIED_STATUS,
        self::ROLE,
    ];

    protected $dates = ['deleted_at'];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'id' => 'string',
        'password' => 'hashed',
        'email_verified_at' => 'datetime'
    ];

    /**
     * Disable auto incrementing
     * 
     * @var bool
     */
    public $incrementing = false;

    // Accessors and mutators
    protected function name(): Attribute
    {
        return $this->makeAttribute();
    }

    protected function email(): Attribute
    {
        return $this->makeAttribute();
    }

    /**
     * Interact with Attribute
     *
     * @return Attribute
     */
    protected function makeAttribute(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ucwords($value),
            set: fn ($value) => strtolower($value),
        );
    }

    /**
     * @return string
     */
    public function getRole(): string
    {
        return $this->getAttribute(self::ROLE);
    }

    /**
     * @return string
     */
    public function getVerifiedStatus(): string
    {
        return $this->getAttribute(self::VERIFIED_STATUS);
    }

    public function isAdmin(): bool
    {
        return $this->getRole() == self::ADMIN_USER;
    }

    public function isVerified(): bool
    {
        return $this->getVerifiedStatus() == self::VERIFIED_USER;
    }

    public static function generateToken()
    {
        $token = Str::random(80);

        do {
            $tokens = User::where('api_token', 'like', "{$token}%")->pluck('api_token');
        } while ($tokens->count() > 0);

        return $token;
    }
}
