<?php

namespace App\Http\Controllers;

use App\Configuration\Messages;
use App\Configuration\Questions;
use App\Helpers\Fetch;
use App\Models\Vote;
use Illuminate\Http\Request;
use Validator;

class VoteController extends Controller
{
  public function __construct()
  {
  }

  public function index()
  {
    $poll = Questions::getPoll();

    if (!isset($poll))
      return response(view('PollNotFound'), 400);

    if ($this->isPollClosed())
      return response(view('PollClosed'), 200);

    return view('Home');
  }

  public function create(Request $request)
  {
    $poll = Questions::getPoll();

    if (!isset($poll))
      return response(view('PollNotFound'), 400);

    if ($this->isPollClosed())
      return response(view('PollClosed'), 400);

    $validator = Validator::make($request->post(), $this->buildValidators());
    $params = $this->parseParams($request);

    if ($validator->fails()) {
      return response(
        view('Home', [
          'errorMessages' => $this->parseValidationErrors($validator),
          'selectedValues' => $params
        ]), 412);
    }

    $dbVote = Vote::where(['api_key' => hash('sha256', $params['src_token'])])->first();

    if (!$dbVote) {
      $src_profile = $this->fetchSRCProfile($params['src_token']);

      if (!isset($src_profile)) {
        return response(view('Home', [
          'errorMessages' => [Messages::FAIL_RETRIEVE_PROFILE],
          'selectedValues' => $params
        ]), 400);
      } else {
        $dbVote = Vote::where(['src_id' => $src_profile['id']])->first();

        if (!$dbVote) {
          $dbVote = new Vote();
          $dbVote->src_id = $src_profile['id'];
          $dbVote->src_name = $src_profile['names']['international'];
          $dbVote->api_key = hash('sha256', $params['src_token']);
          $dbVote->save();

          $infoMessages = [Messages::MISSING_RUN_INIT];
          return response(view('Home', [
            'infoMessages' => $infoMessages,
            'missingRun' => true,
            'selectedValues' => $params
          ]));
        }
      }
    }

    if ($dbVote->has_src_run == false
      && $params['custom_run_url'] == null
      && $request->post('submitting_custom_run') !== '1') {

      $params['custom_run_url'] = $dbVote->custom_run_url;
      $infoMessages = [Messages::MISSING_RUN_UPDATE];
      return response(view('Home', [
        'infoMessages' => $infoMessages,
        'missingRun' => true,
        'selectedValues' => $params
      ]));
    } else if (isset($params['custom_run_url'])
      || $request->post('submitting_custom_run') === '1') {
      $dbVote->custom_run_url = $params['custom_run_url'];
      $dbVote->save();
    }

    $this->mapVoteModel($dbVote, $params);
    $dbVote[Questions::getPoll()['flag']] = true;
    $dbVote->save();

    $listItems = ['src_data' => ['name' => 'SRC Profile',
      'value' => $dbVote->src_name . ' (' . $dbVote->src_id . ')'],
      'src_run' => ['name' => 'Verification',
        'value' => $dbVote->has_src_run ? '(SRC verified)' : $dbVote->custom_run_url ?? '-']];

    foreach ($poll['question_list'] as $question) {

      $selectedValue = $dbVote[$question['id']];

      if ($question['type'] === 'select') {
        foreach ($question['options'] as $option) {
          if ($option['value'] === $selectedValue) $selectedValue = $option['label'];
        }
      }

      $listItems[$question['id']] = [
        'name' => $question['title'],
        'value' => $selectedValue
      ];
    }

    return view('Success', ['listItems' => $listItems]);
  }

  /**
   * Fetch a users SRC profile based on his api token
   * @param string $token The api token
   */
  private
  function fetchSRCProfile(string $token)
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
   * @return bool
   */
  private
  function isPollClosed()
  {
    $now = new \DateTime();
    $now->setTimezone(new \DateTimeZone('UTC'));

    $poll = Questions::getPoll();

    return ($now < $poll['from'] || $now > $poll['to']);
  }

  /**
   * @param Vote $model
   * @param array $params
   */
  private
  function mapVoteModel(Vote $model, Array $params)
  {
    foreach (Questions::getPoll()['question_list'] as $question) {
      $model[$question['id']] = $params[$question['id']];
    }

    $model->api_key = hash('sha256', $params['src_token']);
    $model->custom_run_url = $params['custom_run_url'] ?? $model->custom_run_url;
  }

  /**
   * Parse POST params
   * @param Request $request
   */
  private
  function parseParams(Request $request)
  {
    $params = [
      'src_token' => trim($request->post('src_token') ?? ''),
      'custom_run_url' => $request->post('custom_run_url'),
    ];

    foreach (Questions::getPoll()['question_list'] as $question) {
      $params[$question['id']] = trim($request->post($question['id']) ?? '-');
    }

    return $params;
  }


  /**
   * Parse validation errors into a human readable form
   * @param Validator $validator
   */
  private
  function parseValidationErrors($validator)
  {
    $errorMessages = [];


    $messages = $validator->errors();
    if ($messages->has('src_token')) {
      array_push($errorMessages, 'Invalid SRC ID supplied');
    }

    foreach (Questions::getPoll()['question_list'] as $question) {
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
   */
  private
  function buildValidators()
  {
    $validators = [
      'src_token' => 'required|regex:/^[a-zA-Z0-9 ]+$/u|min:1|max:64',
      'custom_run_url' => 'max:100'
    ];

    foreach (Questions::getPoll()['question_list'] as $question) {

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
