<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Invitation;
use App\Models\ShortUrl;
use App\Models\User;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        if ($user->isSuperAdmin()) {

            $companies = Company::withCount(['users', 'shortUrls'])
                ->withSum('shortUrls', 'hits')
                ->latest()
                ->paginate(10, ['*'], 'clients_page');

            $urls = ShortUrl::with('company')
                ->latest()
                ->paginate(10, ['*'], 'urls_page');

            $invitations = Invitation::whereNull('accepted_at')
                ->latest()
                ->get();

            return view('dashboard.superadmin', compact('companies', 'urls', 'invitations'));
        }

        if ($user->isAdmin()) {

            $urls = ShortUrl::with('user')
                ->where('company_id', $user->company_id)
                ->latest()
                ->paginate(10, ['*'], 'urls_page');

            $members = User::where('company_id', $user->company_id)
                ->withCount('shortUrls')
                ->withSum('shortUrls', 'hits')
                ->paginate(10, ['*'], 'members_page');

            $invitations = Invitation::where('company_id', $user->company_id)
                ->whereNull('accepted_at')
                ->latest()
                ->get();

            return view('dashboard.admin', compact('urls', 'members', 'invitations'));
        }

        $urls = ShortUrl::where('user_id', $user->id)
            ->latest()
            ->paginate(10);

        return view('dashboard.member', compact('urls'));
    }
}