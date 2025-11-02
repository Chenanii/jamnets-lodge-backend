<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class BananaFarm extends Model
{
use HasFactory;


protected $table = 'banana_farms';


protected $fillable = [
    'farm_name',
    'total_trees',
    'fruiting_trees',
    'sick_trees',
    'dead_trees',
    'recorded_at',
    'notes',
];


protected $casts = [
    'recorded_at' => 'date',
    ];
}