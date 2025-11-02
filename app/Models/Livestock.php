<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Livestock extends Model
{
use HasFactory;


protected $fillable = [
'type',
'total_count',
'alive_count',
'sick_count',
'dead_count',
'recorded_at',
'notes',
];


protected $casts = [
'recorded_at' => 'date',
];
}