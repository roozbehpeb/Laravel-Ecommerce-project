<?php

namespace App\Models;

use App\Models\Ticket\Ticket;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Ticket\TicketAdmin;
use Laravel\Jetstream\HasProfilePhoto;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'mobile',
        'profile_photo_path',
        'status',
        'activation',
        'national_id',
        'user_type',
        'password'

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];


    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }


    public function ticketAdmin(){
        return $this->hasOne(TicketAdmin::class, 'user_id');
    }


    public function tickets(){
        return $this->hasMany(Ticket::class, 'user_id'); 
    }

}
