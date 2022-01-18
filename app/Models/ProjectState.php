<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectState extends Model
{
    use HasFactory, Sluggable;

    protected $fillable = [
        'name', 'slug', 'for',
        'description'
    ];

    public function scopeForDevelopmentTeam($query)
    {
        return $query->whereIn('id', [2,3,4,7]);
    }

    public function projects()
    {
        return $this->hasMany(Project::class, 'state_id');
    }
    
    public function tasks()
    {
        return $this->hasMany(Task::class, 'state_id');
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name',
                'onUpdate' => true
            ]
        ];
    }
}
