@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-3 p-5">
                <img class="rounded-circle img-thumbnail" style=" width: 100%;"
                     src="/storage/{{$user->profile->profileImage()}}">
            </div>
            <div class="col-9 pt-5">
                <div class="d-flex justify-content-between align-items-baseline">
                    <div class="d-flex align-items-center pb-3">
                        {{--$user foi criado e disponibilizado na view pelo controller da rota--}}
                        <div class="h4">{{$user->username}}</div>
                            @can('view' , $user->profile)
                                <follow-button
                                    user-id="{{$user->id}}"
                                follows="{{$follows}}"></follow-button>
                            @endcan
                        {{--                        <follow-button user-id="{{ $user->id }}" follows="{{ $follows }}"></follow-button>--}}
                    </div>


                    {{--Faz a checagem de autorizaçao a partir da permissao da policy--}}
                    {{--identificada pelo tipo de obejto passa no segundo param--}}
                    @can('update' , $user->profile)
                        <a href="/post/create">Add New Post</a>
                    @endcan

                </div>


                <div class="d-flex">
                    <div class="pr-5"><strong> {{$user->posts->count()}} </strong> posts</div>
                    <div class="pr-5"><strong> {{$user->profile->followers->count()}} </strong> followers</div>
                    <div class="pr-5"><strong> {{$user->following->count()}}  </strong> following</div>
                </div>
                <div class="d-flex">
                    <div class="pt-4 font-weight-bold"> {{$user->profile->title}}</div>
                    <div class="pt-4 ml-2">
                        {{--Faz a checagem de autorizaçao a partir da permissao da policy--}}
                        {{--identificada pelo tipo de obejto passa no segundo param--}}
                        @can('update' , $user->profile)
                            <a class="small" href="/profile/{{$user->id }}/edit">Edit Profile</a>
                        @endcan
                    </div>
                </div>
                <div> {{$user->profile->description}}</div>
                <div><a href="{{ $user->profile->url}}"> {{ $user->profile->url}} </a></div>
            </div>
        </div>

        <div class="row pt-5">
            @foreach($user->posts as $post)
                <div class="col-4 pb-4">
                    <a href="/post/{{$post->id}}">
                        <img src="/storage/{{$post->imgUrl}}"
                             class="w-100">
                    </a>
                </div>
            @endforeach
        </div>
    </div>

@endsection
