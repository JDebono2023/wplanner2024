<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Library extends Model
{
    protected $table = 'libraries';

    public function mainTypes(): BelongsTo
    {
        return $this->belongsTo(TypeMain::class, 'type_m');
    }

    public function secondTypes(): BelongsTo
    {
        return $this->belongsTo(TypeSecond::class, 'type_s');
    }

    public function sources(): BelongsTo
    {
        return $this->belongsTo(Source::class, 'source_id');
    }
}
