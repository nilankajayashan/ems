@extends('Template.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5">
                <div class="card shadow-lg border-0 rounded-lg mt-5">
                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Siyatha EMS Login</h3></div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="form-group">
                                <input type="text" class="mb-3 form-control @error('user_id') is-invalid @enderror" name="user_id" value="{{ old('user_id') }}" required placeholder="Employee ID">
                                    @error('user_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                            </div>
                            <div class="form-group">
                                <input type="password" class=" form-control @error('password') is-invalid @enderror mb-2" name="password" value="{{ old('password') }}" required placeholder="Password">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                            </div>
                            <div class="form-group">
                                <div class="mb-2">
                                    <button type="submit" value="Login" name="login" class="btn btn-primary btn-block lead">
                                        {{ __('Login') }}
                                    </button>
                                </div>

                            </div>
                            <div class="text-center">
                                <span><a href="{{route('attend')}}" class="main-login"><- Back to Attend</a></span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
