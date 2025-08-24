@foreach($users as $user)
<!-- Aquí se insertarán los resultados -->
<div id="resultados">
    <!--header card-->
    <div class="d-flex align-items-center my-5">

        <div class="flex-shrink-0">
            <!--img perfil-->
            @if($user->image !== null)
            <img src="{{ route('user.image', ['image_path'=>$user->image]) }}" 
                 class="rounded-circle" width="200" height="200" alt="avatar">
            @else
            <img src="{{ asset('img/default.jpg') }}" 
                 class="rounded-circle" width="200" height="200" alt="avatar">
            @endif                    
        </div>
        <!--info usuario-->
        <div class="flex-grow-1 ms-3">
            <h1>{{'@' . $user->nick }}</h1>
            <h2>{{ $user->name . ' ' . $user->surname }}</h2>
            <p>Se unio 
                <strong>{{ $user->created_at->locale('es_ES')->diffForHumans(null, false, false, 1)  }}</strong>
            </p>
        </div>

    </div>

</div>
<hr>
@endforeach

<!--Paginacion-->
<div class="d-flex justify-content-center mt-4">
    {{ $users->links('pagination::bootstrap-5') }}
</div>