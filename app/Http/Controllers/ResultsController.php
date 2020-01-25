<?php

namespace App\Http\Controllers;

use App\Models\Result;
use App\Models\Run;
use App\Models\User;
use App\Models\VerificationHistory;
use App\Models\VerificationState;
use App\Models\Vote;
use App\Models\VoteHistory;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class ResultsController extends Controller
{
    public function __construct()
    {
        $results_publish_dt = env('RESULTS_PUBLISH_DT');

        if ($results_publish_dt && !empty($results_publish_dt)) {
            if (time() < $results_publish_dt) {
                $this->middleware('auth');
            }
        } else {
            $this->middleware('auth');
        }
    }

    public function index()
    {
        if (!Gate::allows('read-results')) abort(403);

        $votes = Result::all();

        return view('results', ['votes' => $votes]);
    }
}
