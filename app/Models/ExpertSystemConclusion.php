<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpertSystemConclusion extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'es_value_id',
        'type',
        'image_path'
    ];
}
