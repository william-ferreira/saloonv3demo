<?php

namespace App\Console\Commands\Player;

use App\Dto\PlayerDTO;
use App\Http\Integrations\Players\PlayersConnector;
use App\Http\Integrations\Players\Requests\ListAllPlayersRequest;
use App\Models\Player;
use Illuminate\Console\Command;

class GetPlayers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sportsmonk:players {startPage} {endPage}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch and saves a list with all football players.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $api_token = 'services.sportsmonkapi.token';
        $api_version = 'v3';
        $sport = 'football';
        $page_number = $this->argument('startPage');
        $page_limit = $this->argument('endPage');

        $players = new PlayersConnector(
            token: (string) config($api_token)
        );

        $this->info(
            string: "Fetching all football players:"
        );

        do {
            $request = new ListAllPlayersRequest(
                api_version: $api_version, 
                sport: $sport,
                page_number: $page_number,
            );    
            $request->withQueryAuth('api_token', (string) config($api_token));
            $response = $players->send($request);

            if ($response->failed()) {
                throw $response->toException();
            }

            $hasMore = $response->json('pagination')['has_more'];

            // Processing the response data through DTO
            $data = $response->json('data');
            $playerDTO = collect($data)->map(fn ($playerData) =>
                PlayerDTO::fromArray($playerData)
            );

            $all_players = $playerDTO->toArray();

            foreach ($all_players as $player) {
                Player::create([
                    'name' => $player->name,
                    'birth_date' => $player->birth_date,
                    'image_url' => $player->image_url,
                ]);
            };

            $this->table(
                headers: ['Name', 'Date of Birth', 'Image URL'],
                rows: $playerDTO->map(fn (PlayerDTO $data) =>
                    $data->toArray()
                )->toArray()
            );

            $page_number++;
        } while ($page_number <= $page_limit && $hasMore);
        
        return Command::SUCCESS;
    }
}
