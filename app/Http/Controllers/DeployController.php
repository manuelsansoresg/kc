<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DeployController extends Controller
{
    public function index()
    {
        exec('deploy');
    }
}
