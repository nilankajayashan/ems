@extends('Template/app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-5">
            <div class="card shadow-lg border-0 rounded-lg mt-5">
                <div class="card-header"><h3 class="text-center font-weight-light my-4">Siyatha EMS Login</h3></div>
                <div class="card-body">
                    @if(session()->has('message'))
                        @if(session()->get('state'))
                            <div class='alert alert-success alert-dismissible fade show'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> {{ session()->get('message') }} </div>
                        @else
                            <div class='alert alert-danger alert-dismissible fade show'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><strong>Error!</strong> {{ session()->get('message') }} </div>
                        @endif
                    @endif
                    <form method="POST" action="{{ route('start_work_guest') }}">
                        @csrf
                        <div class="form-group">
                            <input id="user_id" type="text" class="mb-3 form-control @error('user_id') is-invalid @enderror" name="user_id" value="{{ old('user_id') }}" required autocomplete="user_id" autofocus placeholder="Employee ID">
                            @error('user_id')
                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                            @enderror
                        </div>


                        <div class="form-group">
                            <div class="mb-2">
                                <button type="submit" value="Login" name="login" class="btn btn-primary btn-block lead">
                                    {{ __('Attend') }}
                                </button>
                            </div>

                        </div>

                        @if (Route::has('login'))
                            <div class="text-center">
                                @auth
                                    <a href="{{ route('dashboard',['state' => 'dashboard']) }}" class="main-login">Dashboard</a>
                                @else
                                    <a href="{{ route('login') }}" class="main-login">Login</a>

                                @endauth
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
