<?php

namespace App\Http\Controllers;

use App\Configuration\Messages;
use App\Configuration\Questions;
use App\Helpers\Fetch;
use App\Models\Vote;
use Illuminate\Http\Request;
use Symfony\Component\Console\Question\Question;
use Validator;

class VoteController extends Controller
{
  public function __construct()
  {
  }

  public function landing() {
    return response(view('LandingPage'), 200);
  }

  public function index($id)
  {
    $poll = Questions::getPoll($id);

    if (!isset($poll))
      return response(view('PollNotFound'), 400);

    if ($this->isPollClosed($id))
      return response(view('PollClosed'), 200);

    return view('Home', ['poll_id' => $id]);
  }

  public function create(Request $request, $id)
  {
    $poll = Questions::getPoll($id);

    if (!isset($poll))
      return response(view('PollNotFound'), 400);

    if ($this->isPollClosed($id))
      return response(view('PollClosed'), 400);

    $validator = Validator::make($request->post(), $this->buildValidators($id));
    $params = $this->parseParams($request, $id);

    if ($validator->fails()) {
      return response(
        view('Home', [
          'poll_id' => $id,
          'errorMessages' => $this->parseValidationErrors($validator, $id),
          'selectedValues' => $params
        ]), 412);
    }

    $src_profile = $this->fetchSRCProfile($params['src_token']);

    if ($src_profile == null) {
      return response(view('Home', [
        'poll_id' => $id,
        'errorMessages' => [Messages::FAIL_RETRIEVE_PROFILE],
        'selectedValues' => $params
      ]), 400);
    } else {
      $dbVote = Vote::where(['src_id' => $src_profile['id']])->first();

      if (!$dbVote) {
        if (isset($params['custom_run_url'])
          || $request->post('submitting_custom_run') === '1') {

          $dbVote = new Vote();
        } else {
          $infoMessages = [Messages::MISSING_RUN_UPDATE];
          return response(view('Home', [
            'poll_id' => $id,
            'infoMessages' => $infoMessages,
            'missingRun' => true,
            'selectedValues' => $params
          ]));
        }
      } else if ($dbVote->has_src_run == false
        && $params['custom_run_url'] == null
        && $request->post('submitting_custom_run') !== '1') {

        $params['custom_run_url'] = $dbVote->custom_run_url;
        $infoMessages = [Messages::MISSING_RUN_INIT];
        return response(view('Home', [
          'poll_id' => $id,
          'infoMessages' => $infoMessages,
          'missingRun' => true,
          'selectedValues' => $params
        ]));
      }

      $dbVote->src_id = $src_profile['id'];
      $dbVote->src_name = $src_profile['names']['international'];
      $this->mapVoteModel($dbVote, $params, $id);
      $dbVote->save();

      $listItems = [

        'src_data' => [
          'name' => 'SRC Profile',
          'value' => $dbVote->src_name . ' (' . $dbVote->src_id . ')'
        ],
        'src_run' => [
          'name' => 'Verification',
          'value' => $dbVote->has_src_run ? '(SRC verified)' : $dbVote->custom_run_url ?? '-'
        ]
      ];

      foreach ($poll['question_list'] as $question) {
        $listItems[$question['id']] = [
          'name' => $question['title'],
          'value' => $params[$question['id']]
        ];
      }

      return view('Success', ['listItems' => $listItems, 'poll_id' => $id]);
    }
  }

  /**
   * Fetch a users SRC profile based on his api token
   * @param string $token The api token
   */
  private function fetchSRCProfile(string $token)
  {
    try {
      $src_data = Fetch::Load('https://www.speedrun.com/api/v1/profile', ["X-API-Key: $token"]);
      $src_data = json_decode($src_data, true);

      if (isset($src_data) && isset($src_data['data']) && isset($src_data['data']['id'])) {
        return $src_data['data'];
      }
    } catch (Exception $ex) {
    }

    return null;
  }

  /**
   * Checks whether a poll is closed
   * @param $poll_id
   * @return bool
   */
  private function isPollClosed($poll_id)
  {
    $now = new \DateTime();
    $now->setTimezone(new \DateTimeZone('UTC'));

    $poll = Questions::getPoll($poll_id);

    return ($now < $poll['from'] || $now > $poll['to']);
  }

  /**
   *
   * @param Vote $model
   * @param array $params
   * @param string $poll_id
   */
  private function mapVoteModel(Vote $model, Array $params, string $poll_id)
  {
    foreach (Questions::getPoll($poll_id)['question_list'] as $question) {
      $model[$question['id']] = $params[$question['id']];
    }

    $model->custom_run_url = $params['custom_run_url'] ?? $model->custom_run_url;
    $model[Questions::getPoll($poll_id)['flag']] = true;
  }

  /**
   * Parse POST params
   * @param Request $request
   * @param string $poll_id
   */
  private function parseParams(Request $request, string $poll_id)
  {
    $params = [
      'src_token' => trim($request->post('src_token') ?? ''),
      'custom_run_url' => $request->post('custom_run_url'),
    ];

    foreach (Questions::getPoll($poll_id)['question_list'] as $question) {
      $params[$question['id']] = trim($request->post($question['id']) ?? '-');
    }

    return $params;
  }


  /**
   * Parse validation errors into a human readable form
   * @param Validator $validator
   * @param $poll_id
   */
  private function parseValidationErrors($validator, $poll_id)
  {
    $errorMessages = [];


    $messages = $validator->errors();
    if ($messages->has('src_token')) {
      array_push($errorMessages, 'Invalid SRC ID supplied');
    }

    foreach (Questions::getPoll($poll_id)['question_list'] as $question) {
      if ($messages->has($question['id'])) {
        if (isset($question['validation_error'])) {
          array_push($errorMessages, $question['validation_error']);
        }
      }
    }

    if ($messages->has('custom_run_url')) {
      array_push($errorMessages, 'The value submitted for your run is invalid');
    }

    if (count($errorMessages) === 0) {
      array_push($errorMessages, 'Something went wrong');
    }

    return $errorMessages;
  }

  /**
   * Build validators based on the questions
   * @param string $poll_id
   */
  private function buildValidators(string $poll_id)
  {
    $validators = [
      'src_token' => 'required|regex:/^[a-zA-Z0-9 ]+$/u|min:1|max:64',
      'custom_run_url' => 'max:100'
    ];

    foreach (Questions::getPoll($poll_id)['question_list'] as $question) {

      $validator = [];

      if (isset($question['required']) && $question['required'] === true) array_push($validator, 'required');
      if (isset($question['min'])) array_push($validator, 'min:' . $question['min']);
      if (isset($question['max'])) array_push($validator, 'max:' . $question['max']);

      if ($question['type'] === 'select') {

        $options = [];

        foreach ($question['options'] as $option) {
          array_push($options, $option['value']);
        }

        array_push($validator, 'in:' . join(',', $options));
      }

      if (count($validator) > 0) {
        $validators[$question['id']] = join('|', $validator);
      }
    }

    return $validators;
  }
}
