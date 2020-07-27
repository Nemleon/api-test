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
                        <div>
                            <a class="btn btn-link" href="{{route('mainPage')}}">Вернуться на главную</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
