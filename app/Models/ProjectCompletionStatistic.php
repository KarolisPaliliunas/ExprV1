<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectCompletionStatistic extends Model
{
    use HasFactory;

    protected $fillable = [
        'es_project_id',
        'user_id',
        'closed',
        'completion_path',
        'final_conclusion'
    ];
}
