<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    private $user_model;
    function __construct()
    {
        $this->user_model = new User();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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
        $rules = [
            'user_id' => ['required','filled','unique:users,id,NULL,deleted_at'],
            'name' => ['required','filled'],
            'roomchat_id' => ['required','filled']
        ];
        $validator = Validator::make($request->all(),$rules);
        if($validator->fails()){
            $response = [
                'messages'=>$validator->errors()->messages()
            ];
            return response()->json($response, 400);
        }
        try{
            $insert_data = [
                'id' => $request->user_id,
                'name' => $request->name,
                'username' => $request->username,
                'roomchat_id' => $request->roomchat_id,
                'created_at' => new \DateTime
            ];
            $user = $this->user_model->insertGetId($insert_data);
            $access_token = $this->user_model->find($user)->createToken('authToken')->accessToken;
            $response = [
                'success' => true,
                'token' => $access_token
            ];
            return response()->json($response, 201);
        }catch(Exception $e){
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
