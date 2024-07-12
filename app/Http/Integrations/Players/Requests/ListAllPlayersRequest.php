<?php

namespace App\Http\Integrations\Players\Requests;

use App\Http\Integrations\Players\PlayersConnector;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Request\CreatesDtoFromResponse;

class ListAllPlayersRequest extends Request
{
    use CreatesDtoFromResponse;

    protected ?string $connector = PlayersConnector::class;

    protected Method $method = Method::GET;

    public function __construct(
        public string $api_version,
        public string $sport,
        public string $page_number,
    ) {}

    /**
     * The endpoint for the request
     */
    public function resolveEndpoint(): string
    {
        return "/{$this->api_version}/{$this->sport}/players?page={$this->page_number}";
    }
}
