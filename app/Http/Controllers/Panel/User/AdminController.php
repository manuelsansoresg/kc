<?php

namespace App\Http\Controllers\Panel\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('panel.user.list', ['title' => 'Administrador', 'route' => 'administrador']);
    }

    public function searchView(Request $request)
    {
        return view('viewsearchuser');
    }
    
    public function search(Request $request)
    {
        $users   = User::searchUser($request);
        return response()->json(['data' => $users]);
    }

    public function list()
    {
        $users = User::listDatatable();
        
        return response()->json(['data' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('panel.user.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        if ($request->user_id == null) {
            $this->validate($request, [
                'email' => 'unique:users,email'
            ]);
        } else {
            $this->validate($request, [
                'email' => 'required|email|unique:users,email,' .$request->user_id . ',id',
            ]);
        }
        
        User::saveEdit($request);
        return response()->json(200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        return response()->json($user);
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

    public function updatePassword(Request $request)
    {
        User::changePassword($request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return response()->json(200);
    }

    public function tycAccept(Request $request)
    {
        $tyc = $request->tyc;
        $user = User::find(Auth::user()->id);
        $user->tyc_accept = $tyc;
        $user->update();
    }
}
