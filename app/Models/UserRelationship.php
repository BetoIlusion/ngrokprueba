<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRelationship extends Model
{
    use HasFactory;
    protected $table = 'user_relationships';
    protected $fillable = [
        'main_user_id',
        'sub_user_id',
    ];
    public function mainUser(){
        return $this->belongsTo(User::class);
    }
    public function subUser(){
        return $this->belongsTo(User::class);
    }
}
