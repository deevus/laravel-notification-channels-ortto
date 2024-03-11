<?php

namespace NotificationChannels\Ortto\Client;

use Illuminate\Support\Facades\Http;

class OrttoClient
{
    public function __construct(
        protected string $endpoint_url,
        protected string $api_key
    ) {
    }

    /** @return \Illuminate\Http\Client\PendingRequest */
    public function request()
    {
        return Http::withHeader("X-Api-Key", $this->api_key)->baseUrl(
            $this->endpoint_url
        );
    }

    /** @return \GuzzleHttp\Client */
    public function httpClient()
    {
        return $this->request()->buildClient();
    }

    public function transactionalEmail()
    {
        return new TransactionalEmailBuilder($this->request());
    }
}
