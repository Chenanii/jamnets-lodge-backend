<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vacancy extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'department',
        'description',
        'requirements',
        'deadline',
        'location',
        'is_active',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
