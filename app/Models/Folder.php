<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Folder extends Model
{

    protected $fillable = [
        'name',
        'code',
        'user_id',
    ];
    public function notes(): HasMany
    {
        return $this->hasMany(Note::class);
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
