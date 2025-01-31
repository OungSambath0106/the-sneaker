<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\HasApiTokens;

class Customer extends Model
{
    use HasApiTokens, Notifiable;

    protected $appends = ['image_url'];

    protected $table = 'customers';

    protected $guarded = [];

    public function getImageUrlAttribute()
    {
        if (!empty($this->image_url)) {
            $image_url = asset('uploads/customers/' . rawurlencode($this->image_url));
        } else {
            $image_url = null;
        }
        return $image_url;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'gender',
        'phone',
        'email',
        'password',
        'api_token',
        'image',
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
     * Automatically hash passwords when set.
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($customer) {
            if ($customer->password) {
                $customer->password = Hash::make($customer->password);
            }
        });

        static::updating(function ($customer) {
            if ($customer->isDirty('password')) {
                $customer->password = Hash::make($customer->password);
            }
        });
    }
}
