<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpertSystemValue extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'es_attribute_id',
        'type',
        'image_path'
    ];
}
