<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\VerificationState;
use App\Models\Vote;
use App\Models\VoteHistory;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function index()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->post(), [
            'src_token' => ['required', 'max:30']]);

        if ($validator->fails()) Redirect::back()->withErrors(['error' => 'The token is required']);

        $token = trim($request->post('src_token'));
        $user = User::where(['src_api_token' => User::hashKey($token)])->first();

        if (!isset($user)) {
            $profile = User::fromSpeedrunCom($token);

            if ($profile['status'] === 403) {
                $request->flash();
                return Redirect::back()->withErrors(['error' => 'Invalid speedrun.com token']);
            } else if (!isset($profile['user'])) {
                $request->flash();
                return Redirect::back()->withErrors(['error' => 'Failed to retrieve your speedrun.com profile.']);
            }

            $user = $profile['user'];
        }

        Auth::login($user);

        if (!Gate::allows('read-votes')) {
            Auth::logout();
            return Redirect::back()->withErrors(['error' => 'Missing authorization']);
        }

        return redirect('/verification');
    }

    public function logout()
    {
        Auth::logout();
        return \redirect('/');
    }
}
