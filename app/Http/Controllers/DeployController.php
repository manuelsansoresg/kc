<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class DeployController extends Controller
{
    //deploy
    public function index()
    {
        $process = new Process(['deploy']);
        $process->run();
    }
}
