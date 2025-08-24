<!-- Mostrar imagen publicacion -->
<div class="card-body p-0">
    <div class=".container">
        <a href="{{ route('image.detail', ['id'=>$image->id]) }}">
            <div class="ratio ratio-4x3 position-relative">
                <img src="{{ route('image.images', ['images_path'=>$image->image_path]) }}" 
                     class="img-fluid object-fit-cover" alt="imagen publicacion">                                            
            </div>
        </a>
    </div>

    <!-- icons -->
    <div class=".container m-3">
        <div class="d-flex align-items-center mb-2 fs-5">
            <!--Logica icons heart-->
            @if(count($image->likes->where('user_id', Auth::user()->id)))
            <!-- heart red -->
            <img class="heart-icon me-1" data-id="{{ $image->id }}" style="cursor: pointer;"
                 src="{{ asset('img/heart-red.png') }}" width="30px" height="30px" alt="alt"/>
            @else
            <!-- heart white -->
            <img class="heart-icon me-1" id="heart-white" data-id="{{ $image->id }}" style="cursor: pointer;"
                 src="{{ asset('img/heart.png') }}" width="30px" height="30px" alt="alt"/>
            @endif
            <strong id="n{{ $image->id }}"  class="align-middle text-muted me-2">
                {{ count($image->likes) }}
            </strong>

            <!-- icon comment -->
            <a class="text-decoration-none me-1" href="{{ route('image.detail', ['id'=>$image->id]) }}">
                <img src="{{asset('img/comment.png')}}" width="35px" height="35px" alt="alt"/>
            </a>
            <!--# comment-->
            <strong class="align-middle text-muted">
                {{ count($image->comments) }}
            </strong>

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
    </div>
</div>
