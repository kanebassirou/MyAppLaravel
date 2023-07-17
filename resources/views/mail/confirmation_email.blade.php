<h1>Hi {{$name}} veuillez confirmer votre email</h1>
<p>si vous plais activer votre compte en copiant et collant le code d'activation.
    <br>Activation code : {{$activation_code}} .<br>
    ou bien cliquer sur le lien : <br>
    <a href="{{route('app_activation_account_link',['token'=>$activation_token])}}" target="_blank">confirmation de compte</a>
    
 
</p>
<p>
    My app_lar !!!
</p>