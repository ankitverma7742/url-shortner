<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invitation;
use Illuminate\Support\Str;

class TeamController extends Controller
{

    public function create()
    {
        return view('team.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'role' => ['required', 'in:admin,member'],
        ]);

        $invitation = Invitation::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'role' => $data['role'],
            'company_id' => $request->user()->company_id,
            'invited_by' => $request->user()->id,
            'token' => Str::random(40),
        ]);

        return redirect()->route('dashboard')
            ->with('success', 'Invitation sent')
            ->with('invite_link', route('invitation.show', $invitation->token));
    }
}