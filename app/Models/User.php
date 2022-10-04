<?php

namespace App\Models;

use App\Models\Admin;
use App\Models\Booking;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, Sortable;

    protected $fillable = [
        'username',
        'name',
        'image',
        'email',
        'address',
        'phone',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::creating(function ($user) {
            $user->name = Str::title($user->name);
            $user->username = Str::lower($user->username);
        });
    }

    public function bookings()
    { 
      return $this->hasMany(Booking::class);
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'id');
    }
}
