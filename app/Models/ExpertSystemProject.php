<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpertSystemProject extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'user_created_id',
        'is_published',
        'image_path'
    ];
}