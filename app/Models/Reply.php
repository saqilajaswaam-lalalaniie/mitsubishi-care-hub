<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use HasFactory;

    protected $fillable = [
        'discussion_id',
        'user_id',
        'content',
    ];

    // Relasi ke tabel Discussion (Pertanyaan)
    public function discussion()
    {
        return $this->belongsTo(Discussion::class);
    }

    // Relasi ke tabel User (Yang membalas)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}