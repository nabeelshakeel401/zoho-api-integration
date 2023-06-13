<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Session;

class ZohoService
{
    protected $clientId;
    protected $clientSecret;
    protected $redirectUri;
    protected $refreshToken;

    protected $token;

    public function __construct()
    {
        $this->clientId = config('zoho.client_id');
        $this->clientSecret = config('zoho.client_secret');
        $this->refreshToken = config('zoho.refresh_token');
        $this->redirectUri = config('zoho.redirect_uri');
        $this->token = $this->getToken();
    }

    public function getCurrentToken()
    {
        return $this->token;
    }

    public function createAccount($data)
    {
        $response = Http::withToken($this->token)
            ->post('https://www.zohoapis.com/crm/v2/Accounts', [
                'data' => [$data],
            ]);

        // return $response->json();
        return $response;
    }

    public function createDeal($data)
    {
        $response = Http::withToken($this->token)
            ->post('https://www.zohoapis.com/crm/v2/Deals', [
                'data' => [$data],
            ]);

        // return $response->json();
        return $response;
    }

    public function getToken($refreshToken = false)
    {
        if (!$refreshToken) {
            //return from cache if we don't need to refresh token
            $token = Cache::get(config('zoho.token_var'));
    
            if ($token) {
                return $token;
            }
        }

        $response = Http::asForm()->post('https://accounts.zoho.com/oauth/v2/token', [
            'grant_type' => 'refresh_token',
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
            'refresh_token' => $this->refreshToken
        ]);

        if ($response->ok()) {
            $token = $response->json('access_token');
            $expiresIn = $response->json('expires_in');

            // Cache the token for future use
            Cache::put(config('zoho.token_var'), $token, now()->addSeconds($expiresIn));

            return $token;
        }

        throw new \Exception('Failed to obtain Zoho CRM token');
    }

}
