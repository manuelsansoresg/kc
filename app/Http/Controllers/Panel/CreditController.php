<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Credit;
use App\Strategies\Values\ActionValues;
use Illuminate\Http\Request;

class CreditController extends Controller
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
        //
    }

    public function storeTag(Request $request)
    {
        $actionStrategy   = ActionValues::STRATEGY['credit'];
        $tag              = (new $actionStrategy)->saveTag($request);
    }

    public function getTag($credit_id)
    {
        $actionStrategy   = ActionValues::STRATEGY['credit'];
        $get_tag              = (new $actionStrategy)->getTags($credit_id);
        return response()->json($get_tag);
    }

    public function deleteTag($tag_id)
    {
        $actionStrategy   = ActionValues::STRATEGY['credit'];
        $tag              = (new $actionStrategy)->deleteTag($tag_id);
        return response()->json($tag);
    }

    public function getNote($credit_id) 
    {
        $actionStrategy   = ActionValues::STRATEGY['credit'];
        $get_note         = (new $actionStrategy)->getNotes($credit_id);
        return response()->json($get_note);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $credit = Credit::find($id);
        return view('panel.credit.profile', compact('credit'));
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
