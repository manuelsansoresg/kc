<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DeployController extends Controller
{
    public function index()
    {

        $output = shell_exec("git pull 2>&1");
        echo '<pre>';
        echo $output;
    }
}
