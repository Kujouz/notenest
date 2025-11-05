<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Note extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 'folder_id', 'title', 'course_code',
        'description', 'category', 'file_path', 'file_name',
        'file_type', 'file_size'
    ];

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }
    public function getFormattedFileSizeAttribute()
    {
        $size = $this->file_size;
        $units = ['B', 'KB', 'MB', 'GB'];
        for ($i = 0; $size > 1024 && $i < 3; $i++) {
            $size /= 1024;
        }
        return round($size, 2) . ' ' . $units[$i];
    }
    public function folder(): BelongsTo
    {
        return $this->belongsTo(Folder::class);
    }

     public function user()
    {
        return $this->belongsTo(User::class);
    }
}
