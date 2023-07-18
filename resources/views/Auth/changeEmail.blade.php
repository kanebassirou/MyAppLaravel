@extends('base')
@section('title','changer votre adreese email')
@section('content')
<div class="container">
    <div class="row mb-3">
        <div class="col-md-4 mx-auto">
            <h2><div class="text-center text-muted mb-3 mt-5">Changer votre adresse email !!!</h2>
                @include('alert.alert-message')
          <form action="{{route('app_activation_account_change_email',['token'=>$token])}}" method="post">
            @csrf
            <div class="mb-3">
             <label for="new_email" class="form-label" >nouveau Email</label>
                <input type="email" name="new_email" class="form-control @if(Session::has('danger')) is-invalid @endif"  id="new_email" value="@if(Session::has('new_email')) {{Session::get('new_email')}} @endif" id="new_email" name="new_email"value="@if(Session::has('new_email')) {{Session::get('new_email')}} @endif" placeholder="votre nouvelle adress email" required>
            </div>
                 <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">Changer</button>
                 </div>
                  </div>
              </form>
        </div>
    </div>
</div>
@endsection