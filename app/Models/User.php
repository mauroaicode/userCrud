<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{
    Builder,
    Factories\HasFactory
};
use App\Traits\Uuid;
use Illuminate\Support\Facades\App;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Uuid;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'last_name',
        'email',
        'phone',
        'address',
        'password',
        'path_profile_photo'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'id' => 'string',
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'id';

    const ACTIVE = 1;
    const INACTIVE = 0;

    /**
     * Get the identifier that will be stored in the subject claim of the Jwt.
     *
     * @return mixed
     */
    public function getJWTIdentifier(): mixed
    {
        return $this->getKey(); // @codeCoverageIgnore
    }

    /**
     * Return a key value array, containing any custom claims to be added to the Jwt.
     *
     * @return array
     */
    public function getJWTCustomClaims(): array
    {
        return []; // @codeCoverageIgnore
    }

    /**
     * Set the user's password attribute.
     *
     * @param string $value
     * @return void
     */
    public function setPasswordAttribute(string $value): void
    {
        if (!App::runningInConsole()) {

            $this->attributes['password'] = bcrypt($value);
        } else {

            $this->attributes['password'] = $value;
        }

    }


    /**
     * Scope a query to only include users with the given id.
     *
     * @param Builder $query
     * @param string $value
     * @return Builder
     */
    public function scopeById(Builder $query, string $value): Builder
    {
        return $query->where('id', $value);
    }
}
