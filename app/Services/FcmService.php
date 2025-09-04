<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Firebase\JWT\JWT;

class FcmService
{
    /**
     * Ambil Access Token dari Google OAuth
     */
    private static function getAccessToken(): array
    {
        try {
            $filePath = storage_path("app/firebase/pvKey.json");

            if (!$filePath || !File::exists($filePath)) {
                return [
                    'status'  => false,
                    'message' => 'FCM JSON file not found: ' . $filePath,
                ];
            }

            $serviceAccount = json_decode(File::get($filePath), true);

            $projectId   = $serviceAccount['project_id'] ?? null;
            $clientEmail = $serviceAccount['client_email'] ?? null;
            $privateKey  = $serviceAccount['private_key'] ?? null;

            if (!$projectId || !$clientEmail || !$privateKey) {
                return [
                    'status'  => false,
                    'message' => 'Invalid service account JSON: missing project_id, client_email or private_key',
                ];
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
                return [
                    'status'  => false,
                    'message' => 'Failed to get FCM access token',
                    'detail'  => $response->json(),
                ];
            }

            return [
                'status'    => true,
                'token'     => $response['access_token'],
                'projectId' => $projectId,
            ];
        } catch (\Throwable $e) {
            Log::error('FCM getAccessToken error: ' . $e->getMessage());
            return [
                'status'  => false,
                'message' => 'Exception while getting access token',
                'error'   => $e->getMessage(),
            ];
        }
    }

    /**
     * Kirim Notifikasi FCM
     */
    public static function sendNotification(array $params): array
    {
        $topic       = $params['topic'] ?? null;
        $deviceToken = $params['token'] ?? null;
        $title       = $params['title'] ?? '';
        $body        = $params['body'] ?? '';
        $data        = $params['data'] ?? [];

        // Kalau tidak ada tujuan → langsung return gagal
        if (!$topic && !$deviceToken) {
            return [
                'status'  => false,
                'message' => 'You must provide either topic or token',
            ];
        }

        try {
            $access = self::getAccessToken();

            // Kalau gagal ambil token → return langsung
            if (empty($access['status']) || !$access['status']) {
                return $access;
            }

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

            $response = Http::withToken($access['token'])
                ->timeout(10)
                ->post($url, ['message' => $message]);

            if (!$response->ok()) {
                Log::warning('FCM send failed: ' . $response->body());
                return [
                    'status'  => false,
                    'message' => 'Error sending FCM',
                    'detail'  => $response->json(),
                ];
            }

            return [
                'status'  => true,
                'message' => 'FCM sent successfully',
                'data'    => $response->json(),
            ];
        } catch (\Throwable $e) {
            Log::error('FCM Exception: ' . $e->getMessage());
            return [
                'status'  => false,
                'message' => 'Exception while sending FCM',
                'error'   => $e->getMessage(),
            ];
        }
    }
}
