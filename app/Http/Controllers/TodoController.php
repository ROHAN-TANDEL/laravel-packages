<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Todo;
use Log;

class TodoController extends Controller
{
    public function __invoke()
    {
        return Todo::all();
    }
}
