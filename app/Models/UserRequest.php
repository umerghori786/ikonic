<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRequest extends Model
{
    use HasFactory;
    protected $fillable = ['sender_user_id','reciever_user_id','status'];

    public function recieverUser()
    {
        return $this->belongsTo(User::class,'reciever_user_id','id');
    }
    public function senderUser()
    {
        return $this->belongsTo(User::class,'sender_user_id','id');
    }
}
