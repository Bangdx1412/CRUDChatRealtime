<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupChatDetail extends Model
{
    use HasFactory;
    protected $table = 'groupchat_detail';
    protected $fillable = [
        'groupchat_id',
        'member_id'
    ];
}
