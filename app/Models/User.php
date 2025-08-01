<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Wave\Traits\HasProfileKeyValues;
use Wave\User as WaveUser;

class User extends WaveUser
{
    use HasProfileKeyValues, Notifiable;

    public $guard_name = 'web';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'first_name',
        'last_name',
        'phone',
        'email',
        'username',
        'avatar',
        'password',
        'role_id',
        'verification_code',
        'verified',
        'trial_ends_at',
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
     * Get the user's full name by combining first and last name
     */
    public function getFullNameAttribute()
    {
        return trim($this->first_name.' '.$this->last_name);
    }

    public function setPhoneAttribute($value)
    {
        $this->attributes['phone'] = $value;
    }

    public function setFirstNameAttribute($value)
    {
        $this->attributes['first_name'] = $value;
        $this->updateFullName();
    }

    public function setLastNameAttribute($value)
    {
        $this->attributes['last_name'] = $value;
        $this->updateFullName();
    }

    /**
     * Update the name field with combined first and last name
     */
    private function updateFullName()
    {
        if (isset($this->attributes['first_name']) || isset($this->attributes['last_name'])) {
            $firstName = $this->attributes['first_name'] ?? '';
            $lastName = $this->attributes['last_name'] ?? '';
            $this->attributes['name'] = trim($firstName.' '.$lastName);
        }
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($user) {
            $animals = [
                'lapin', 'aigle', 'girafe', 'panda', 'koala', 'pingouin',
                'renard', 'loutre', 'paon', 'hibou', 'faon', 'manchot'
            ];

            if (empty($user->first_name) && empty($user->last_name)) {
                $animal = $animals[array_rand($animals)];
                $username = $animal;
                $i = 1;
                while (self::where('username', $username)->where('id', '!=', $user->id)->exists()) {
                    $username = $animal . $i;
                    $i++;
                }
                $user->username = $username;
            }
        });

        static::created(function ($user) {
            $user->syncRoles([]);
            $user->assignRole(config('wave.default_user_role', 'registered'));
        });
    }


    public function isComplete(): bool
    {
        return !empty($this->first_name) && !empty($this->last_name) && !empty($this->phone);
    }

    public function stores()
    {
        return $this->belongsToMany(Store::class)->withPivot('role');
    }
    
    public function isOwnerOfStore($store): bool
    {
        $storeId = $store instanceof Store ? $store->id : $store;
        return $this->stores()
            ->where('store_id', $storeId)
            ->wherePivot('role', 'owner')
            ->exists();
    }

    public function isAccountantOfStore($store): bool
    {
        $storeId = $store instanceof Store ? $store->id : $store;
        return $this->stores()
            ->where('store_id', $storeId)
            ->wherePivot('role', 'accountant')
            ->exists();
    }

    public function isEmployeeOfStore($store): bool
    {
        $storeId = $store instanceof Store ? $store->id : $store;
        return $this->stores()
            ->where('store_id', $storeId)
            ->wherePivot('role', 'employee')
            ->exists();
    }

    public function hasStore(): bool
    {
        return $this->stores()
            ->wherePivot('role', 'owner')
            ->orWherePivot('role', 'accountant')
            ->orWherePivot('role', 'employee')
            ->exists();
    }
}
