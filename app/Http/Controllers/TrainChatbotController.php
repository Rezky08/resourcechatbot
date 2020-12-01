<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Label;
use App\Models\Question;
use App\Models\Train;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TrainChatbotController extends Controller
{
    private $train_model;
    private $question_model;
    private $answer_model;
    private $label_model;
    function __construct()
    {
        $this->train_model = new Train();
        $this->question_model = new Question();
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
        $trains = $this->train_model->all();
        $data = [
            'trains' => $trains,
            'page_name'=>"Chat Bot Train"
        ];
        return view('chatbots.chatbot',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $insert_data = [
            'created_at'=> new \DateTime
        ];
        try {
            $id = $this->train_model->insertGetId($insert_data);
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

        $questions = $this->question_model->all();
        $answers = $this->answer_model->all();
        $labels = $this->label_model->all();

        $params = [
            'id'=> $id,
            'token' => env('BOT_TOKEN'),
            'questions' => $questions->toArray(),
            'answers' => $answers->toArray(),
            'labels' => $labels->toArray(),
        ];

        $resp = Http::post(env('BOT_WEBHOOK_URL')."/train",$params);
        if ($resp->status() != 200) {
            try {
                $this->train_model->find($id)->delete();
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
                'error' => 'cannot connect to engine :('
            ];
            return redirect()->back()->with($response);
        }
        $response = [
            'success' => 'Train Proceded'
        ];
        return redirect()->back()->with($response);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Train  $train
     * @return \Illuminate\Http\Response
     */
    public function show(Train $train)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Train  $train
     * @return \Illuminate\Http\Response
     */
    public function edit(Train $train)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Train  $train
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Train $train)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Train  $train
     * @return \Illuminate\Http\Response
     */
    public function destroy(Train $train)
    {
        //
    }
}
