<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ToDoItem extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'title',
        'to_do_content',
        'created_at',
        'updated_at',
    ];
    protected $casts = [
        'user_id' => 'integer',
        'title' => 'string',
        'to_do_content' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
