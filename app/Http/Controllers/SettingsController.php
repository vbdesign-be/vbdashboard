<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Justijndepover\Teamleader\Teamleader;

class SettingsController extends Controller
{
    public function index(Teamleader $teamleader)
    {
        // this view should show a 'connect to Teamleader' button
        // or when logged in, show a message: 'You are logged in'

        return view('settings.index', [
            'teamleader' => $teamleader,
        ]);
    }

    public function redirectForAuthorization(Teamleader $teamleader)
    {
        return redirect($teamleader->redirectForAuthorizationUrl());
    }

    public function accept(Request $request, Teamleader $teamleader)
    {
        if ($request->error) {
            return redirect()->route('settings.index')->with('error', __('The user refused to connect'));
        }

        if ($request->state != $teamleader->getState()) {
            return redirect()->route('settings.index')->with('error', __('The state parameter doesn\'t match.'));
        }

        $teamleader->setAuthorizationCode($request->code);
        $teamleader->connect();

        Storage::disk('local')->put('teamleader.json', json_encode([
            'accessToken' => $teamleader->getAccessToken(),
            'refreshToken' => $teamleader->getRefreshToken(),
            'expiresAt' => $teamleader->getTokenExpiresAt(),
        ]));

        return redirect()->route('settings.index')->with('message', __('You are connected with Teamleader'));
    }
}