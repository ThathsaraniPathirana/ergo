<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Session;
use App\Http\Controllers\mailConroller;
use Mail;
//use Illuminate\Support\Facades\Storage;

// use GuzzleHttp\Psr7;
// use GuzzleHttp\Exception\RequestException;


class AdminController extends Controller
{
    //
    protected $mail;

    //protected $error_code = null;

    public function loading(Request $Request)
    {
        $error_code= null;
        return view('/landing',compact('error_code'));
    }

    public function getRegistration(Request $Request) //admin register function
    {
        $fname = ucfirst($Request->fname);
        $lname = ucfirst($Request->lname);
        $email = $Request->email;
        $companyName = $Request->companyName;
        $password = $Request->password;
    
        $client = new Client([
            'headers' => ['Accept'=>'application/json']
        ]);
        $response = $client->request('POST','http://kinna.000webhostapp.com/api/adminRegister',[
            'form_params'=> [
                'fname'=> $fname,
                'lname'=> $lname,
                'email'=> $email,
                'companyName'=> $companyName,
                'password'=> $password,
                 ]
        ]);
        $data= $response->getBody();
        $Cdata= json_decode($data);
        //dd($Cdata);
        $error=$Cdata->error;
        
        //return view('/landing');
        if($error==false)
        {
            return view('/getdata1');
        }else {
            $error_code=$Cdata->error_code;
            return view('/landing',compact('error_code'));
        }

    }


    public function getLoginData(Request $Request)// login function
    {
    	
    	$email= $Request->email ;
    	$password= $Request->password ;

    	$client = new Client([
            'headers' => ['Accept'=>'application/json']
        ]);

    	$response = $client->request('POST','http://kinna.000webhostapp.com/api/adminLogin',[
            'form_params'=> [
                'email'=> $email,
                'password'=> $password ]
        ]);


    	$data= $response->getBody();
        $Cdata= json_decode($data);
        //dd($Cdata);
        // $token = $Cdata->uid;
        
        // $user= $Cdata->user;
        // $user_id = $user->userid;
        // $company_id =$user->company_id;
        // //error catching
        
        $error = $Cdata->error;
        session(['Cdata' =>$Cdata]); 
        //dd(session('token'));
        //dd($Cdata);
       
        if($error==false){
            return view('/Dashboard');
        }else{
             $error_code=$Cdata->error_code;
            return view('/landing',compact('error_code'));
        }
        
       
    }
  

    public function loadmember(Request $Request)
    {
        $error_code= null;
        return view('/addmember',compact('error_code'));
    }

    public function viewsubmitUser(Request $Request)
    {
        //dd(session('token'));

        $fname=ucfirst($Request->fname);
        $lname=ucfirst($Request->lname);
        $email=$Request->email;
        $role=$Request->role;
        $this->mail=$email;
        switch ($role) {
            case "Project Manager":
                $role_id=3;
                break;
            case "Developer":
                $role_id=4;
                break;
            
            default:
                $role_id=4;
                break;
        }
        $company_id=session('Cdata')->user->company_id;
        $password=str_random(10);
        $trial_password= $password;

        $client = new Client([
            'headers' => ['Accept'=>'application/json','Authorization'=>'Bearer '.session('Cdata')->uid]
        ]);
        $response = $client->request('POST','http://kinna.000webhostapp.com/api/v1/viewsubmitUser',[
            'form_params'=> [
                'fname'=> $fname,
                'lname'=> $lname,
                'email'=> $email,
                'password'=>$password,
                'trial_password'=>$trial_password,
                'role_id'=> $role_id,
                'company_id'=> $company_id ]
        ]);
        $data= $response->getBody();
        $Cdata= json_decode($data);

        //dd($Cdata);
        $error= $Cdata->original->error;
       

        if($error==false){
            Mail::send('email/registerMail',['email'=>$email,'password'=>$password],function($message)
            {
                $message->from('vish2015offcial@gmail.com','vish2015offcial');
                $message->to($this->mail);
                $message->subject('user credentials');
            });
            $error_code= 100;
            return view('/addmember',compact('error_code'));
        }else{
             $error_code=$Cdata->original->error_code;
            return view('/addmember',compact('error_code'));
        }

        //return('/');
        // $this->mail=$email;
        // $this->pass=$password;

        // Mail::to($email)->send(new registerMail());
    }

//view my account
    public function viewUserData(Request $Request)
    {
        //dd(session('Cdata'));
        $session=session('Cdata');
        $token=$session->uid;
        $user=$session->user;
        //dd($token);
        $client = new Client([
            'headers' => ['Accept'=>'application/json','Authorization'=>'Bearer '.$token]
        ]);

        $response = $client->request('POST','http://kinna.000webhostapp.com/api/v1/userProfile',[
            'form_params'=> [
                'user_id'=>$user->userid,
                 ]
        ]);

        $data= $response->getBody();
        $Cdata= json_decode($data);
        //dd($Cdata);
        return view('/viewmemberOne',compact('Cdata')); 
    }
//view all users
     public function viewAllUsers(Request $Request)
    {
        //dd(session('Cdata'));
        // $session=session('Cdata');
        // $token=$session->uid;
        // $user=$session->user;
        //dd($token);
        $client = new Client([
            'headers' => ['Accept'=>'application/json','Authorization'=>'Bearer '.session('Cdata')->uid]
        ]);

        $response = $client->request('POST','http://kinna.000webhostapp.com/api/v1/companyUsers',[
            'form_params'=> [
                'company_id'=>session('Cdata')->user->company_id,
                 ]
        ]);

        $data= $response->getBody();
        $Cdata= json_decode($data);
        //dd($Cdata);
        return view('/viewmember',compact('Cdata')); 
    }

    public function getTaskData(Request $Request)
    {
        //$token=session()->get('Cdata');
        $$project=$Request->input('project');
        $user=$Request->input('user');
        $name=$Request->input('name');
        $start_date=$Request->input('start_date');
        $end_date=$Request->input('end_date');

        $client = new Client([
            'headers' => ['Accept'=>'application/json','Authorization'=>'Bearer '.$this->token]
        ]);

        $response = $client->request('POST','http://kinna.000webhostapp.com/api/v1/projects',[
            'form_params'=> [
                'project'=> $project,
                'user'=> $user,
                'name'=> $name,
                // 'description'=> $description,
                'start_date'=>$start_date,
                'end_date'=>$end_date, ]
        ]);

        

        
         $data= $response->getBody();
        $Cdata= json_decode($data);
        $error= $Cdata->error;
        
        
        //$this->project_id = $Cdata->id;
        //return view('/dashboard', compact('Cdata') );
        
    }

     public function viewTaskData(Request $Request)
    {
        $client = new Client([
            'headers' => ['Accept'=>'application/json','Authorization'=>'Bearer '.$this->token]
        ]);

        $response = $client->request('POST','http://kinna.000webhostapp.com/api/v1/projects',[
            'form_params'=> [
                'user_id'=>$this->user_id,
                 ]
        ]);

        $data= $response->getBody();
        $Cdata= json_decode($data);
        
        dd($Cdata) ;
        $this->company_id= $Cdata->id;
        $this-> $Cdata->company_id;

        //return view('/dashboard', compact('Cdata') );
        
    }

}

