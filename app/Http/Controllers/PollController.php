<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\VerificationState;
use App\Models\Vote;
use App\Models\VoteHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class PollController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function index()
    {
        return view('poll');
    }

    public function submit(Request $request)
    {
        $validator = $this->createSubmissionValidator($request->post());

        if ($validator->fails()) {
            $request->flash();
            return Redirect::back()->withErrors($validator);
        }

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

        if (User::hasRuns($user)) return $this->registerVote($request, $user, true);
        elseif ($request->post('page_identifier') === 'submit_custom_run') {
            return $this->registerVote($request, $user, false);
        }

        $vote = Vote::where(['user_id' => $user->id])->first();
        return view('poll_custom_run', ['values' => $request->post(), 'custom_run_url' => isset($vote) ? $vote->custom_run_url : null]);
    }

    private static function registerVote(Request $request, User $user, bool $isVerified)
    {
        $vote = Vote::where(['user_id' => $user->id])->first();

        if (!$vote) $vote = new Vote();

        $vote->user_id = $user->id;
        $vote->v_hide_timings = $request->post('v_hide_timings');
        $vote->v_timing_method_a = $request->post('v_timing_method_a');
        $vote->v_timing_method_b = $request->post('v_timing_method_b');
        $vote->v_timing_method_c = $request->post('v_timing_method_c');
        $vote->v_timing_method_d = $request->post('v_timing_method_d');
        $vote->custom_run_url = $request->post('custom_run_url');
        $vote->comment = trim($request->post('comment') ?? '');
        $vote->state = $isVerified ? VerificationState::AUTO_VERIFIED : $vote->state ?? VerificationState::PENDING;
        $vote->save();
        $vote = Vote::where(['user_id' => $user->id])->first();
        VoteHistory::addEntry($vote);
        return view('success', ['vote' => $vote]);
    }

    private static $validatorMessages = [
        'src_token.required' => 'The speedrun.com token is required',
        'src_token.min' => 'Invalid speedrun.com token',
        'src_token.max' => 'Invalid speedrun.com token',
        'v_hide_timings.in' => 'Invalid Option for "Hide Timings"',
        'v_timing_method_a.required' => 'An option for "Timing Method A" is required',
        'v_timing_method_a.in' => 'Invalid Option for "Timing Method A"',
        'v_timing_method_b.required' => 'An option for "Timing Method B" is required',
        'v_timing_method_b.in' => 'Invalid Option for "Timing Method B"',
        'v_timing_method_c.required' => 'An option for "Timing Method C" is required',
        'v_timing_method_c.in' => 'Invalid Option for "Timing Method C"',
        'v_timing_method_d.required' => 'An option for "Timing Method D" is required',
        'v_timing_method_d.in' => 'Invalid Option for "Timing Method D"',
        'comment.max' => 'The comment may not exceed 1000 characters',
    ];

    private function createSubmissionValidator($data)
    {
        return Validator::make($data, [
            'src_token' => ['required', 'min: 3', 'max: 30'],
            'v_hide_timings' => ['required', 'in:No Vote,Yes,No'],
            'v_timing_method_a' => ['required', 'in:No Vote,Yes,No'],
            'v_timing_method_b' => ['required', 'in:No Vote,Yes,No'],
            'v_timing_method_c' => ['required', 'in:No Vote,Yes,No'],
            'v_timing_method_d' => ['required', 'in:No Vote,Yes,No'],
            'comment' => ['max:1000']
        ], self::$validatorMessages);
    }
}
