<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'file_path',
        'file_type',
        'caption',
        'hashtags',
        'selected_networks',
        'status',
    ];

    protected $casts = [
        'hashtags' => 'array',
        'selected_networks' => 'array',
    ];
}
