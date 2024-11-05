<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Epic extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'task_id',
        'children',
    ];

    public function task(): HasOne
    {
        return $this->hasOne(Task::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
