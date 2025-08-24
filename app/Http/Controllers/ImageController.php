<?php

namespace App\Http\Controllers;

use app\Models\Image;
use app\Models\Comment;
use App\Models\Like;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class ImageController extends Controller {

    //Proteger vista
    public function __construct() {
        $this->middleware('auth');
    }

    public function create() {
        return view('image/create');
    }

    public function save(Request $request) {

        //identificar al usuario
        $user = \Auth::user();
        $id = $user->id;

        //Crear variable para el objeto image
        $obj_image = new Image();

        //Validar datos del form
        $validate = $this->validate($request, [
            'image' => 'required', 'image',
            'description' => 'required', 'string',
        ]);

        //Recoger los datos del form
        $image = $request->file('image');
        $description = $request->input('description');

        //Subir imagen
        if ($image) {
            //Poner nombre unico
            $image_path = time() . $image->getClientOriginalName();

            //Guardar en la carpeta storage (/storage/app/users)
            Storage::disk('images')->put($image_path, File::get($image));

            //Seteo el nombre de la imagen al objeto
            $obj_image->image_path = $image_path;
        }

        //asignar los demas valores al objeto image
        $obj_image->user_id = $id;
        $obj_image->description = $description;

        //Guardar en la db
        $obj_image->save();

        //Redireccionar
        return redirect()->route('home')
                        ->with(['message' => 'La imagen fue guardada correctamente!!!']);
    }

    //Obetener imagenes
    public function getImages($images_name) {
        //apuntar a la carpeta de las imagenes y pasamos el nombre de la imagen
        $images_path = Storage::disk('images')->get($images_name);

        //Devolver una respuesta
        return new Response($images_path, 200);
    }

    public function detail($id) {
        $image = Image::find($id);

        return view('image/detail', [
            'image' => $image
        ]);
    }

    public function delete($id) {
        //Datos del user auth
        $user = \Auth::user();
        //Recibir el id de la imagen
        $image = Image::find($id);
        //Consultar todos los comments de la img
        $comments = Comment::where('image_id', $id)->get();
        //Consultar todos los likes de la img
        $likes = Like::where('image_id', $id)->get();

        //Comprobar que este auth que sea el dueño de la img 
        if ($user && $user->id == $image->user_id) {
            //Eliminar todos los comments
            if ($comments && $comments->count() >= 1) {
                foreach ($comments as $comment) {
                    $comment->delete();
                }
            }
            //Eliminar todos los likes
            if ($likes && $likes->count() >= 1) {
                foreach ($likes as $like) {
                    $like->delete();
                }
            }
            //Eliminar la img
            if ($image && $image->image_path) {
                Storage::disk('images')->delete($image->image_path);
            }
            //Eliminar la img de la db
            $image->delete();

            //Redireccionar
            return redirect()->route('home')
                            ->with(['message' => 'La imagen fue eliminada correctamente!!!']);
        } else {
            //Redireccionar
            return redirect()->route('home')
                            ->with(['error' => 'La imagen no pudo ser eliminada...']);
        }
    }

    public function edit(int $id) {
        //Datos del user auth
        $user = \Auth::user();
        //imagen
        $image = Image::find($id);

        if ($user && $image && $user->id == $image->users->id) {
            //var_dump($image->users->id, $user->id, $id);
            //die();
            //Redireccionar
            return view('image.edit', [
                'image' => $image
            ]);
        }
        //Redireccionar
        return redirect()->route('home');
    }

    public function update(Request $request) {
        //Recoger los datos
        $image_new = $request->image;
        $description = $request->description;
        $image_id = $request->image_id;

        //Validar datos del form
        $validate = $this->validate($request, [
            'image' => 'image',
            'description' => 'string',
        ]);

        //Buscar la imagen
        $image = Image::find($image_id);
        //Actualizar los datos
        $image->description = $description;

        //Comprobar si hay nueva img y subir el fichero
        if ($image_new) {
            //Eliminar la img anterior
            Storage::disk('images')->delete($image->image_path);
            
            //Poner nombre unico
            $image_path = time() . $image_new->getClientOriginalName();

            //Guardar en la carpeta storage (/storage/app/users)
            Storage::disk('images')->put($image_path, File::get($image_new));

            //Seteo el nombre de la imagen al objeto
            $image->image_path = $image_path;
        }
        
        //Actualizar la db
        $image->update();
        
        //Reedireccionar
        return redirect()->route('image.detail', ['id'=>$image->id])
                            ->with(['message' => 'La imagen fue actualizada correctamente!!!']);
    }
}
