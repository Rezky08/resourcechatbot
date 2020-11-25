<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticable
{
    use HasApiTokens,HasFactory, SoftDeletes ,Notifiable;
    public function Chat()
    {
        return $this->hasMany(Chat::class, 'user_id', 'id');
    }
}
