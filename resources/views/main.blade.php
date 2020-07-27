@extends('template')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card mb-3">
                    <div class="card-header text-center">
                        <strong>Привет! Хотите посмотреть статьи или на пользователей?</strong>
                    </div>
                    <div class="card-body d-flex flex-row justify-content-around">
                        <a class="btn btn-primary" href="{{ route('getAllPosts') }}">Статьи</a>
                        <a class="btn btn-success" href="{{ route('getAllUsers') }}">Пользователи</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
