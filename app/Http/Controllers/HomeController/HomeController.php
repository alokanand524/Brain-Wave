<?php

namespace App\Http\Controllers\HomeController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    //
    public function index()
    {
        return view('index');
    }

    public function features()
    {
        return view('features');
    }

    public function studyRoom()
    {
        return view('studyRoom');
    }
    public function viewProfile()
    {
        return view('viewProfile');
    }
}
