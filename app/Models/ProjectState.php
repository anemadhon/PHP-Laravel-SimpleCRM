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

    public function projects()
    {
        return $this->hasMany(Project::class, 'state_id');
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
