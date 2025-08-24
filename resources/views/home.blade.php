@extends('layouts.app')

@section('title', 'home')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            @include('includes.message')
            @foreach($images as $image)

            <!--Navegacion-->
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
                        <!--Nombre y nick-->
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
                                <li><a class="dropdown-item" href="{{ route('image.edit', ['id'=> $image->id]) }}"><i class="bi bi-pencil me-2"></i> Editar</a></li>
                                <li><a class="dropdown-item" href="{{ route('image.delete', ['id'=>$image->id]) }}"><i class="bi bi-trash me-2"></i> Eliminar</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-danger" href="#"><i class="bi bi-flag me-2"></i> Reportar</a></li>
                            </ul>
                    </div>
                    @endif
                </div>

                @include('includes.publicacion', ['image'=>$image])

            </div>
            @endforeach
        </div>

        <!--Paginacion-->
        <div class="clearfix w-50 .flex-column p-0">
            {{ $images->links('pagination::bootstrap-5') }}
        </div>
        <!--
            {{ $images->links('pagination::simple-bootstrap-4') }}
            {{ $images->links('pagination::bootstrap-5') }}
            {{ $images->links('pagination::simple-bootstrap-5') }}
            {{ $images->links('pagination::default') }}
            {{ $images->links('pagination::simple-default') }}
            {{ $images->links('pagination::semantic-ui') }}
            {{ $images->links('pagination::tailwind') }}
            {{ $images->links('pagination::simple-tailwind') }}
        -->
    </div>
</div>
@endsection
