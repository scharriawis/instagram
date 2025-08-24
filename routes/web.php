<?php

//use Illuminate\Support\Facades\Route;

//use App\Models\Image;

Route::get('/', function () {
    /*
    $images = Image::all();
    
    foreach ($images as $image){
        echo "<h1>Publicacion</h1>";
        
        echo $image->image_path . "<br/>";
        echo $image->description . "<br/>";
        echo $image->users->name . ' ' . $image->users->surname . '<br/>';
        //var_dump($image->users);    //$image->users es el metodo que esta en el archivo \Models\User.php
        echo '<br/>';
        
        echo '<strong>' . 'Comentarios : ' . count($image->comments) . '</strong>'  . '<br/>'.'<br/>';
        if (count($image->comments) >0) {        
            foreach ($image->comments as $comment) {
                echo $comment->users->name . ' ' . $comment->users->surname . ' ' . $comment->content . '<br/>';
                echo $comment->created_at . '<br/>' . '<br/>';
            }
        }
        
        echo "<br/>";
        
        echo "Likes: " . count($image->likes);

        echo "<hr>";
        
    }
    
    die();
    */
    return view('welcome');
});
 

Auth::routes();

//Home
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//User
Route::get('/user/config', [App\Http\Controllers\UserController::class, 'config'])->name('user.config');
Route::get('/user/profile/{id}', [App\Http\Controllers\UserController::class, 'profile'])->name('user.profile');
Route::post('/user/update', [App\Http\Controllers\UserController::class, 'update'])->name('user.update');
Route::get('/user/image/{image_path}', [App\Http\Controllers\UserController::class, 'getImage'])->name('user.image');
Route::get('/user/search/{buscar?}', [App\Http\Controllers\UserController::class, 'search'])->name('user.search');

//img
Route::get('/image/images/{images_path}', [App\Http\Controllers\ImageController::class, 'getImages'])->name('image.images');
Route::get('/image/create', [App\Http\Controllers\ImageController::class, 'create'])->name('image.create');
Route::get('/image/detail/{id}', [App\Http\Controllers\ImageController::class, 'detail'])->name('image.detail');
Route::post('/image/save', [App\Http\Controllers\ImageController::class, 'save'])->name('image.save');
Route::get('/image/delete/{id}', [App\Http\Controllers\ImageController::class, 'delete'])->name('image.delete');
Route::get('/image/edit/{id}', [App\Http\Controllers\ImageController::class, 'edit'])->name('image.edit');
Route::post('/image/update', [App\Http\Controllers\ImageController::class, 'update'])->name('image.update');

//comment
Route::post('/comment/save', [App\Http\Controllers\CommentController::class, 'save'])->name('comment.save');
Route::get('/comment/delete/{id}', [App\Http\Controllers\CommentController::class, 'delete'])->name('comment.delete');

//like
Route::get('/like/save/{imagen_id}', [App\Http\Controllers\LikeController::class, 'like'])->name('like.save');
Route::get('/like/delete/{imagen_id}', [App\Http\Controllers\LikeController::class, 'dislike'])->name('like.delete');

//Default
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
