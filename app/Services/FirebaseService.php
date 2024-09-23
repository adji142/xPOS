<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Firebase\JWT\JWT;

class FirebaseService
{
    protected $client;
    protected $projectId;
    protected $authToken;
    protected $serviceAccountFile;

    public function __construct()
    {
        $this->client = new Client();
        $this->serviceAccountFile = base_path('\config\firebase_credentials.json');
        $this->projectId = json_decode(file_get_contents($this->serviceAccountFile), true)['project_id'];
        $this->authToken = $this->getAccessToken();
    }

    private function getAccessToken()
    {
        $jwt = $this->createJwt();

        $response = $this->client->post('https://oauth2.googleapis.com/token', [
            'form_params' => [
                'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
                'assertion' => $jwt,
            ],
        ]);

        $data = json_decode($response->getBody(), true);
        return $data['access_token'];
    }

    private function createJwt()
    {
        $now = time();
        $key = json_decode(file_get_contents($this->serviceAccountFile), true);
        $payload = [
            'iss' => $key['client_email'],
            'scope' => 'https://www.googleapis.com/auth/firebase.messaging',
            'aud' => 'https://oauth2.googleapis.com/token',
            'iat' => $now,
            'exp' => $now + 3600,
        ];

        return JWT::encode($payload, $key['private_key'], 'RS256');
    }

    public function sendNotification($title, $body, $token,$data)
    {
        
        $message = [
            'message' => [
                'token' => $token,
                'notification' => [
                    'title' => $title,
                    'body' => $body,
                ],
                'data' => $data
            ],
        ];

        try {
            $response = $this->client->post("https://fcm.googleapis.com/v1/projects/receiptprinter-89dc0/messages:send", [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->authToken,
                    'Content-Type' => 'application/json',
                ],
                'json' => $message,
            ]);

            return json_decode($response->getBody(), true);
        } catch (RequestException $e) {
            return [
                'error' => $e->getMessage(),
                'response' => $e->hasResponse() ? $e->getResponse()->getBody()->getContents() : null,
            ];
        }
    }
}
