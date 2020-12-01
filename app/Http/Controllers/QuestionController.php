<?php

namespace App\Http\Controllers;

use App\Imports\QuestionImport;
use App\Models\Label;
use App\Models\Question;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;

class QuestionController extends Controller
{
    private $question_model;
    private $label_model;
    private $page_name;
    function __construct()
    {
        $this->question_model = new Question();
        $this->label_model = new Label();
        $this->page_name = 'Question';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $questions = $this->question_model->paginate();
        $data = [
            'questions' => $questions,
            'page_name' => $this->page_name
        ];
        return view('questions.question',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $labels = $this->label_model->all();
        $data = [
            'form_method' => 'POST',
            'page_name' => 'Add Question',
            'labels' => $labels
        ];
        return view('questions.question_form',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'question_text' => ['required'],
            'label_id' => ['required','exists:labels,id,deleted_at,NULL']
        ];
        $validator = Validator::make($request->all(),$rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        try {
            $this->question_model->insert($request->except(['_method','_token']));
        } catch (Exception $e) {
            if (env('APP_DEBUG')) {
                $response = [
                    'error'=>$e->getMessage()
                ];
                return redirect()->back()->withErrors($validator->errors())->withInput()->with($response);
            }else {
                $response = [
                    'error'=>'Server Error '.$e->getCode()
                ];
                return redirect()->back()->withErrors($validator)->withInput()->with($response);
            }
        }
        $response = [
            'success'=>'Question has been added'
        ];
        return redirect()->back()->with($response);

    }

    public function importExcel(Request $request)
    {
        $rules = [
            'import_data' => ['required','file','mimes:xlsx,csv,xls,txt']
        ];
        $validator = Validator::make($request->all(),$rules);
        if ($validator->fails()) {
            $response = [
                'error' => $validator->errors()->first('import_data')
            ];
            return redirect()->back()->with($response);
        }
        $file_test = Excel::toCollection(new QuestionImport,$request->file('import_data'))->first();
        $labels_new = $file_test->pluck(1)->unique()->flatten();
        $labels = $this->label_model->all()->pluck('label_name')->toArray();
        $labels_new = $labels_new->diff($labels)->toArray();
        if ($labels_new) {
            $insert_label_data = [];
            foreach ($labels_new as $value) {
                $insert_label_data[] = [
                    'label_name'    =>  $value,
                    'created_at'    =>  new \DateTime
                ];
            }
            $this->label_model->insert($insert_label_data);
        }
        $labels = $this->label_model->all();
        $insert_data = $file_test->map(function ($item) use ($labels)
        {
            $label = $labels->where('label_name',$item[1])->first();
            $item = [
                'question_text' => $item[0],
                'label_id' => $label->id,
                'created_at' =>  new \DateTime
            ];
            return $item;
        })->toArray();
        $rules = [
            '*.question_text' => ['required','unique:questions,question_text,id,id,deleted_at,NULL'],
            '*.label_id' => ['required','exists:labels,id,deleted_at,NULL']
        ];
        $validateData = Validator::make($insert_data,$rules);
        if ($validateData->fails()) {
            $response = [
                'error' => $validateData->errors()->first()
            ];
            return redirect()->back()->with($response)->withInput();
        }
        try {
            $this->question_model->insert($insert_data);
        } catch (Exception $e) {
            if (env('APP_DEBUG')) {
                $response = [
                    'error'=>$e->getMessage()
                ];
                return redirect()->back()->with($response);
            }else {
                $response = [
                    'error'=>'Server Error '.$e->getCode()
                ];
                return redirect()->back()->with($response);
            }
        }

        $response = [
            'success' => 'Data has been imported'
        ];
        return redirect('/question')->with($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $question = $this->question_model->find($id);
        if (!$question) {
            $response = [
                'error' => 'Question not found!'
            ];
            return redirect('/question')->with($response);
        }
        $labels = $this->label_model->all();
        $data = [
            'labels' => $labels,
            'question' => $question,
            'page_name' => $this->page_name,
            'form_method' => 'PUT'
        ];
        return view('questions.question_form',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $rules = [
            'question_text' => ['required'],
            'question_id'=>['exists:questions,id,deleted_at,NULL'],
            'label_id' => ['required','exists:labels,id,deleted_at,NULL']
        ];
        $validator = Validator::make($request->all()+['question_id'=>$id],$rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        try {
            $question = $this->question_model->find($id);
            $question->question_text = $request->question_text;
            $question->label_id = $request->label_id;
            $question->save();
        } catch (Exception $e) {
            if (env('APP_DEBUG')) {
                $response = [
                    'error'=>$e->getMessage()
                ];
                return redirect()->back()->withErrors($validator->errors())->withInput()->with($response);
            }else {
                $response = [
                    'error'=>'Server Error '.$e->getCode()
                ];
                return redirect()->back()->withErrors($validator)->withInput()->with($response);
            }
        }
        $response = [
            'success'=>'Question has been Updated'
        ];
        return redirect()->back()->with($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $question = $this->question_model->find($id);
        if (!$question) {
            $response = [
                'error' => 'Question Not Found'
            ];
            return redirect()->back()->with($response);
        }
        $response = [
            'success' => 'Question '.$question->id.' has been deleted'
        ];
        try {
            $question->delete();
        } catch (Exception $e) {

            if (env('APP_DEBUG')) {
                $response = [
                    'error'=>$e->getMessage()
                ];
                return redirect()->back()->with($response);
            }else {
                $response = [
                    'error'=>'Server Error '.$e->getCode()
                ];
                return redirect()->back()->with($response);
            }
        }
        return redirect('/question')->with($response);
    }
}
