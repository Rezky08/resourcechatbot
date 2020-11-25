<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    private $user_model;
    function __construct()
    {
        $this->user_model = new User();
    }

    public function add_user($input)
    {
        $rules = [
            'user_id'=> ['required','filled','unique:users,id,NULL,deleted_at'],
            'first_name'=>['required','filled'],
            'last_name'=>['required','filled'],
            'username'=>['required','filled']
        ];
        $validator = Validator::make($input,$rules);
        if($validator->fails()){
            return $validator->errors()->messages();
        }
        try{
            $input['created_at'] = new \DateTime;
            $this->user_model->insert($input);
        }catch(Exception $e){
            return $e->getMessage();
            return false;
        }
        return true;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
