<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Schedule extends Model
{
    public function library(): BelongsTo
    {
        return $this->belongsTo(Library::class);
    }

    public function usersSchedule(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
