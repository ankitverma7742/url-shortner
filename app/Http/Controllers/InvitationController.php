<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invitation;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class InvitationController extends Controller
{

    private function pending(string $token): Invitation
    {
        return Invitation::where('token', $token)
            ->whereNull('accepted_at')
            ->firstOrFail();
    }


    public function show(string $token)
    {
        $invitation = $this->pending($token);

        return view('auth.accept', compact('invitation'));
    }

    public function accept(Request $request, string $token)
    {
        $invitation = $this->pending($token);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'password' => ['required', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $invitation->email,
            'password' => Hash::make($data['password']),
            'company_id' => $invitation->company_id,
            'role' => $invitation->role,
        ]);

        $invitation->update([
            'accepted_at' => now(),
        ]);

        Auth::login($user);

        return redirect()->route('dashboard');
    }
}