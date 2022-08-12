<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Action;
use App\Models\File;
use Illuminate\Http\Request;

class ActionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $action = Action::saveEdit($request);
        if ($action != null) {
            $request->session()->put('id_rel_action', $action->id);
        }
        return response()->json($action);
    }

    /**
     * guarda el archivo dependiendo del modelo y el tipo de relacion
     *
     * @param int $model   model to indicate relationship
     * @param [type] $id_rel id_rel id to relationship
     * @param Request $request
     * @return void
     */
    public function storeFile($model, Request $request)
    {
        $id_rel = $request->session()->get('id_rel_action');
        File::upload($model, $id_rel, $request);
    }

    public function showFiles($model, Request $request)
    {
        $id_rel = $request->session()->get('id_rel_action');
        $files = File::getAll($model, $id_rel);
        return response()->json($files);
    }
    /**
     * delete file register action
     *
     * @param [type] $id
     * @return void
     */
    public function deleteFile($id)
    {
        $file = File::find($id);
        $file->delete();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
