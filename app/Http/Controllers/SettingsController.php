<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        return view('template.settings.index');
    }

    public function show(Request $request)
    {
        $code = $request->route('code');
        return view('template.settings.index');
    }
}
