<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectAttachment extends Model
{
    use HasFactory, Sluggable;

    protected $fillable = [
        'path', 'filename',
        'slug', 'project_id'
    ];

    const MIME_TYPES = [
        '.doc', '.docx', '.pdf',
        '.png', '.jpg', '.jpeg'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'filename'
            ]
        ];
    }
}
