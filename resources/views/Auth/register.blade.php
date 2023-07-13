@extends('base')
@section('title','register')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-5 mx-auto">
            <h1 class="text-center text-muted mb-3 mt-3">Register</h1> 
            <p class="text-center text-muted mb-5">creer une compte si vous n'avez pas</p> 
            <form id="registerForm" method="POST" action="{{route('register')}}" class="row g-3">
                @csrf
                <div class="col-md-6">
                    <label for="firstname" class="form-label">nom</label>
                    <input type="text" class="form-control" id="firstname" name="firstname" value="{{old('firtname')}}" required autocomplete="firstname" autofocus>
                    <small class="text-danger fw-bold" id="error-register-firstname"></small>
                  </div>
                <div class="col-md-6">
                    <label for="lastname" class="form-label">Prenom</label>
                    <input type="text" class="form-control" id="lastname" name="lastname" value="{{old('lastname')}}" required autocomplete="lastname" autofocus>
                    <small class="text-danger fw-bold"  id="error-register-lastname"></small>
                  </div>
                <div class="col-md-12">
                    <label for="email" class="form-label">email</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{old('email')}}" required autocomplete="email" autofocus url-emailExist = "{{route('app_existEmail')}}" token ="{{csrf_token()}}">
                    <small class="text-danger fw-bold"  id="error-register-email"></small>
                  </div>
                <div class="col-md-6">
                    <label for="password" class="form-label">password</label>
                    <input type="password" class="form-control" id="password" name="password" value="{{old('password')}}" required autocomplete="password" autofocus>
                    <small class="text-danger fw-bold"  id="error-register-password"></small>
                  </div>
                <div class="col-md-6">
                    <label for="password-confirmation" class="form-label">password confirmation</label>
                    <input type="password" class="form-control" id="password-confirmation" name="password-confirmation" value="{{old('password-confirmation')}}" required autocomplete="password" autofocus>
                    <small class="text-danger fw-bold"  id="error-register-password-confirmation"></small>
                  </div>
                  <div class="col-md-12">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="agreeTerms">
                        <label class="form-check-label" for="agreeTerms">Agree terms</label>
                        <small class="text-danger fw-bold"  id="error-register-agreeTerms"></small>

                      </div>
                  </div>
                  <div class="d-grid gap-2">
                    <button class="btn btn-primary" type="button" id="register-user">Register</button>

                  </div>
                  <p class="text-center text-muted mt-5">Si vous un compte connecter Vous ? <a href="{{route('register')}}">Creer une compte</a></p>



            </form>

        </div>
    </div>
</div>
@endsection