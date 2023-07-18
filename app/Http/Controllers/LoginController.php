<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Services\EmailService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
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

        $user =user::where('activation_token',$token)->first();
         if(!$user){
            return redirect()->route('login')->with('danger',"votre token ne correspond pas à aucun utilisateur.");
         }
        if($this->request->isMethod('post')){  //s'execute si uniquement si le formulaire est soumis
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
    public function resendActivationCode($token){
        $user =user::where('activation_token',$token)->first();
        $email =$user->email;
        $name =$user->name;
        $activation_token=$user->activation_token;
        $activation_code=$user->activation_code;
        $emailSend = new EmailService;
        $subject = "Activer votre compte";
                       $emailSend->sendEmail($subject,$email,$name,true,$activation_code,$activation_token);
                       return redirect()->route('app_activation_code',['token' =>$token])
                                ->with('success',"un nouveau code d'activation est envoye");

    }
    public function activationAccountLink($token){
        $user =user::where('activation_token',$token)->first();
         if(!$user){
            return redirect()->route('login')->with('danger',"votre token ne correspond pas à aucun utilisateur.");
         }
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
    public function activationAccountChangeEmail($token){
        $user =user::where('activation_token',$token)->first();

        if($this->request->isMethod('post')){ 
            $new_email = $this->request->input('new_email');
            $user_existe = user::where('email',$new_email)->first();
            // dd($new_email);
            if($user_existe){
                return back()->with([
                    'danger' =>"votre adress est déja utiliser SVP entrer un autre adresse email",
                    'new_email'=>$new_email,
                ]);

            }else{
                DB::table('users')
                ->where('id',$user->id)
                ->update([
                    'email' => $new_email,
                    'updated_at'=> new \DateTimeImmutable
                ]);
                $activation_code = $user->activation_code;
                $activation_token =$user->activation_token;
                $name =$user->name;
                $emailSend = new EmailService;
                $subject = "Activer votre compte";
 
                $emailSend->sendEmail($subject,$new_email,$name,true,$activation_code,$activation_token);
                return redirect()->route('app_activation_code',['token' =>$token])
                                ->with('success',"nous avons envoyé un nouveau code d'activation par email avec l'adresse email fourni !!!");

                
            }


        }else{
            return view('Auth.changeEmail',['token'=> $token]);

        }

    }
}
