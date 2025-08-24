<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Models\User;
use app\Models\Image;

class UserController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    public function config() {
        return view('user/config');
    }

    public function update(Request $request) {

        //identificar al usuario
        $user = \Auth::user();
        $id = $user->id;

        //Verifica los datos del pass
        if ($request->input('current_password') !== null) {
            $validate = $this->validate($request, [
                'current_password' => ['required'],
                'password' => ['required', 'string', 'min:8', 'confirmed']
            ]);

            // Verifica que la contraseña actual sea correcta
            if (!Hash::check($request->current_password, $user->password)) {
                return redirect()->route('user.config')
                                ->with(['error' => 'La contraseña actual no es correcta!!!']);
            }

            //Actualizar y encryptar pass 
            $user->update([
                'password' => bcrypt($request->password),
            ]);

            //reedireccionar
            return redirect()->route('user.config')
                            ->with(['message' => 'La contraseña fue actualizada correctamente!!!']);
            //return back()->with(['message'=> 'La contraseña fue actualizada correctamente!!!']);
        }

        //Validar datos
        $validate = $this->validate($request, [
            'name' => 'required', 'string', 'max:255',
            'surname' => 'required', 'string', 'max:255',
            'nick' => 'required', 'string', 'max:255', 'unique:users,nick,' . $id,
            'email' => 'required', 'string', 'email', 'max:255', 'unique:users,email,' . $id,
        ]);

        //Subir imagen
        $image = $request->file('image');
        if ($image) {
            //Poner nombre unico
            $image_path = time() . $image->getClientOriginalName();

            //Guardar en la carpeta storage (/storage/app/users)
            Storage::disk('users')->put($image_path, File::get($image));

            //Seteo el nombre de la imagen al objeto
            $user->image = $image_path;
        }

        //Asignar a todos los valores
        $user->fill($request->all());

        /* Recojer datos
          $name = $request->input('name');
          $surname = $request->input('surname');
          $nick = $request->input('nick');
          $email = $request->input('email');

          //Asignar valores uno a uno
          $user->name = $name;
          $user->surname = $surname;
          $user->nick = $nick;
          $user->email = $email;
         * 
         */

        //Ejecutar consulta y cambios en la db
        $user->update();

        return redirect()->route('user.config')
                        ->with(['message' => 'Los datos fueron actualizados correctamente!!!']);
        /*
          return back()->with(['message'=> 'Los datos fueron actualizados correctamente!!!']);
         */
    }

    public function getImage($image_name) {
        //apuntar a la carpeta de las imagenes y esperar el parametro con el nombre de la imagen
        $image = Storage::disk('users')->get($image_name);

        //Devolver una respuesta
        return new Response($image, 200);
    }

    //Vista perfil + param 
    public function profile($id) {

        //Buscar usuario
        $user = User::find($id);

        //Consultar db, ordenar y obtener las fotos
        $images = Image::Where('user_id', $id)->orderBy('updated_at', 'desc')->paginate('6');

        return view('user/profile', [
            'user' => $user,
            'images' => $images
        ]);
    }

    public function search($search = null) {
        if (!empty($search)) {
            $users = User::where('name', 'LIKE', "%{$search}%")
                    ->orWhere('surname', 'LIKE', "%{$search}%")
                    ->orWhere('nick', 'LIKE', "%{$search}%")
                    ->paginate(5);
        } else {
            $users = User::orderBy('created_at', 'desc')->paginate(5);
        }

        // 🚀 si la petición es AJAX → devolver solo el listado
        if (request()->ajax()) {
            return view('user.search_users', compact('users'))->render();
        }

        // 🚀 si es normal → devolver la vista completa
        return view('user.search', compact('users'));
    }
}
