<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    const IS_ADMIN = 1;
    const IS_MGR = 2;
    const IS_PM = 3;
    const IS_SALES = 4;
    const IS_DEV_TEAM = [5,6];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'role_id',
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
    ];

    public function scopeNotAdmin($query)
    {
        return $query->where('role_id', '<>', 1);
    }

    public function scopeDevelopmentTeam($query)
    {
        return $query->whereNotIn('role_id', [1,2,4]);
    }

    public function creatorTasks()
    {
        return $this->hasMany(Task::class, 'created_by');
    }
    
    public function tasks()
    {
        return $this->hasMany(Task::class, 'assigned_to');
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function projects()
    {
        return $this->belongsToMany(Project::class);
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class);
    }
}
