<?php

namespace App\Http\Controllers;

use App\Models\Flag;
use App\Models\Flags;
use App\Models\VerificationState;
use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class PollManagementController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if (!Gate::allows('read-poll-state')) abort(403);

        $state = $this->getPollStates();

        return view('manage_poll', ['privileged' => Gate::allows('manage-poll'), 'state' => $state, 'hasPendingVerifications' => $this->hasPendingVerifications()]);
    }

    private function getPollStates()
    {
        return [
            Flags::IS_POLL_OPENED => Flag::getByKey(Flags::IS_POLL_OPENED),
            Flags::IS_POLL_CLOSED => Flag::getByKey(Flags::IS_POLL_CLOSED),
            Flags::IS_RESULT_PUBLIC => Flag::getByKey(Flags::IS_RESULT_PUBLIC),
            Flags::IS_VERIFICATION_CLOSED => Flag::getByKey(Flags::IS_VERIFICATION_CLOSED)
        ];
    }

    private function hasPendingVerifications()
    {
        return Vote::where(['state' => VerificationState::PENDING])->first() != null;
    }

    private function getCurrentState()
    {
        $states = $this->getPollStates();

        if ($states[Flags::IS_POLL_OPENED]->value === false)
            return $states[Flags::IS_POLL_OPENED];
        if ($states[Flags::IS_POLL_CLOSED]->value === false)
            return $states[Flags::IS_POLL_CLOSED];
        if ($states[Flags::IS_VERIFICATION_CLOSED]->value === false)
            return $states[Flags::IS_VERIFICATION_CLOSED];
        if ($states[Flags::IS_RESULT_PUBLIC]->value === false)
            return $states[Flags::IS_RESULT_PUBLIC];

        return null;
    }

    public function update(Request $request)
    {
        if (!Gate::allows('manage-poll')) abort(403);

        $currentState = $this->getCurrentState();

        if (!$currentState) abort(420);

        $validator = null;

        if ($currentState->key === Flags::IS_POLL_OPENED) {
            $validator = Validator::make($request->post(), [
                'res' => ['required', 'in:open_poll']
            ]);
        } else if ($currentState->key === Flags::IS_POLL_CLOSED) {
            $validator = Validator::make($request->post(), [
                'res' => ['required', 'in:close_poll']
            ]);
        } else if ($currentState->key === Flags::IS_VERIFICATION_CLOSED) {
            if ($this->hasPendingVerifications()) return back();

            $validator = Validator::make($request->post(), [
                'res' => ['required', 'in:close_verification']
            ]);
        } else if ($currentState->key === Flags::IS_RESULT_PUBLIC) {
            $validator = Validator::make($request->post(), [
                'res' => ['required', 'in:publish_results']
            ]);
        }

        if (!$validator) abort(500);
        if ($validator->fails()) abort(420);

        $currentState->value = true;
        $currentState->modified_by = $request->user()->id;
        $currentState->save();

        return back();
    }
}
