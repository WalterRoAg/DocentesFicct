<?php
namespace App\Http\Controllers\Docente;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index() { return view('docente.dashboard'); }
}
