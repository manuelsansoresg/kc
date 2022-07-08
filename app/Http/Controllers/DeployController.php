<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use robertogallea\LaravelPython\Services\LaravelPython;

class DeployController extends Controller
{
    public function index()
    {
        $result = \Python::run('/deploy.py');

    }
}
