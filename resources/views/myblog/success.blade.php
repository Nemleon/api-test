@extends('template')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <div class="alert alert-success text-center">
                            {{ $content }}
                        </div>
                        @if( \Illuminate\Support\Facades\Cookie::get('auth') !== null )
                            <div>
                                <a class="btn btn-link" href="{{ url()->previous() }}">Вернуться назад</a>
                            </div>
                        @else
                            <div>
                                <a class="btn btn-link" href="{{ route('mainPage') }}">Вернуться на главную</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
