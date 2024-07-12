<?php

namespace App\Http\Integrations\Players;

use Saloon\Http\Auth\TokenAuthenticator;
use Saloon\Http\Connector;
use Saloon\Traits\Plugins\AcceptsJson;

class PlayersConnector extends Connector
{
    use AcceptsJson;

    public function __construct(public readonly string $token) {}

    protected function defaultAuth(): TokenAuthenticator
    {
        return new TokenAuthenticator($this->token);
    }

    /**
     * The Base URL of the API.
     */
    public function resolveBaseUrl(): string
    {
        return (string) config('services.sportsmonkapi.url');
    }

    public function defaultConfig(): array
    {
        return [
            'timeout' => 30,
        ];
    }
}
