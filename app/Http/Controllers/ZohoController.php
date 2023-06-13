<?php

namespace App\Http\Controllers;

use App\Services\ZohoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;


class ZohoController extends Controller
{
    //
    protected $zohoService;

    public function __construct(ZohoService $zohoService)
    {
        $this->zohoService = $zohoService;
    }

    //This method will only work once after the client id, secret & code have been set in the env (generated using Self Client)
    protected function getFirstTimeTokens()
    {
        //Fetching access and refresh token the first time - code was generated using Self Client
        // Fetch a new token from Zoho API
        $response = Http::asForm()->post('https://accounts.zoho.com/oauth/v2/token', [
            // 'grant_type' => 'client_credentials',
            'grant_type' => 'authorization_code',
            'client_id' => config('zoho.client_id'),
            'client_secret' => config('zoho.client_secret'),
            'redirect_uri' => config('zoho.redirect_uri'),
            'code' => env('ZOHO_SELF_CODE'),
        ]);

        //get the access token and refresh token and save refresh token in env
        dd($response->json());

        throw new \Exception('Failed to obtain Zoho CRM token using Self API authorization code');
    }


    
    //For Testing
    /* public function createAccountTest()
    {
        $data = [
            'Account_Name' => 'Account A',
            'Website' => 'http://testwebsite.com',
            'Phone' => '+923211234567'
        ];
        $this->zohoService->createAccount($data);
    } */

    public function createDealAndAccount(Request $request)
    {
        // Validate the form fields
        $validatedData = $request->validate([
            'deal_name' => 'required|string',
            'deal_stage' => 'required|string',
            'account_name' => 'required|string',
            'account_website' => 'required|url',
            'account_phone' => 'required|string',
        ]);
        
        //For Testing
        /* $validatedData = [
            'deal_name' => 'Deal 1',
            'deal_stage' => 'Needs Analysis',
            'account_name' => 'Test Account',
            'account_website' => 'http://testaccount.com/',
            'account_phone' => '+923211234568',
        ]; */

        $accountData = [
            'Account_Name' => $validatedData['account_name'],
            'Website' => $validatedData['account_website'],
            'Phone' => $validatedData['account_phone']
        ];

        $accountResponse = $this->zohoService->createAccount($accountData);
        if ($accountResponse->successful()) {
            $accountResponse = $accountResponse->json();
            $accountId = $accountResponse['data'][0]["details"]['id'];

            // Create a deal in Zoho CRM
            $dealData = [
                'Deal_Name' => $validatedData['deal_name'],
                'Stage' => $validatedData['deal_stage'],
                'Account_Name' => [
                    'id' => $accountId
                ],
            ];
    
            $dealResponse = $this->zohoService->createDeal($dealData);
    
            if ($dealResponse->successful()) {
                $dealResponse = $dealResponse->json();
                dd($dealData, $dealResponse);
                // Deal created successfully
                $dataId = $dealResponse['data'][0]["details"]['id'];

                //Do something with DataId if required
                
    
                if ($accountResponse->successful()) {
                    // Account created successfully
                    return response()->json(['message' => 'Deal and Account created successfully']);
                }
            }

            return response()->json(['message' => 'Account created successfully, but failed to create Deal']);
        }


        // Failed to create deal or account
        return response()->json(['message' => 'Failed to create Deal and Account'], 500);
    }

}
