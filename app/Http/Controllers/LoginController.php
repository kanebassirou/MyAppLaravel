<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\MockObject\Stub\ReturnSelf;

class LoginController extends Controller
{
    protected $request;
    function __construct(Request $request){
        $this->request=$request;

    }
   
    public function logout(){
        Auth::logout();
        return redirect()->route('login');
    }

    public function existEmail(){
        $email =$this->request ->input('email');
        $user = User::where('email',$email)
                ->first();
        $response ='';
        ($user)? $response ="exit" : $response ="not_exist";
        return response()->json([
            'response'=>$response
        ]);
    }
    public function activationCode($token){
      
        if($this->request->isMethod('post')){
            $user =user::where('activation_token',$token)->first();
            $code = $user->activation_code; 
            $activation_code =$this->request->input('activation-code');
            if($activation_code != $code){
                return back()->with([
                    'danger' =>"votre code d'activation est incorrect",
                    'activation_code'=>$activation_code
                ]);

            }else{
                DB::table('users')
                      ->where('id',$user->id)
                      ->update([
                        'is_verified'=>1,
                        'activation_code' =>'',
                        'activation_token'=>'',
                        'email_verified_at'=>new \DateTimeImmutable,
                        'updated_at'=> new \DateTimeImmutable
                      ]);
                      return redirect()->route('login')->with('success',"votre address mail est verifier !");
            }  
                                        
        }
        return view('auth.activation_code',[
            'token'=>$token
            ]);
    }
    // verifier si l'utilisateur à deja active son compte avant de connecter
    public function userChecher(){
    $activation_token = Auth::user()->activation_token;
    $is_verified = Auth::user()->is_verified;
    if($is_verified !=1){
        Auth::logout();
        return redirect()->route('app_activation_code',['token'=>$activation_token])
                           ->with('warning',"votre compte n'est pas activer,veuillez verifier votre boite email ou sms de confirmation est envoyé
                           pour activer votre compte si il n'est envoyé demander un envoie de nouveaux mail de confirmation." );
    }else{
        return redirect()->route('app_dashboard');
    }
    }
}
