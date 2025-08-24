<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use app\Models\Comment;

class CommentController extends Controller {

    //Proteger vista
    public function __construct() {
        $this->middleware('auth');
    }

    public function save(Request $request) {

        //Recoger las variables
        $id = \Auth::user()->id;
        $image_id = $request->input('image_id');
        $content = $request->input('content');

        //Validar datos del form
        $validate = $this->validate($request, [
            'image_id' => 'required', 'int',
            'content' => 'required', 'string',
        ]);

        //Crear el nuevo objeto
        $comment = new Comment();

        //Asignar valores al objeto
        $comment->user_id = $id;
        $comment->image_id = $image_id;
        $comment->content = $content;

        //Guardar en la db
        $comment->save();

        //Redireccionar
        return redirect()->route('image.detail', ['id' => $image_id])
                        ->with(['message' => 'El comentario fue posteado correctamente!!!']);
    }

    public function delete($id) {

        //Buscar el objeto Comment
        $comment = Comment::find($id);

        //Objeto usuario
        $user = \Auth::user();

        //Comprobar si el usuario es el dueño de la imagen o es el dueño del comentario
        if ($user && ($user->id == $comment->images->user_id || $user->id == $comment->user_id)) {
            //Eliminar comentario
            $comment->delete();

            //Redireccionar
            return redirect()->route('image.detail', ['id' => $comment->images->id])
                            ->with(['message' => 'El comentario fue elimando correctamente!!!']);
        }

        //Si sale mal
        return redirect()->route('image.detail', ['id' => $id])
                        ->with(['message' => 'Upss algo salio mal']);
    }
}
