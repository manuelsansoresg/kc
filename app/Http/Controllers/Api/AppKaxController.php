<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HistoryLog;
use App\Strategies\Values\TemplateValues;
use Illuminate\Http\Request;

class AppKaxController extends Controller
{
    //* get current step
    public function steps(HistoryLog $history, $model)
    {
        $templateStrategy   = TemplateValues::STRATEGY[$model];
        $percent            = (new $templateStrategy)->getPercent($history, true);
        $getlblStatusApi    = (new $templateStrategy)->getlblStatusApi($history, true);
        
        $data_result = array('current' => $percent, 'lbl' => $getlblStatusApi['lbl'],
                            'total_percent' => $getlblStatusApi['total_percent']);
        
        return response()->json($data_result);
    }
}
