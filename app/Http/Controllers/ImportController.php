<?php

namespace App\Http\Controllers;

use App\Configuration\SRCGames;
use App\Helpers\Fetch;
use App\Models\Category;
use App\Models\Run;
use App\Models\Vote;
use Illuminate\Http\Request;
use Validator;

class ImportController extends Controller
{
  public function __construct()
  {
  }

  /**
   * Imports all players of the games specified in the configuration
   * @param Request $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function index(Request $request)
  {
    if (!$request->input('key') || $request->input('key') !== env('IMPORT_KEY')) {
      return response()->json(['res' => 'Unauthorized'], 401);
    }

    $categories = $this->importCategories();

    for ($i = 0; $i < count($categories); $i++) {
      $lb = $this->fetchLeaderboard($categories[$i]['src_game_id'], $categories[$i]['src_id']);

      if ($lb) {
        $players = $this->extractPlayers($lb);

        if ($players) {
          for ($j = 0; $j < count($players); $j++) {
            $this->importPlayer($players[$j]);
          }
        }

        $this->importRuns($lb);
      }
    }

    return response()->json(['res' => 'Done'], 200);
  }

  /**
   * Imports all runs on the specified leaderboard to the database
   * @param $leaderboard
   */
  private function importRuns($leaderboard)
  {

    for ($i = 0; $i < count($leaderboard['data']['runs']); $i++) {

      if ($leaderboard['data']['runs'][$i]['run']['players'][0]['rel'] === 'user') {
        $run = Run::where(['src_id' => $leaderboard['data']['runs'][$i]['run']['id']])->first();
        $player = Vote::where(['src_id' => $leaderboard['data']['runs'][$i]['run']['players'][0]['id']])->first();
        $category = Category::where(['src_id' => $leaderboard['data']['runs'][$i]['run']['category']])->first();

        if ($player && $category) {

          if (!$run) {
            $run = new Run();
            $run->src_id = $leaderboard['data']['runs'][$i]['run']['id'];
          }

          $run->fk_t_vote = $player->id;
          $run->fk_t_category = $category->id;
          $run->personal_best = floor($leaderboard['data']['runs'][$i]['run']['times']['primary_t']);
          $run->run_date = new \DateTime($leaderboard['data']['runs'][$i]['run']['date']);
          $run->save();
        }
      }
    }
  }

  /**
   * Imports all categories from the global game list
   * @return Category[]|\Illuminate\Database\Eloquent\Collection
   */
  private function importCategories()
  {

    for ($i = 0; $i < count(SRCGames::GAME_LIST); $i++) {
      $categories = $this->fetchCategories(SRCGames::GAME_LIST[$i]['id']);

      for ($j = 0; $j < count($categories); $j++) {
        $cat = Category::where(['src_id' => $categories[$j]['id']])->first();

        if (!$cat) $cat = new Category();

        $cat->src_id = $categories[$j]['id'];
        $cat->src_name = $categories[$j]['name'];
        $cat->src_game_id = SRCGames::GAME_LIST[$i]['id'];
        $cat->src_game_name = SRCGames::GAME_LIST[$i]['name'];
        $cat->save();
      }
    }

    return Category::all();
  }

  /**
   * Imports a SRC user to the database and
   * marks them as verified
   * @param $player
   */
  private function importPlayer($player)
  {
    $dbVote = Vote::where(['src_id' => $player['id']])->first();

    if (!$dbVote) {
      $dbVote = new Vote();
      $dbVote->src_id = $player['id'];
      $dbVote->src_name = $player['name'];
    }

    if (!isset($dbVote->has_src_run)
      || $dbVote->has_src_run == false
      || !isset($dbVote->is_verified)
      || $dbVote->is_verified == false) {
      $dbVote->has_src_run = true;
      $dbVote->is_verified = true;
      $dbVote->save();
    }
  }

  /**
   * Fetches the category list from speedrun.com
   * (full-game categories only)
   * @param string $game_id
   * @return array|null
   */
  private function fetchCategories(string $game_id)
  {
    try {
      $categories = Fetch::Load("https://www.speedrun.com/api/v1/games/$game_id/categories");
      $categories = json_decode($categories, true);

      $parsedCategories = array();

      if (isset($categories)
        && isset($categories['data'])
        && is_array($categories['data'])) {


        for ($i = 0; $i < count($categories['data']); $i++) {
          if ($categories['data'][$i]['type'] === 'per-game') {
            array_push($parsedCategories, [
              'id' => $categories['data'][$i]['id']
              , 'name' => $categories['data'][$i]['name']
            ]);
          }
        }
      }

      return $parsedCategories;
    } catch (Exception $ex) {
    }

    return null;
  }

  /**
   * Extracts the players from the specified leaderboard
   * @param $leaderboard
   * @return array
   */
  private function extractPlayers($leaderboard)
  {
    $users = array();

    for ($i = 0; $i < count($leaderboard['data']['players']['data']); $i++) {
      if ($leaderboard['data']['players']['data'][$i]['rel'] === 'user') {
        array_push(
          $users,
          [
            'id' => $leaderboard['data']['players']['data'][$i]['id'],
            'name' => $leaderboard['data']['players']['data'][$i]['names']['international']
          ]
        );
      }
    }

    return $users;
  }

  /**
   * Fetches the leaderboard for the specified game/category
   * and its players (registered users only)
   * @param string $game_id
   * @param string $category_id
   * @return mixed|null
   */
  private function fetchLeaderboard(string $game_id, string $category_id)
  {
    try {
      $p_runs = Fetch::Load("https://www.speedrun.com/api/v1/leaderboards/$game_id/category/$category_id?embed=players");
      $runs = json_decode($p_runs, true);

      if ($runs && isset($runs['data']) && isset($runs['data']['runs'])) return $runs;
    } catch (Exception $ex) {
    }

    return null;
  }
}
