<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Invitation;
use Illuminate\Support\Str;

class ClientController extends Controller
{
    public function create()
    {
        return view('clients.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
        ]);

        $company = Company::create([
            'name' => $data['name'],
            'email' => $data['email'],
        ]);

        $invitation = Invitation::create([
            'email' => $data['email'],
            'role' => 'admin',
            'company_id' => $company->id,
            'invited_by' => $request->user()->id,
            'token' => Str::random(40),
        ]);

        return redirect()->route('dashboard')
            ->with('success', 'Client invited')
            ->with('invite_link', route('invitation.show', $invitation->token));
    }
}