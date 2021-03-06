<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Answer extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $hidden=['deleted_at','updated_at'];
    public function Label()
    {
        return $this->belongsTo(Label::class, 'label_id', 'id');
    }
}
