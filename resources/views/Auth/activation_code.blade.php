@extends('base')
@section('title','activation compte')
@section('content')
<div class="container">
        <div class="row">
            <div class="col-md-4 mx-auto">
                <h1><div class="text-center text-muted mb-3 mt-5">Activation compte</h1>

                    @if (Session::has('warning'))
                      <div class="alert alert-warning text-center" role="alert">
                        {{Session::get('warning')}}
                      </div>  
                    @endif
                    {{-- pour les message danger --}}
                 @if (Session::has('danger'))
               <div class="alert alert-danger text-center" role="alert">
                {{Session::get('danger')}}
                      </div>  
                       @endif
                    
                    <form method="POST" action="{{route('app_activation_code',['token'=>$token])}}">
                        @csrf
                        <div class="mb-3">
                            <label for="activation-code" class="form-label">Code d'activation</label>
                            <input type="text" class="form-control @if(Session::has('danger')) is-invalid @endif" name="activation-code" id="activation-code" value="@if(Session::has('activation_code')) {{Session::get('activation_code')}} @endif">
                        </div>
                       
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <a href="#">Changer votre adresse email </a>
                            </div>
                            <div class="col-md-6 text-end"><a href="#">Renvoyer un code d'activation</a></div>
                        </div>
                        <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">Activer</button>
                    </div>

                    </form>

            </div>
        </div>

</div>
    
@endsection