<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

class Author_provider extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'authors';
    protected $fillable = ['id', 'name', 'details', 'active_status', 'created_by', 'valid'];

    public function scopeValid($query)
    {
        $authId = Auth::guard('provider')->id();
        return $query->where('valid', 1);
    }
    public static function boot()
    {
        parent::providerBoot();
    }
}
