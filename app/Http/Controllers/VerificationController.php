<?php

namespace App\Http\Controllers;

use App\Models\Vote;
use Illuminate\Http\Request;
use Validator;

class VerificationController extends Controller
{
  public function __construct()
  {

  }

  public function index(Request $request)
  {
    return view('Login', ['path' => '/verification']);
  }

  /**
   * Displays the list of votes from people without any runs on SRC
   * Updates a vote if requested
   * @param Request $request
   * @return \Illuminate\View\View
   */
  public function update(Request $request)
  {
    $validator = Validator::make($request->post(), [
      'auth_key' => 'required|alpha_num|min:3',
      'user_id' => 'regex:/^[a-zA-Z0-9]+$/u|min:1|max:64',
      'set_state' => 'in:1,0',
    ]);

    if ($validator->fails() || ($request->post('auth_key') != null && $request->post('auth_key') !== env('ADMIN_KEY'))) {
      if ($request->post('auth_key') != null) {
        return view('Login', ['path' => '/verification', 'errorMessage' => 'Invalid token']);
      } else {
        return view('Login', ['path' => '/verification']);
      }
    } else {
      if ($request->post('user_id') != null && $request->post('set_state') != null) {

        $vote = Vote::where(['src_id' => $request->post('user_id'), 'has_src_run' => false])->first();

        if ($vote) {
          $vote->is_verified = $request->post('set_state') === '1' || $request->post('set_state') === 1;
          $vote->save();
        }
      }

      $votes = Vote::where(['has_src_run' => false])->orderBy('is_verified', 'ASC')->get();
      return view('VerificationPanel', ['votes' => $votes, 'auth_key' => $request->post('auth_key')]);
    }
  }
}
