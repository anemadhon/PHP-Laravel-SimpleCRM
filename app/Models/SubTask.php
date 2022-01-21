<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubTask extends Model
{
    use HasFactory, SoftDeletes, Sluggable;

    protected $fillable = [
        'name', 'slug', 
        'level_id', 
        'task_id',
        'state_id'
    ];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    public function state()
    {
        return $this->belongsTo(ProjectState::class, 'state_id');
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
