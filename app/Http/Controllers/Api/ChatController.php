<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ChatController extends Controller
{
    private $chat_model;
    private $user_model;
    function __construct()
    {
        $this->chat_model = new Chat();
        $this->user_model = new User();
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
        $rules = [
            'user_id' => ['exists:users,id,deleted_at,NULL','filled','required','numeric'],
            'chat_text' => ['filled','required']
        ];
        $validator = Validator::make($request->all(),$rules);
        if ($validator->fails()) {
            return response()->json($validator->errors()->messages(),400);
        }
        try {
            $insert_data = [
                'user_id' => $request->user_id,
                'chat_text' => $request->chat_text,
                'created_at' => new \DateTime
            ];
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
