<?php

namespace App\Http\Controllers;

use App\Models\Deal;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PortalController extends Controller
{
    public function index(Request $request): View
    {
        $deals = Deal::query()->with(['company', 'stage'])->where('status', 'open')->latest()->limit(20)->get();

        return view('portal.index', [
            'deals' => $deals,
            'brand' => config('crm.brand'),
            'user' => $request->user(),
        ]);
    }
}