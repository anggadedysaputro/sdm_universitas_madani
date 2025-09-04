<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Firebase\JWT\JWT;
use Exception;

class FcmService
{
    /**
     * Ambil Access Token dari Google OAuth
     */
    private static function getAccessToken(): array
    {
        $filePath = storage_path("app/firebase/pvKey.json");

        if (!$filePath || !File::exists($filePath)) {
            throw new Exception('FCM_JSON_LOCATION not set or file not found');
        }

        $serviceAccount = json_decode(File::get($filePath), true);

        $projectId   = $serviceAccount['project_id'] ?? null;
        $clientEmail = $serviceAccount['client_email'] ?? null;
        $privateKey  = $serviceAccount['private_key'] ?? null;

        if (!$projectId || !$clientEmail || !$privateKey) {
            throw new Exception('Invalid service account JSON: missing project_id, client_email or private_key');
        }

        $now = time();
        $payload = [
            'iss'   => $clientEmail,
            'scope' => 'https://www.googleapis.com/auth/firebase.messaging',
            'aud'   => 'https://oauth2.googleapis.com/token',
            'iat'   => $now,
            'exp'   => $now + 3600,
        ];

        // Encode JWT pakai firebase/php-jwt
        $jwt = JWT::encode($payload, $privateKey, 'RS256');

        // Tukar JWT -> access token
        $response = Http::asJson()->post('https://oauth2.googleapis.com/token', [
            'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
            'assertion'  => $jwt,
        ]);

        if (!$response->ok() || empty($response['access_token'])) {
            throw new Exception('Failed to get FCM access token: ' . $response->body());
        }

        return [
            'token'     => $response['access_token'],
            'projectId' => $projectId,
        ];
    }

    /**
     * Kirim Notifikasi FCM
     */
    public static function sendNotification(array $params)
    {
        $topic       = $params['topic'] ?? null;
        $deviceToken = $params['token'] ?? null;
        $title       = $params['title'] ?? '';
        $body        = $params['body'] ?? '';
        $data        = $params['data'] ?? [];

        if (!$topic && !$deviceToken) {
            throw new Exception('You must provide either topic or token');
        }

        $access = self::getAccessToken();
        $url = "https://fcm.googleapis.com/v1/projects/{$access['projectId']}/messages:send";

        $message = [
            'notification' => [
                'title' => $title,
                'body'  => $body,
            ],
            'data' => array_map('strval', $data), // semua value harus string
        ];

        if ($topic) {
            $message['topic'] = $topic;
        } else {
            $message['token'] = $deviceToken;
        }

        try {
            $response = Http::withToken($access['token'])
                ->timeout(10)
                ->post($url, ['message' => $message]);

            if (!$response->ok()) {
                Log::error('Error sending FCM: ' . $response->body());
                throw new Exception('Error sending FCM: ' . $response->body());
            }

            return $response->json();
        } catch (Exception $e) {
            Log::error('FCM Exception: ' . $e->getMessage());
            throw $e;
        }
    }
}
