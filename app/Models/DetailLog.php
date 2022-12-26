<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailLog extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<string, string, string, string, int>
     */
    protected $fillable = ['event', 'data', 'slug', 'description', 'user_id'];
}
