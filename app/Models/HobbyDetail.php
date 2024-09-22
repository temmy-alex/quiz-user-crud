<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HobbyDetail extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['user_id', 'hobby_id'];
}
