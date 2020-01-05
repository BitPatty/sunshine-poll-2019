<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Run;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Console\Command;

class RunnerImport extends Command
{
    protected $signature = 'runners:import';
    protected $description = 'Imports Runners from SRC';


    private const GAMES = [
        [
            'id' => 'v1pxjz68',
            'name' => 'Super Mario Sunshine',
        ],
        [
            'id' => '4d794pl1',
            'name' => 'Super Mario Sunshine Category Extensions',
        ]
    ];

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        foreach (self::GAMES as $game) {
            $this->importCategories($game['id'], $game['name']);
        }

        $categories = Category::all();

        foreach ($categories as $category) {
            $lb = $this->fetchLeaderboard($category->game_id, $category->category_id);

            if ($lb) {
                $players = $this->extractPlayers($lb);

                if ($players) {
                    foreach ($players as $player) {
                        $this->importPlayer($player);
                    }
                }

                $this->importRuns($lb);
            }
        }
    }

    private function importRuns($leaderboard)
    {
        for ($i = 0; $i < count($leaderboard['data']['runs']); $i++) {
            if ($leaderboard['data']['runs'][$i]['run']['players'][0]['rel'] === 'user') {
                $run = Run::where(['src_id' => $leaderboard['data']['runs'][$i]['run']['id']])->first();
                $user = User::where(['src_id' => $leaderboard['data']['runs'][$i]['run']['players'][0]['id']])->first();
                $category = Category::where(['category_id' => $leaderboard['data']['runs'][$i]['run']['category']])->first();

                if ($user && $category) {
                    if (!$run) {
                        $run = new Run();
                        $run->src_id = $leaderboard['data']['runs'][$i]['run']['id'];
                        $run->user_id = $user->id;
                        $run->category_id = $category->id;
                        $run->personal_best = floor($leaderboard['data']['runs'][$i]['run']['times']['primary_t']);
                        $run->run_date = new \DateTime($leaderboard['data']['runs'][$i]['run']['date']);
                        $run->save();
                    }
                }
            }
        }
    }

    private function importPlayer($player)
    {
        $user = User::where(['src_id' => $player['id']])->first();
        if (!$user) {
            $user = new User();
            $user->src_id = $player['id'];
            $user->src_name = $player['name'];
            $user->save();
        }
    }

    private function importCategories(string $game_id, string $game_name)
    {
        $categories = $this->fetchCategories($game_id);

        if ($categories) {

            foreach ($categories as $category) {
                $c = Category::where(['category_id' => $category['id']])->first();

                if (!isset($c)) {
                    $cat = new Category();
                    $cat->game_id = $game_id;
                    $cat->game_name = $game_name;
                    $cat->category_id = $category['id'];
                    $cat->category_name = $category['name'];
                    $cat->save();
                }
            }
        }
    }

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

    private function fetchCategories(string $game_id)
    {
        try {
            $categories = $this->fetch("https://www.speedrun.com/api/v1/games/$game_id/categories");
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
        } catch (\Exception $ex) {
            var_dump($ex);
        }

        return null;
    }

    private function fetchLeaderboard(string $game_id, string $category_id)
    {
        try {
            $p_runs = $this->fetch("https://www.speedrun.com/api/v1/leaderboards/$game_id/category/$category_id?embed=players");
            $runs = json_decode($p_runs, true);
            if ($runs && isset($runs['data']) && isset($runs['data']['runs'])) return $runs;
        } catch (\Exception $ex) {
            var_dump($ex);
        }
        return null;
    }

    private
    function fetch(string $url)
    {
        $client = new Client();

        $response = $client->request('GET', $url, [
            'http_errors' => false,
            'headers' => [
                'User-Agent' => 'Speedrun Survey',
                'Accept' => 'application/json',
            ]
        ]);

        return $response->getBody();
    }
}
