<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ProjectUser extends Pivot
{
    use HasFactory;

    const ON_START = 1;
    const DONE = 0;

    public function pm()
    {
        return $this->belongsTo(User::class, 'pm_id');
    }
}
