<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use IvanoMatteo\LaravelDeviceTracking\Traits\UseDevices;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, UseDevices;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'phone_number',
    ];


    public function findForPassport($username)
    {
        return $this->where('phone_number', $username)->first();
    }


    public function validateForPassportPasswordGrant($password)
    {
        return true;
    }

    public function getDevice()
    {
        return $this->device();
    }

    public function getDeviceAttribute()
    {
        return $this->device();
    }
}
