<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

class BookRequests_user extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'book_requests';
    protected $fillable = ['id', 'book_id', 'sender_id', 'owner_id', 'status', 'status_update_time', 'created_by', 'return_by_borrower_status', 'return_accept_by_owner_status', 'return_by_borrower_time', 'return_accept_by_owner_time', 'valid'];

    public function scopeValid($query)
    {
        $authId = Auth::id();
        return $query->where('created_by', $authId)->where('valid', 1);
    }
    public static function boot()
    {
        parent::userBoot();
    }
}
