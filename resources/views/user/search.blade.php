@extends('layouts.app')

@section('title', 'search')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <!--form buscador-->
            <form id="buscar" class="col-md-4" method="get" action="">
                <div class="input-group mb-3">
                    <button class="btn btn-secondary" id="buscar" type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                    <input id="inputBuscar" name="buscar" type="text" class="form-control" placeholder="" aria-label="Example text with button addon" aria-describedby="button-addon1">
                </div>              
            </form>             

            <div class="resultados">
                <!--Mostrar usuarios-->
                @include('user.search_users')                
            </div>
            
        </div>
    </div>
</div>
@endsection('content')
