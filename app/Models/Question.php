<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable =['question_text','label_id'];
    public function Label()
    {
        return $this->belongsTo(Label::class, 'label_id', 'id');
    }
}
