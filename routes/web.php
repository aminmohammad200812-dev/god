<?php
use Illuminate\Support\Facades\Route;
Route::get('/', function ()  {
    return view ('index');
});
Route::get('/phone', function () {
  return view('phone');
})->name('phone');

Route::get('/about', function () {
  return view('about');
})->name('about');


Route::get('/confirmpassword', function () {
  return view('confirmpassword');
})->name('confirmpassword');

Route::get('/NewTextDocument', function () {
  return view('New Text Document');
})->name('NewTextDocument');

// Route::get('/confirmpassword', function () {
//   return view('confirmpassword');
// })->name('confirmpassword');

Route::get('/confirmpassword2', function () {
  return view('confirmpassword2');
})->name('confirmpassword2');

Route::get('/password', function () {
  return view('password');
})->name('password');

Route::get('/index', function () {
  return view('index');
})->name('index');

Route::get('/dashboard', function () {
  return view('dashboard');
})->name('dashboard');

Route::get('/Complaints', function () {
  return view('Complaints');
})->name('Complaints');

Route::get('/Contact Us', function () {
    return view('Contact Us');
  })->name('Contact Us');
?>