<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BookRating_web extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $table = 'book_ratings';

    protected $fillable = ['id', 'book_id', 'user_id', 'rating', 'valid'];

    public function scopeValid($query)
    {
        return $query->where('valid', 1);
    }
}
