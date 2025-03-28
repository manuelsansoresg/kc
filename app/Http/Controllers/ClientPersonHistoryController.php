<?php

namespace App\Http\Controllers;

use App\Models\ClientPerson;
use App\Models\ClientPersonHistory;
use Illuminate\Http\Request;

class ClientPersonHistoryController extends Controller
{
    public function show($id)
    {
        $client = ClientPerson::findOrFail($id);
        $history = ClientPersonHistory::where('client_person_id', $id)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('client.history', compact('client', 'history'));
    }
} 