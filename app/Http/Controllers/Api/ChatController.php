<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\UserController;
use App\Models\Chat;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ChatController extends Controller
{
    private $chat_model;
    private $user_model;
    private $user_controller;
    function __construct()
    {
        $this->chat_model = new Chat();
        $this->user_model = new User();
        $this->user_controller = new UserController();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $chats = $this->chat_model->all();
        return response()->json($chats, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate User
        $rules = [
            'user_id' => ['required','filled']
        ];
        $validator = Validator::make($request->all(),$rules);
        if($validator->fails()){
            $response = [
                'message' => $validator->errors()->messages()
            ];
            return response()->json($response, 400);
        }
        $user = $this->user_model->where('user_id',$request->user_id)->first();
        if(!$user){
            $res = $this->user_controller->add_user($request->except('text'));

            if($res !== true){
                $response = [
                    'message' => "user not valid"
                ];
                return response()->json($response, 200);
            }
            $user = $this->user_model->where('user_id',$request->user_id)->first();
        }
        // End Validate User

        $rules = [
            'user_id' => ['filled','required','exists:users,id,deleted_at,NULL'],
            'text' => ['filled','required']
        ];
        $insert_data = [
            'user_id' => $user->id,
            'text' => $request->text,
            'created_at' => new \DateTime
        ];
        $validator = Validator::make($insert_data,$rules);
        if ($validator->fails()) {
            return response()->json($validator->errors()->messages(),400);
        }
        try {
            $this->chat_model->insert($insert_data);
            $response = [
                'message' => 'insert data success'
            ];
            return response()->json($response, 200);
        } catch (Exception $e) {
            if (env('APP_DEBUG')) {
                $response = [
                    'message' => $e->getMessage()
                ];
                return response()->json($response, 500);
            }else{
                $response = [
                    'message' => 'Internal Server Error'
                ];
                return response()->json($response, 500);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
