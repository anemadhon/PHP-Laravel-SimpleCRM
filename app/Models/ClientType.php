<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientType extends Model
{
    use HasFactory, Sluggable;

    protected $fillable = [
        'name', 'criteria',
        'description', 
        'slug'
    ];

    public function clients()
    {
        return $this->hasMany(Client::class, 'type_id');
    }

    public function getCriteriaListAttribute()
    {
        return explode(',', $this->criteria);
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
