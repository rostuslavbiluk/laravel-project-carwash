<?php

namespace App\Http\Controllers;

use App\Classes\Entity\User\UserInfo;
use App\Http\Requests;
use App\Support;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Model\Support as SupportManager;


class SupportController extends Controller
{
    public function index(Request $request)
    {
        $title = $request->input('title') ?? '';
        $user = (new UserInfo())->getInfoFormatted();
        return view('template.support.index', compact('user', 'title'));
    }

    public function create(Request $request)
    {
        $request = $request->all();
        $request['user_id'] = (new UserInfo())->getId();
        $validator = Validator::make($request, [
            'title' => ['required', 'string', 'min:3', 'max:255'],
            'description' => ['required', 'string', 'min:3', 'max:255'],
            'user_id' => ['required', 'numeric']
        ]);
        if ($validator->fails()) {
            return redirect()->route('support.index')->withErrors($validator);
        }
        SupportManager::create($request);
        return view('template.support.successful');
    }
}
