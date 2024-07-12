<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Integrations\Players\PlayersConnector;
use App\Http\Integrations\Players\Requests\ListAllPlayersRequest;
use Illuminate\Support\Facades\Log;

class PlayersController extends Controller
{
    protected $api_token = 'services.sportsmonkapi.token';
    protected $api_version = 'v3';
    protected $sport = 'football';
    protected $page_number = '3';

    public function index(){

        $players = new PlayersConnector((string) config($this->api_token));
        $request = new ListAllPlayersRequest($this->api_version, $this->sport, $this->page_number);

        $request->withQueryAuth('api_token', (string) config($this->api_token));

        $response = $players->send($request);

        $responseContent = $response->body();

        if ($response->successful()) {
            $all_players = $response->json();
            return view('players', compact('responseContent', 'all_players'));
        } else {
            Log::error('This is an error log message');
        }
    }
}
