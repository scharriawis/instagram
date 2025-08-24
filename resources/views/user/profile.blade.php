@extends('layouts.app')

@section('title', 'profile')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!--header card-->
            <div class="d-flex align-items-center">

                <div class="flex-shrink-0">
                    <!--img perfil-->
                    @if($user->image !== null)
                    <img src="{{ route('user.image', ['image_path'=>$user->image]) }}" 
                         class="rounded-circle" width="200" height="200" alt="avatar">
                    @else
                    <img src="{{ asset('img/default.jpg') }}" 
                         class="rounded-circle" width="40" height="40" alt="avatar">
                    @endif                    
                </div>
                <!--info usuario-->
                <div class="flex-grow-1 ms-3">
                    <h1>{{'@' . $user->nick }}</h1>
                    <h2>{{ $user->name . ' ' . $user->surname }}</h2>
                    <p>{{ __('messages.joined') }} 
                        <strong>{{ $user->created_at->locale(app()->getLocale())->diffForHumans() }}</strong>
                    </p>
                </div>

            </div>

            <!--# de publicaciones y demas info-->
            <div class="m-3 d-flex justify-content-start">
                <div class="">
                    <p class="d-flex flex-column">
                        <strong class="text-center">{{ count($user->images) }}</strong>
                        {{ __('messages.publications') }}
                    </p>
                </div>
            </div>

            <!--Card imgs-->
            <div class="card">
                <div class="card-body">
                    <div class="row g-3">
                        @foreach($images as $image)
                        <div class="col-6 col-sm-6 col-md-4">
                            <div class="ratio ratio-1x1 position-relative">
                                    <img 
                                        class="img-fluid img-thumbnail object-fit-cover" 
                                        src="{{ route('image.images', ['images_path'=>$image->image_path]) }}" alt="imagenes publicadas"
                                    />
                                    <!-- Overlay -->
                                <a href="{{ route('image.detail', ['id'=>$image->id]) }}" >
                                    <div class="overlay d-flex flex-column justify-content-center align-items-center 
                                         text-white position-absolute top-0 start-0 w-100 h-100 bg-dark bg-opacity-50 
                                         opacity-0 hover-opacity-100 rounded">
                                        <p class="mb-1"><i class="bi bi-heart-fill"></i> {{ $image->likes->count() }} Likes</p>
                                        <p class="mb-1"><i class="bi bi-chat-fill"></i></i> {{ $image->comments->count() }} Comments</p>
                                        <p class="small">{{ Str::limit($image->description, 40) }}</p>
                                    </div>                                 
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!--Paginacion-->
            <div class="d-flex justify-content-center mt-4">
                {{ $images->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection('content')
