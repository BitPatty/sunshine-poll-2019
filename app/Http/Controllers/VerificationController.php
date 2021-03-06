<?php

namespace App\Http\Controllers;

use App\Models\VerificationHistory;
use App\Models\VerificationState;
use App\Models\Vote;
use App\Models\VoteHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class VerificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if (!Gate::allows('read-votes')) abort(403);

        $votes = Vote::orderBy('state', 'ASC')->orderBy('updated_at', 'DESC')->get();
        return view('verification_panel', ['votes' => $votes]);
    }

    public function show(Request $request, $id)
    {
        if (!Gate::allows('read-votes')) abort(403);

        $vote = Vote::find($id);
        $vote_history = VoteHistory::where(['vote_id' => $vote->id])->get();
        $verification_history = VerificationHistory::where(['vote_id' => $vote->id])->get();
        return view('vote_verification', ['vote' => $vote, 'vote_history' => $vote_history, 'verification_history' => $verification_history, 'privileged' => Gate::allows('update-votes'), 'showVerificationHistory' => Gate::allows('read-verification-history')]);
    }

    public function update(Request $request, $id)
    {
        if (!Gate::allows('update-votes')) abort(403);

        $validator = Validator::make($request->post(), [
            'res' => ['required', 'in:verify,reject']
        ]);

        if ($validator->fails()) abort(500);

        $vote = Vote::find($id);
        $vote->state = $request->post('res') === 'verify' ? VerificationState::VERIFIED : VerificationState::REJECTED;
        $vote->save();

        VerificationHistory::addEntry($vote, $request->user());
        return back();
    }
}
