<?php

namespace App\Models;

use GuzzleHttp\Client;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Crypt;

class User extends Model implements AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract
{
    use Notifiable, Authenticatable, Authorizable, CanResetPassword;

    public function runs() {
        return $this->hasMany(Run::class, 'user_id', 'id');
    }

    protected $fillable = [
        'src_id', 'src_name', 'src_api_token'
    ];

    protected $hidden = [
        'src_api_token', 'remember_token',
    ];

    protected $table = 't_user';

    public static function fromSpeedrunCom(string $token)
    {
        $src_data = self::fetchSrcProfile($token);

        if ($src_data['status'] === 200 && isset($src_data['data'])) {

            $u = User::where(['src_id' => $src_data['data']['id']])->first();

            if (!isset($u)) $u = new User();

            $u->src_id = $src_data['data']['id'];
            $u->src_name = $src_data['data']['names']['international'];
            $u->src_api_token = self::hashKey($token);
            $u->save();

            return [
                'status' => $src_data['status'],
                'user' => User::where(['src_id' => $src_data['data']['id']])->first()
            ];
        }

        return $src_data;
    }

    public static function hasRuns(User $user)
    {
        return Run::where(['user_id' => $user->id])->first() != null;
    }

    public static function hashKey(string $token)
    {
        return hash('sha256', $token);
    }

    private static function fetchSrcProfile(string $token)
    {
        $client = new Client();

        $response = $client->request('GET', 'https://speedrun.com/api/v1/profile', [
            'http_errors' => false,
            'headers' => [
                'User-Agent' => 'Speedrun Survey',
                'Accept' => 'application/json',
                'X-API-Key' => $token
            ]
        ]);

        $statusCode = $response->getStatusCode();


        if ($statusCode === 200) {
            $src_data = json_decode($response->getBody(), true);

            if (!isset($src_data) || !isset($src_data['data']) || !isset($src_data['data']['id'])) return [
                'status' => 200,
                'data' => null
            ];
            return [
                'status' => 200,
                'data' => $src_data['data']
            ];
        } else {
            return [
                'status' => $statusCode,
                'data' => null
            ];
        }
    }
}
