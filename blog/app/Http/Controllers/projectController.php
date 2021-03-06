<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Session;

class projectController extends Controller
{
    //
    protected $adminData;

    // public function __construct( AdminController $admin)
    // {
    // 	$this->adminData= $admin;
    // }
     public function getProjectData(Request $Request)
    {
        //$token=session('Cdata')->uid;
        //dd(session('Cdata'));

        $name=$Request->input('name');
        $category=$Request->input('category');
        $start_date=$Request->input('start_date');
        $end_date=$Request->input('end_date');
        $company_id=session('Cdata')->user->company_id;
        $developers=$Request->input('developers');
        //dd($developers);
        $client = new Client([
            'headers' => ['Accept'=>'application/json','Authorization'=>'Bearer '.session('Cdata')->uid]
        ]);

        $response = $client->request('POST','http://kinna.000webhostapp.com/api/v1/projects',[
            'form_params'=> [
                'name'=> $name,
                'category'=> $category,
                // 'description'=> $description,
                'start_date'=>$start_date,
                'end_date'=>$end_date, 
                'company_id'=>$company_id,
                'developers'=>$developers,
                ]
        ]);
        
        $data= $response->getBody();
        $Cdata= json_decode($data);
        //$project_id=$Cdata->id;
        //$this->project_id = $Cdata->id;
        dd($Cdata);
        
        //return view('/');
        
    }
//view all projects
    public function viewProjects(Request $Request)
    {
        $client = new Client([
            'headers' => ['Accept'=>'application/json','Authorization'=>'Bearer '.session('Cdata')->uid]
        ]);

        $response = $client->request('POST','http://kinna.000webhostapp.com/api/v1/companyProjects',[
            'form_params'=> [
                'company_id'=>session('Cdata')->user->company_id,
                 ]
        ]);

        $data= $response->getBody();
        $Cdata= json_decode($data);
        
        //dd($Cdata) ;
        return view('/viewProjects',compact('Cdata'));
        
    }

//view specific project
    public function viewProject(Request $Request)
    {

        $project_id=$Request->input('id');
        //dd($project_id);
        $client = new Client([
            'headers' => ['Accept'=>'application/json','Authorization'=>'Bearer '.session('Cdata')->uid]
        ]);

        $response = $client->request('POST','http://kinna.000webhostapp.com/api/v1/projectTeamMembers',[
            'form_params'=> [
                'project_id'=>$project_id,
                 ]
        ]);

        $data= $response->getBody();
        $Cdata= json_decode($data);
        
        //dd($Cdata);
        return view('/viewProjectOne',compact('Cdata')) ;
    }

//direct to project creation
    public function createProject(Request $Request)
    {   

       $company_id = session('Cdata')->user->company_id;
       $client = new Client([
            'headers' => ['Accept'=>'application/json','Authorization'=>'Bearer '.session('Cdata')->uid]
        ]);

        $response = $client->request('POST','http://kinna.000webhostapp.com/api/v1/availableUsers',[
            'form_params'=> [
                'company_id'=>$company_id,
                 ]
        ]); 

        $data= $response->getBody();
        $Cdata= json_decode($data);
        //dd($Cdata) ;
        return view('/createProjects',compact('Cdata'));
    }
}
