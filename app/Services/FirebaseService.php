<?php

namespace App\Services;

use Google\Auth\Credentials\ServiceAccountCredentials;
use Google\Auth\HttpHandler\HttpHandlerFactory;

class FirebaseService
{
    protected string $projectId = 'e-presensi-c912a'; // ganti sesuai project ID
    protected string $credentialsPath = 'storage/app/firebase/pvKey.json';

    protected function getAccessToken(): string
    {
        $credentials = new ServiceAccountCredentials(
            "https://www.googleapis.com/auth/firebase.messaging",
            json_decode(file_get_contents(base_path($this->credentialsPath)), true)
        );

        $token = $credentials->fetchAuthToken(HttpHandlerFactory::build());
        return $token['access_token'] ?? '';
    }

    public function sendNotification(string $deviceToken, string $title, string $body, array $data = [])
    {
        $url = "https://fcm.googleapis.com/v1/projects/{$this->projectId}/messages:send";
        $accessToken = $this->getAccessToken();
        dd($accessToken);
        $payload = [
            "message" => [
                "token" => $deviceToken,
                "notification" => [
                    "title" => $title,
                    "body"  => $body,
                ],
                "data" => $data,
            ],
        ];

        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $accessToken,
            ],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($payload),
        ]);

        $response = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            throw new \Exception("cURL Error: " . $error);
        }

        return json_decode($response, true);
    }
}
