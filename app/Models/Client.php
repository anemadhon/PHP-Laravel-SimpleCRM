<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Client extends Model
{
    use HasFactory, Sluggable;

    protected $fillable = [
        'name', 'slug', 
        'description', 
        'type_id'
    ];

    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public function type()
    {
        return $this->belongsTo(ClientType::class, 'type_id');
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
