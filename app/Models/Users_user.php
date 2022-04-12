<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

class Users_user extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'users';
    protected $fillable = ['id', 'first_name', 'last_name', 'address','email', 'password', 'phone', 'image', 'email_verified', 'valid'];

    public function scopeValid($query)
    {
        $authId = Auth::id();
        return $query->where('id', $authId)->where('valid', 1);
    }
}
