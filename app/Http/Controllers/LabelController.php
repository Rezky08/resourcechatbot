<?php

namespace App\Http\Controllers;

use App\Models\Label;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LabelController extends Controller
{
    private $label_model;
    function __construct()
    {
        $this->label_model = new Label();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->get('searchbox')) {
            $labels = $this->label_model->where('label_name','LIKE','%'.$request->get('searchbox').'%')->get();
        }else{
            $labels = $this->label_model->all();
        }
        $data = [
            'labels' => $labels,
            'page_name'=>'Label'
        ];
        return view('labels.label',$data);
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
        $rules = [
            'label_name'=>['required','unique:labels,label_name,id,id,deleted_at,NULL']
        ];
        $validator = Validator::make($request->all(),$rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        try {
            $data_insert = $request->except(['_method','_token']);
            $data_insert+=[
                'created_at'=> new \DateTime()
            ];
            $this->label_model->insert($data_insert);
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
            'success'=>'Label has been added'
        ];
        return redirect()->back()->with($response);
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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

        $rules = [
            'label_name'=>['required','unique:labels,label_name,'.$id.',id,deleted_at,NULL']
        ];
        $validator = Validator::make($request->all(),$rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        try {
            $label = $this->label_model->find($id);
            foreach ($request->except(['_method','_token']) as $key=>$value) {
                $label->$key = $value;
            }
            $label->save();
            // $this->label_model->insert($data_insert);
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
            'success'=>'Label has been updated'
        ];
        return redirect()->back()->with($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $label = $this->label_model->find($id);
        if ($label) {
            $label->delete();
            $response = [
                'success'=>'Label '.$label->label_name.' has been deleted'
            ];
            return redirect()->back()->with($response);
        }else {
            $response = [
                'error'=>'Label not found'
            ];
            return redirect()->back()->with($response);
        }
    }
}
