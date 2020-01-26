<?php

namespace App\Http\Controllers;

use App\Models\Flag;
use App\Models\Flags;
use App\Models\User;
use App\Models\VerificationHistory;
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
        if (Flag::getByKey(Flags::IS_POLL_CLOSED)->value === true || Flag::getByKey(Flags::IS_POLL_OPENED)->value === false) return view('poll_closed');

        return view('poll');
    }

    public function submit(Request $request)
    {
        if (Flag::getByKey(Flags::IS_POLL_CLOSED)->value === true || Flag::getByKey(Flags::IS_POLL_OPENED)->value === false) return view('poll_closed');

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
                return Redirect::back()->withErrors(['error' => 'error_messages.src_token.invalid']);
            } else if (!isset($profile['user'])) {
                $request->flash();
                return Redirect::back()->withErrors(['error' => 'error_messages.src_token.failed_to_retrieve']);
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
        $vote->state = $isVerified ? VerificationState::AUTO_VERIFIED : ($vote->state === VerificationState::VERIFIED ? VerificationState::VERIFIED : VerificationState::PENDING);
        $vote->save();
        $vote = Vote::where(['user_id' => $user->id])->first();
        VoteHistory::addEntry($vote);
        VerificationHistory::addEntry($vote, User::getServiceAccount());

        return view('success', ['vote' => $vote]);
    }

    private static $validatorMessages = [
        'src_token.required' => 'error_messages.src_token.required',
        'src_token.min' => 'error_messages.src_token.invalid',
        'src_token.max' => 'error_messages.src_token.invalid',
        'v_hide_timings.required' => 'error_messages.v_hide_timings.required',
        'v_hide_timings.in' => 'error_messages.v_hide_timings.in',
        'v_timing_method_a.required' => 'error_messages.v_timing_method_a.required',
        'v_timing_method_a.in' => 'error_messages.v_timing_method_a.in',
        'v_timing_method_b.required' => 'error_messages.v_timing_method_b.required',
        'v_timing_method_b.in' => 'error_messages.v_timing_method_b.in',
        'v_timing_method_c.required' => 'error_messages.v_timing_method_c.required',
        'v_timing_method_c.in' => 'error_messages.v_timing_method_c.in',
        'v_timing_method_d.required' => 'error_messages.v_timing_method_d.required',
        'v_timing_method_d.in' => 'error_messages.v_timing_method_d.in',
        'comment.max' => 'error_messages.comment.max',
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
