<?php

namespace App\Http\Controllers;
use App\customer;

use Datatables;

use Illuminate\Http\Request;


use Validator;

use Twilio\Rest\Client;
use Twilio\Jwt\ClientToken;

class customerscontroller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //inicio
            if(request()->ajax())
        {
            return datatables()->of(customer::latest()->get())
                    ->addColumn('action', function($data){
                        $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-primary btn-sm">Edit</button>';
                        $button .= '&nbsp;&nbsp;';
                        $button .= '<button type="button" name="delete" id="'.$data->id.'" class="delete btn btn-danger btn-sm">Delete</button>';
                        return $button;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('customer');

        //fin

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
        //
        
       $rules = array(
            'FirstName'    =>  'required',
            'LastName'     =>  'required',
            'CellularPhone'     =>  'required',
            'Email'     =>  'required'
            

            
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        

        $form_data = array(
            'FirstName'        =>  $request->FirstName,
            'LastName'         =>  $request->LastName,
            'CellularPhone'     =>  $request->CellularPhone,
            'Email'     =>  $request->Email
            

        );

        //inicio
                     $accountSid = config('app.twilio')['TWILIO_ACCOUNT_SID'];
                        $authToken  = config('app.twilio')['TWILIO_AUTH_TOKEN'];
                     $client = new Client($accountSid, $authToken);

                     $sms = $client->account->messages->create(
                                $form_data['CellularPhone'],

                                array(
                                    'from' => "+123456789",  //your valid twilio nunmber
                                    'body' => "Hello ". $form_data['FirstName']. " Welcome to City Hall alert system, Stay Home Stay Safe  ",
                                    "mediaUrl" => array("http://localhost/mms/public/mms/w.png")//localhost or your ip o your domain
                                    )
                                );

        //fin

        customer::create($form_data);

        return response()->json(['success' => 'Data Added successfully.']);

        

        
       
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
        if(request()->ajax())
        {
            $data = customer::findOrFail($id);
            return response()->json(['data' => $data]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
       
        
            $rules = array(
                'FirstName'    =>  'required',
                'LastName'     =>  'required',
                'CellularPhone'     =>  'required',
                'Email'     =>  'required'
            );

            $error = Validator::make($request->all(), $rules);

            if($error->fails())
            {
                return response()->json(['errors' => $error->errors()->all()]);
            }
        

        $form_data = array(
            'FirstName'       =>   $request->FirstName,
            'LastName'        =>   $request->LastName,
            'CellularPhone'        =>   $request->CellularPhone,
            'Email'        =>   $request->Email
            
        );
        customer::whereId($request->hidden_id)->update($form_data);

        return response()->json(['success' => 'Data is successfully updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = customer::findOrFail($id);
        $data->delete();
    }
}
