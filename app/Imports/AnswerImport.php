<?php

namespace App\Imports;

use App\Models\Answer;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithValidation;

class AnswerImport implements ToModel,WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Answer([
            'answer_text' => $row[0],
            'label_id' =>$row[1]
        ]);
    }
    public function rules():array
    {
        return [
            '0' => Rule::unique('answers','answer_text'),
            '1' => Rule::exists('labels','label_name')
        ];
    }
}
