<?php

namespace App\Http\Controllers;

use App\Services\ModuleManager;
use Illuminate\View\View;

class MarketingController extends Controller
{
    public function home(ModuleManager $modules): View
    {
        return view('marketing.home', [
            'modules' => $modules->all(),
            'brand' => config('crm.brand'),
            'accent' => config('crm.accent'),
        ]);
    }

    public function features(): View
    {
        return view('marketing.features', ['brand' => config('crm.brand'), 'accent' => config('crm.accent')]);
    }

    public function modules(ModuleManager $modules): View
    {
        return view('marketing.modules', [
            'modules' => $modules->all(),
            'brand' => config('crm.brand'),
            'accent' => config('crm.accent'),
        ]);
    }

    public function pricing(): View
    {
        return view('marketing.pricing', ['brand' => config('crm.brand'), 'accent' => config('crm.accent')]);
    }

    public function security(): View
    {
        return view('marketing.security', ['brand' => config('crm.brand'), 'accent' => config('crm.accent')]);
    }

    public function demo(): View
    {
        return view('marketing.demo', [
            'brand' => config('crm.brand'),
            'accent' => config('crm.accent'),
            'email' => config('crm.demo.email'),
            'password' => config('crm.demo.password'),
        ]);
    }
}