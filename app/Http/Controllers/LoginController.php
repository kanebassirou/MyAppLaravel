<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Services\EmailService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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
    public function forgotPassword(){
        if($this->request->isMethod('post')){
          $email = $this->request->input('email-send'); 
          $user = DB::table('users')->where('email',$email)->first();
           if($user){
            $full_name =$user->name;
            // on va generer un token pour reiniatialisation de mot de passe de user
            $activation_token = md5(uniqid() .$email . sha1($email));
            $passwordReset = new EmailService;
            $subject = "reiniatialisation de mot de passe";
             $passwordReset->resetPassword($subject, $email, $full_name, true,$activation_token);
            DB::table('users')->where('email',$email)
                              ->update(['activation_token'=>$activation_token]);
            return back()->withErrors(['email-success'=>"une message de reniatialisation de mot de passe est envoyé par email verifier votre boite emails"])
            ->with('old_email',$email)
           ->with('success',"une message de reniatialisation de mot de passe est envoyé par email verifier votre boite emails");;

           }else{
            return back()->withErrors(['email-error'=>"votre adresse email ne correspond à aucun utilisateur"])
                        ->with('old_email',$email)
                        ->with('danger',"votre adresse email ne correspond à aucun utilisateur");
           }

        }
        return view('Auth.forgot_password');
    }
    public function changePassword($token){
        if($this->request->isMethod('post')){
            $newPassword = $this->request->input('new_password');
            $message =null;
            $newPasswordConfirm = $this->request->input('new_password_confirm');
            $passwordLenght = strlen($newPassword);
            if($passwordLenght >=8){
               if ($newPassword == $newPasswordConfirm ){

                $user = DB::table('users')->where('activation_token',$token)->first();
                if($user){
                    $id_user = $user->id;
                    DB::table('users')
                    ->where('id',$id_user)
                    ->update([
                        'password'=>Hash::make($newPassword),
                        'updated_at'=> new \DateTimeImmutable,
                        'activation_token'=>''

                    ]);
                    return redirect()->route('login')->with('success','nouveau mot de passe enregistre avec succe');
                }else{
                    return back()->with('danger','votre token ne correspond à aucun utilisateur');
                }

                dd('ok');
            } else{
                $message ="les deux mot de passe ne sont pas identique !";
                return back()->withErrors(['password-confirm-error' =>$message,'password-success'=>'success'])
                            ->with('danger',$message)
                            ->with('old-new-password-confirm',$newPasswordConfirm)
                            ->with('old-new-password',$newPassword);
               
                } 

            }else{
                $message ="votre mot de passe doit contenir au moins 8 caracteres !";
                return back()->withErrors(['password-error' =>$message])
                            ->with('danger',$message)
                            ->with('old-new-password',$newPassword);
            }
        }
        return view('Auth.change_password',['activation_token'=>$token]);

    }
}
