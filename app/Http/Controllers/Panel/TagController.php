<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('panel.tag.list');
    }

    public function list()
    {
        $tags = Tag::listDatatable();

        return response()->json(['data' => $tags]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tag_id   = null;
        return view('panel.tag.form', compact('tag_id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->tag_id == null) {
            $request->validate(
                [
                'data.name' => 'required|unique:tags,name',
                ],
                [
                    'data.name.unique' => 'El valor ya se encuentra registrado'
                ]
            );
        } else {
            $request->validate(
                [
                    'data.name' => 'required|unique:tags,name,' . $request->tag_id . ',id',
                ],
                [
                    'data.name.unique' => 'El valor ya se encuentra registrado'
                ]
            );
        }
        $tag = Tag::saveEdit($request);
        return response()->json($tag);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tag = Tag::find($id);
        return response()->json($tag);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tag    = Tag::find($id);
        $tag_id = $tag->id;
        return view('panel.tag.form', compact('tag_id'));
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
        $tag = Tag::find($id);
        $tag->delete();
    }
}
