@extends('layouts.app')

@section('title', 'detail')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">

            @include('includes.message')
            <div class="card mb-5">
                <div class="card-header d-flex flex-row">
                    <a class="nav-link d-flex flex-row" href="{{ route('user.profile', ['id' => $image->user_id]) }}">
                        <!--img avatar-->
                        @if($image->users->image !== null)
                        <img src="{{ route('user.image', ['image_path'=>$image->users->image]) }}" 
                             class="rounded-circle" width="40" height="40" alt="avatar">
                        @else
                        <img src="{{ asset('img/default.jpg') }}" 
                             class="rounded-circle" width="40" height="40" alt="avatar">
                        @endif

                        <p class="fw-bold mb-0 ms-2 align-self-center">
                            {{ $image->users->name . ' ' . $image->users->surname }}
                            <span class="fw-bolder text-muted">
                                | &#64;{{ $image->users->nick }}
                            </span>
                        </p>
                    </a>
                    <!--icon menu ...-->
                    @if(Auth::user()->id == $image->user_id)
                    <div class="dropdown ms-auto text-end">
                        <button class="btn btn-light border-0" type="button" id="dropdownMenuButton" 
                                data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-three-dots-vertical fs-4"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                            <li><a class="dropdown-item" href="{{ route('image.edit', ['id'=>$image->id]) }}"><i class="bi bi-pencil me-2"></i> Editar</a></li>
                            <li><a class="dropdown-item" href="{{ route('image.delete', ['id'=>$image->id]) }}"><i class="bi bi-trash me-2"></i> Eliminar</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="#"><i class="bi bi-flag me-2"></i> Reportar</a></li>
                        </ul>
                    </div>
                    @endif
                </div>

                <!-- Mostrar imagen publicacion -->
                <div class="card-body p-0">
                    <div class=".container">
                        <a href="{{ route('image.detail', ['id'=>$image->id]) }}">
                            <img src="{{ route('image.images', ['images_path'=>$image->image_path]) }}" 
                                 class="w-100 h-100" alt="imagen publicacion">                            
                        </a>
                    </div>

                    <!-- icons heart -->
                    <div class=".container m-3">
                        <div class="d-flex flex-row mb-2 fs-5">

                            <!--Logica icons heart-->
                            @if(count($image->likes->where('user_id', Auth::user()->id)))
                            <!-- heart red -->
                            <img class="heart-icon" data-id="{{ $image->id }}" style="cursor: pointer;"
                                 src="{{ asset('img/heart-red.png') }}" width="30px" height="30px" alt="alt"/>
                            <strong id="n{{ $image->id }}" class="align-middle text-muted">
                                {{ count($image->likes) }}
                            </strong>
                            @else
                            <img class="heart-icon" id="heart-white" data-id="{{ $image->id }}" style="cursor: pointer;"
                                 src="{{ asset('img/heart.png') }}" width="30px" height="30px" alt="alt"/>
                            <strong id="n{{ $image->id }}"  class="align-middle text-muted ">
                                {{ count($image->likes) }}
                            </strong>
                            @endif

                        </div>
                        <p class="fw-bolder text-muted">
                            &#64;{{ $image->users->nick }}
                        </p>
                        <p>
                            {{ $image->description }}
                        </p>
                        <!--Formato fecha -->
                        <p class="text-muted">
                            {{ $image->created_at->locale(app()->getLocale())->diffForHumans() }}       
                        </p>

                        <!-- Comentario -->
                        <div class="clearfix">
                            <h2>
                                {{ __('messages.comments') }} <strong class="text-muted">({{ count($image->comments) }})</strong>
                            </h2>
                            <form action="{{ route('comment.save') }}" method="post">
                                @csrf

                                <input class="" type="hidden" name="image_id" value="{{ $image->id }}">

                                <div class="d-flex">

                                    <div class="w-100">
                                        <label for="content" class="form-label">{{ __('messages.write_something') }}...</label>
                                        <textarea class="form-control @error('content') is-invalid @enderror " id="content" name="content" rows="3"></textarea>
                                        @error('content')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <button type="submit" class="flex-shrink-1 align-self-end ms-2 btn btn-link p-0 m-0 border-0 bg-transparent">
                                        <img src="{{ asset('img/send.png') }}" width="30px" height="30px" alt="Enviar"/>
                                    </button>                                    
                                </div>

                            </form>
                        </div>

                        <!--Limpiar estilos-->
                        <div class="clearfix">

                            <!-- Mostrar comentarios -->
                            @foreach($image->comments as $comment)
                            <div class="mt-3 d-flex align-items-center">

                                <div class="w-100 d-flex flex-column">
                                    <div>
                                        <!--nick and comment-->
                                        <a class="pe-2 fw-bolder text-muted text-decoration-none" href="{{ route('user.profile', ['id'=>$comment->user_id]) }}">
                                            &#64;{{ $comment->users->nick }}                                  
                                        </a>
                                        <p class="mb-0 w-100">
                                            {{ $comment->content }}
                                        </p>
                                    </div>
                                    <!-- Fecha -->
                                    <p class="text-muted">
                                        {{ $comment->created_at->locale(app()->getLocale())->diffForHumans() }}
                                    </p>
                                </div>

                                <!--Mostrar btn de eliminar-->
                                @if(Auth::check() && ($comment->user_id == Auth::user()->id || $comment->images->user_id == Auth::user()->id))
                                <!--Eliminar-->
                                <a class="flex-shrink-1" href="{{ route('comment.delete', ['id'=>$comment->id]) }}">
                                    <img src="{{ asset('img/delete.png') }}" width="27px" height="27px" alt="delete"/>
                                </a>
                                @endif
                            </div>
                            <hr>
                            @endforeach

                        </div>

                    </div>
                </div>
            </div>

        </div>

    </div>
</div>
@endsection
