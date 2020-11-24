<?php

namespace App\Imports;

use App\Models\Question;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithValidation;

class QuestionImport implements ToModel,WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Question([
            'question_text' => $row[0],
            'label_id' =>$row[1]
        ]);
    }
    public function rules():array
    {
        return [
            '0' => Rule::unique('questions','question_text'),
            '1' => Rule::exists('labels','label_name')
        ];
    }
}
