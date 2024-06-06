<?php

namespace WildanMZaki\Fcm;

use GuzzleHttp\Client as GuzzleClient;

class Client
{
    private $token;
    private $baseUrl;
    private $projectId;
    private $credentialsFilePath;
    private $httpClient;

    public function __construct($credentialsFilePath, $projectId, $isProduction = false)
    {
        $this->credentialsFilePath = $credentialsFilePath;
        $this->projectId = $projectId;
        $this->baseUrl = 'https://fcm.googleapis.com';
        $this->token = $this->getAccessToken();
        $this->httpClient = new GuzzleClient();
        date_default_timezone_set('Asia/Jakarta');
    }

    private function getAccessToken()
    {
        $client = new \Google_Client();
        $client->setAuthConfig($this->credentialsFilePath);
        $client->addScope('https://www.googleapis.com/auth/firebase.messaging');
        $client->fetchAccessTokenWithAssertion();
        $token = $client->getAccessToken();
        return $token['access_token'];
    }

    public function send(Notification $notification)
    {
        $url = $this->baseUrl . "/v1/projects/{$this->projectId}/messages:send";
        $response = $this->httpClient->post($url, [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->token,
                'Content-Type' => 'application/json',
            ],
            'json' => $notification->build(),
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }
}
