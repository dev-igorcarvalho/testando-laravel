@extends('layouts.app')

@section('content')
    <div class="container">
        @foreach($posts as $post)
            <div class="row pt-2 pb-5">
                <div class="col-6 offset-2">
                    <a href="/profile/{{ $post->user->id }}">
                        <img src="/storage/{{ $post->imgUrl }}" class="w-100">
                    </a>
                </div>
                <div class="col-4">

                    <div class="row">
                        <div class="col-12">
                            <p>
                            <span class="font-weight-bold">
                                <a href="/profile/{{ $post->user->id }}">
                                    <span class="text-dark">{{ $post->user->username }}</span>
                                </a>
                            </span>
                            </p>
                            <p>
                                {{ $post->caption }}
                            </p>
                        </div>
                    </div>
                </div>

            </div>

        @endforeach

        <div class="row">
            <div class="col-12 d-flex justify-content-center">
{{--                bruxaria do laravel que cria o paginador automaticamente qd o metodo de busca tem um paginador--}}
                {{ $posts->links() }}
            </div>
        </div>
    </div>
@endsection
