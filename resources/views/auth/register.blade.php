@extends('template')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                @if( \Illuminate\Support\Facades\Cookie::get('auth') === null )
                    <div class="card-header">{{ __('Register') }}</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('apiAuth') }}">
                            @csrf
                            <input type="hidden" name="url" value="register">
                            @if (session('err'))
                                @if (is_array(session('err')))
                                    <div class="alert alert-danger">
                                        <ul class=" m-0">
                                            @foreach(session('err') as $errors)
                                                <li>{{ implode('</li><li>', $errors) }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @else
                                    <div class="alert alert-danger m-0">
                                        <ul class=" m-0"><li>{{ session('err') }}</li></ul>
                                    </div>
                                @endif
                            @endif
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" name="name" required autocomplete="name" autofocus>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control " name="email"required autocomplete="email">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" name="password" required autocomplete="new-password">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Register') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                @else
                    <div class="container col-md-8">
                        <div class="m-5 d-flex justify-content-center">Вы уже авторизированы</div>
                    </div>
                @endif
        </div>
        </div>
    </div>
</div>
@endsection
