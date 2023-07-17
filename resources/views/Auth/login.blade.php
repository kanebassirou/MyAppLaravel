@extends('base')
@section('title','login')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4 mx-auto">
       <h1><div class="text-center text-muted mb-3 mt-5">please sign in</h1> 
        <p class="text-center text-muted mb-5">veuillez connecter vos article vous attend</p> 
        <form method="POST" action="{{route('login')}}">
            @csrf
         @include('alert.alert-message')
          
            @error('email')
            <div class="alert alert-danger text-center" role="alert">
                {{$message}}
              </div>
              @enderror

            @error('password')
            <div class="alert alert-danger text-center" role="alert">
                {{$message}}
              </div>
              @enderror
              <label for="email">Email</label>
              <input type="email" name="email" id="email" class="form-control mb-3 @error('email') is-invalid @enderror" value="{{old('email')}}" required autocomplete="email" autofocus>
              <label for="password">Password</label>
              <input type="password" name="password" id="password" class="form-control mb-3 @error('password') is-invalid @enderror""required autocomplete="current-password" autofocus>
              <div class="row mb-3">
                 <div class="col-md-6">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="remember" name="remember" {{old('remember') ? 'checked' : ''}}>
                        <label class="form-check-label" for="remember">Souvenez de moi</label>
                      </div>
                 </div>
                 <div class="col-md text-end">
                    <a href="#">mot de passe oublie</a>
                 </div>
                 <div class="d-grid gap-2">
                    <button class="btn btn-primary" type="submit">sign in </button> 
                 </div>
              </div>
              <p class="text-center text-muted mt-5">Pas encore en enregistre ? <a href="{{route('register')}}">Creer une compte</a></p>
        </form>
        
                 
            </div>
        </div>

    </div>
</div>
@endsection 