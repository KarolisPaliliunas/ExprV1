<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSetup extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'lang_code',
        'nav_color',
        'nav_font'
    ];
}