@extends('base')
@section('title','mot de oublié')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-5 mx-auto">
            <h1 class="text-center text-muted mb-3 mt-3">mot de passe oublié</h1> 
            <p class="text-center text-muted mb-5">SVP veuillez entrer votre adresse email pour reset votre mot de passe</p> 
            <form action="{{route('app_forgot_password')}}" method="post">
                @csrf
                @include('alert.alert-message')
                <label for="email-send" class="form-label">Email</label>
                <input type="email" name="email-send" class="form-control @error('email-success')is-valid @enderror @error('email-error')is-invalid @enderror"  placeholder="svp entrer votre adresse email" value="@if (Session::has('old_email')){{Session::get('old_email')}}@endif" required>
                <div class="d-grid gap-2 mt-4 mb-5">
                    <button class="btn btn-primary" type="submit">Reset mot de passe</button> 
                 </div>
                 <p class="text-center muted">Retour
                 <a href="{{route('login')}}">Login</a>
                 </p>

            </form>
        </div>

    </div>
</div>
@endsection