<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectAttachment extends Model
{
    use HasFactory;

    protected $fillable = [
        'path', 'project_id'
    ];

    const MIME_TYPES = [
        '.doc', '.docx', '.pdf',
        '.png', '.jpg', 'jpeg'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
