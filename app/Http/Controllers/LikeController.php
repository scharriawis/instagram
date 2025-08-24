<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like;

class LikeController extends Controller {

    //Segurida de autenticacion
    public function __construct() {
        $this->middleware('auth');
    }

    public function like(int $imagen_id) {
        //Identificar al usuario
        $user = \Auth::user();

        //Consultar cuantas concidencias hay
        $query = Like::where('user_id', $user->id)->
                where('image_id', $imagen_id)->
                count();

        //Comprobar que el like no se duplique
        if ($query >= 1) {
            //Enviar respuesta tipo json
            return response()->json([
                        'error' => 'Ya diste like'
            ]);
        }

        //Crear el obj like y asignar valores
        $like = new Like();
        $like->user_id = $user->id;
        $like->image_id = $imagen_id;

        //Registrar el like en la db
        $like->save();

        //Contar los likes de una publicacion o imagen
        $count = Like::where('image_id', $imagen_id)->count();

        return response()->json([
                    'likesCount' => $count
        ]);
    }

    public function dislike(int $imagen_id) {
        //Identificar al usuario
        $user = \Auth::user();

        //Consultar a la db si se encuentras las siguientes coincidencias y de volver el primer valor
        $query = Like::where('user_id', $user->id)->
                where('image_id', $imagen_id)->
                first();

        //Comprobar que no hay dislike
        if (!$query) {
            return response()->json([
                        'error' => 'Ya diste dislike anteriormente!!!'
            ]);
        }

        //Eliminar like
        $query->delete();

        //Contar los likes de una publicacion o imagen
        $count = Like::where('image_id', $imagen_id)->count();

        //Enviar respuesta tipo json
        return response()->json([
                    'likesCount' => $count
        ]);
    }
}
