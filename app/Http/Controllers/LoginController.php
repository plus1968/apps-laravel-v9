<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PlusModel;
use Illuminate\Support\Facades\DB;
// Using the Session facade
use Illuminate\Support\Facades\Session;


class LoginController extends Controller
{
    // protected $plusmodel;
    // public $user;
    public function __construct(){
        // $this->user = Session::get('USR');
    }
    
    public function login(){
        return view('auth.login');
    }
    public function checklogin(Request $request){

        $input = $request->all();
        $USR = DB::select("WITH USR AS (SELECT id,name,SHO_ID,GT_ID FROM TB_DBO_USR WHERE username = '".$input['username']."' AND password = '".$input['password']."')
        SELECT * FROM USR ");
        if(!empty($USR)){
            // Session::put('USR',$USR[0]);
           
            return response()->json(['status' => 'OK','result'=>'active-user','data'=>$USR[0]], 200);


        }else{
            return response()->json(['status' => 'OK','result'=>'not-user'], 200);
        }
        // return view('login.login');
    }
}
