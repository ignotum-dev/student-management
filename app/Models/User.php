<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'role_id',
        'first_name',
        'middle_name',
        'last_name',
        'email',
        'password',
        'year',
        'dob',
        'age',
        'sex',
        'c_address',
        'h_address',
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
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function student() {
        return $this->hasOne(Student::class);
    }

    public function programChair() {
        return $this->hasOne(ProgramChair::class);
    }

    public function dean() {
        return $this->hasOne(Dean::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function isStudent()
    {
        return $this->role_id === 1;
    }

    public function isProgramChair()
    {
        return $this->role_id === 2;
    }

    public function isDean()
    {
        return $this->role_id === 3;
    }

    public function isAdmin()
    {
        return $this->role_id === 4;
    }

    public function isSuperAdmin()
    {
        return $this->role_id === 5;
    }
}
