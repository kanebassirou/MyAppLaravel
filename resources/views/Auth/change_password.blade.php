@extends('base')
@section('title','changer votre mot de passe')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-5 mx-auto">
            <h1 class="text-center text-muted mb-3 mt-3">changer votre mot de passe</h1> 
            <p class="text-center text-muted mb-5">SVP veuillez entrer votre nouveau mot de passe</p> 
            <form method="POST" action="{{route('app_change_password',['token'=>$activation_token])}}">
                @csrf
                @include('alert.alert-message')
                <label for="new_password" class="form-label ">votre nouveau mot de passe</label>
                <input type="password" name="new_password" id="new_password_confirm" class="form-control mb-3 @error('password-error') is-invalid @enderror @error('password-success') is-valid @enderror" placeholder="entrer votre nouveau mot de passe " value="@if (Session::has('old-new-password')){{Session::get('old-new-password')}}@endif">

                <label for="new_password_confirm" class="form-label">confirmer votre nouveau mot de passe</label>
                <input type="password" name="new_password_confirm" id="new_password_confirm" class="form-control mb-3 @error('password-confirm-error') is-invalid @enderror" placeholder="confirmer votre nouveau mot de passe " value="@if (Session::has('old-new-password-confirm')){{Session::get('old-new-password-confirm')}}@endif">

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">Nouveau mot de passe</button>
                </div>
        </div>
    </div>
</div>

@endsection