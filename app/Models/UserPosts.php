<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPosts extends Model
{
    use HasFactory;

    protected $table = 'user_posts';

    public $timestamps = false;

    protected $fillable = [
        'user_id', 
        'post_id',
        'type',
    ];
}
