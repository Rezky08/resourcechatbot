<?php

namespace App\Http\Controllers;

use App\Imports\AnswerImport;
use App\Models\Answer;
use App\Models\Label;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class AnswerController extends Controller
{
    private $answer_model;
    private $page_name;
    private $label_model;
    function __construct()
    {
        $this->page_name = "Answer";
        $this->answer_model = new Answer();
        $this->label_model = new Label();

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $answers = $this->answer_model->paginate();
        $data = [
            'answers' => $answers,
            'page_name' => $this->page_name
        ];
        return view('answers.answer',$data);
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
            'page_name' => 'Add Answer',
            'labels' => $labels
        ];
        return view('answers.answer_form',$data);
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
            'answer_text' => ['required'],
            'label_id' => ['required','exists:labels,id,deleted_at,NULL']
        ];
        $validator = Validator::make($request->all(),$rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        try {
            $this->answer_model->insert($request->except(['_method','_token']));
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
            'success'=>'Answer has been added'
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
        $file_test = Excel::toCollection(new AnswerImport,$request->file('import_data'))->first();
        $labels = $this->label_model->all();
        $insert_data = $file_test->map(function ($item,$index) use ($labels)
        {
            $label = $labels->where('label_name',$item[1])->first();
            if (!$label) {
                return $label;
            }
            $item = [
                'answer_text' => $item[0],
                'label_id' => $label->id
            ];
            return $item;
        })->toArray();
        $rules = [
            '*.answer_text' => ['required','unique:answers,answer_text,id,id,deleted_at,NULL'],
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
            $this->answer_model->insert($insert_data);
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
        return redirect('/answer')->with($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function show(Answer $answer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $answer = $this->answer_model->find($id);
        if (!$answer) {
            $response = [
                'error' => 'Answer not found!'
            ];
            return redirect('/answer')->with($response);
        }
        $labels = $this->label_model->all();
        $data = [
            'labels' => $labels,
            'answer' => $answer,
            'page_name' => $this->page_name,
            'form_method' => 'PUT'
        ];
        return view('answers.answer_form',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $rules = [
            'answer_text' => ['required'],
            'answer_id'=>['exists:answers,id,deleted_at,NULL'],
            'label_id' => ['required','exists:labels,id,deleted_at,NULL']
        ];
        $validator = Validator::make($request->all()+['answer_id'=>$id],$rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        try {
            $answer = $this->answer_model->find($id);
            $answer->answer_text = $request->answer_text;
            $answer->label_id = $request->label_id;
            $answer->save();
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
            'success'=>'Answer has been Updated'
        ];
        return redirect()->back()->with($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $answer = $this->answer_model->find($id);
        if (!$answer) {
            $response = [
                'error' => 'Answer Not Found'
            ];
            return redirect()->back()->with($response);
        }
        $response = [
            'success' => 'Answer '.$answer->id.' has been deleted'
        ];
        try {
            $answer->delete();
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
        return redirect('/answer')->with($response);
    }
}
