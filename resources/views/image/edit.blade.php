@extends('layouts.app')

@section('title', 'edit')
@section('content')
<div class="row justify-content-center mt-5">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <p class="m-0">
                    {{ __('messages.update_image') }}
                </p>
            </div>

            <div class="card-body">
                <form method="POST" action="{{ route('image.update') }}" enctype="multipart/form-data">
                    @csrf

                    <!--Img-->
                    <div class="row mb-3">
                        <label for="image" class="col-md-4 col-form-label text-md-end">{{ __('messages.image') }}</label>
                        <div class="col-md-2">
                            <div class="ratio ratio-1x1 position-relative">
                                <img class="img-thumbnail img-fluid object-fit-cover" src="{{ route('image.images', ['images_path'=>$image->image_path]) }}" >
                            </div>
                        </div>
                    </div>

                    <!--Input img-->
                    <div class="row mb-3">
                        <label for="image" class="col-md-4 col-form-label text-md-end">{{ __('messages.image') }}</label>
                        <div class="col-md-6">
                            <input id="image" type="file" class="form-control @error('image') 
                                   is-invalid @enderror" name="image">
                            @error('image')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <!--Description-->
                    <div class="row mb-3">
                        <label for="description" class="col-md-4 col-form-label text-md-end">{{ __('messages.description') }}</label>
                        <div class="col-md-6">
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="5" cols="10">{{ $image->description }}</textarea>
                            @error('description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <!--input oculto parametro image_id-->
                    <input class=".visually-hidden d-none" name="image_id" type="hidden" value="{{ $image->id }}">

                    <div class="row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                {{ __('messages.update_image') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>      
    </div>
</div>

@endsection('content')