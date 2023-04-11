<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpertSystemAttribute extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'es_project_id',
        'es_value_id',
        'type',
        'image_path'
    ];
}
