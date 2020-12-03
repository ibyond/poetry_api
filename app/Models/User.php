<?php

namespace App\Models;

use App\Traits\HasDateTimeFormatter;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory,
        SoftDeletes,
        HasDateTimeFormatter,
        Notifiable;

    // 性别
    public const GENDER_NONE = 'none';
    public const GENDER_MALE = 'male';
    public const GENDER_FEMALE = 'female';

    public const DEFAULT_AVATAR = '/img/default-avatar.png';

    public const STATUS_ACTIVE = 'active';
    public const STATUS_INACTIVATED = 'inactivated';
    public const STATUS_FROZEN = 'frozen';

    public const STATUS_LABELS = [
        self::STATUS_INACTIVATED => '未激活',
        self::STATUS_ACTIVE => '正常',
        self::STATUS_FROZEN => '已冻结',
    ];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'name',
        'real_name',
        'avatar',
        'email',
        'phone',
        'gender',
        'status',
        'birthday',
        'email_verified_at',
        'password',
        'frozen_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'birthday' => 'date',
    ];

    protected $attributes = [
        'status' => self::STATUS_ACTIVE,
    ];

    /**
     * @return string
     */
    public function getAvatarAttribute()
    {
        return $this->attributes['avatar'] ?? self::DEFAULT_AVATAR;
    }

    /**
     * @return string
     */
    public function getDisplayStatusAttribute()
    {
        return self::STATUS_LABELS[$this->status ?? self::STATUS_ACTIVE];
    }

    public function createApiToken(string $name = null)
    {
        return [
            'token_type' => 'Bearer',
            'token' => $this->createToken($name ?? $this->username)->plainTextToken,
        ];
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function (User $user) {
            $user->username = $user->username ?? $user->email;
            $user->name = $user->name ?? $user->real_name ?? $user->username;

            if (Hash::needsRehash($user->password)) {
                $user->password = \bcrypt($user->password);
            }
        });
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
