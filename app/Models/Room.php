<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class Room extends Model
{
use HasFactory;


protected $fillable = [
'title', 'slug', 'type', 'features', 'price', 'capacity', 'status','image',
];


protected static function booted()
{
static::creating(function ($room) {
$room->slug = Str::slug($room->title) . '-' . uniqid();
});
}
}