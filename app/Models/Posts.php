<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Posts extends Model
{
    use HasFactory;
    
    // public $timestamps = false;

    protected $fillable = [
        'title', 
        'description',
        'user_id',
        'user',
    ];

    public function user()
    {
        return $this->hasOne(User::class);
    }
}
