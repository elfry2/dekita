<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'due_date',
        'is_completed',
        'user_id',
        'folder_id',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
