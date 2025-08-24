<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use app\Models\Image;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(){
        //Consultar db, ordenar y obtener las fotos
        $images = Image::orderBy('updated_at', 'desc')->paginate('5');
        
        //Retornar a la vista con el parametro
        return view('home', [
            'images' => $images
        ]);
    }
}
