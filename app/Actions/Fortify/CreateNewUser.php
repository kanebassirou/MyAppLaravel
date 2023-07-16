<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Services\EmailService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        /*Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],  
            'password' => $this->passwordRules(),
        ])->validate();*/
        $email = $input['email'];
        // generer le token pour l'activation du compte de l'utilisateur
        $activation_token = md5(uniqid() .$email . sha1($email));
        $activation_code ="";
        $length = 5;
        for($i=0; $i< $length; $i++){
            $activation_code .=mt_rand(0,9);
        }

        $name = $input['firstname'].' '.$input['lastname'];

        $emailSend = new EmailService;
        $subject = "Activer votre compte";
        $message ="A" . $name . "SVP veuillez activer votre compte et copier et coller votre code d'activation :" .$activation_code . "cliquer sur le lien 
        ci dessous pour activer votre compte" .$activation_token;
        $emailSend->sendEmail($subject,$email,$name,false,$message);
        return User::create([
            'name' => $name,
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'activation_code'=>$activation_code,
            'activation_token'=>$activation_token,

        ]);
    }
}
