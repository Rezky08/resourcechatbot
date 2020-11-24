<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Label extends Model
{
    use HasFactory;
    use SoftDeletes;
    public function Question()
    {
        return $this->hasMany(Question::class, 'label_id', 'id');
    }
    public function Answer()
    {
        return $this->hasMany(Question::class, 'label_id', 'id');
    }
}
