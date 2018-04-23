<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Session;

class EventController extends Controller
{
    public function createEvent(Request $Request)
    {
    	$company_id = session('Cdata')->user->company_id;
       $client = new Client([
            'headers' => ['Accept'=>'application/json','Authorization'=>'Bearer '.session('Cdata')->uid]
        ]);

        $response = $client->request('POST','http://kinna.000webhostapp.com/api/v1/companyUsers',[
            'form_params'=> [
                'company_id'=>$company_id,
                 ]
        ]); 

        $data= $response->getBody();
        $Cdata= json_decode($data);
        //dd($Cdata) ;
        return view('createEvent',compact('Cdata'));
    }

    public function submitEvent(Request $Request)
    {
    	$company_id=$Request->input('company_id');
    	$name=$Request->input('name');
    	$description=$Request->input('description');
    	$date=$Request->input('date');
    	$user_id=$Request->input('user_id');
    	//dd($user_id);
    	$client = new Client([
            'headers' => ['Accept'=>'application/json','Authorization'=>'Bearer '.session('Cdata')->uid]
        ]);

        $response = $client->request('POST','http://kinna.000webhostapp.com/api/v1/events',[
            'form_params'=> [
            	'company_id'=>$company_id,
                'name'=> $name,
                //'category'=> $category,
                'description'=> $description,
                'start_date'=>$date,

                'user_id'=>$user_id,
                ]
        ]);
        
        $data= $response->getBody();
        $Cdata= json_decode($data);
        dd($Cdata);
    }
}
