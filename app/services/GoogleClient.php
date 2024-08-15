<?php

namespace App\Services;

use Exception;
use Google_Client;
use Google_Service_Calendar;

class GoogleClient extends Google_Client
{

    private $oauthCredentialsPath = 'oauth-credentials.json';
    private $tokenPath = 'token.json';
    public function __construct()
    {
        // Initialize the client.
        $this->getClient();
    }

    /**
     * Setting Client
     * 
     * @return void
     */
    private function setClient()
    {
        $this->setApplicationName('Google Calendar API');
        $this->setAuthConfig($this->oauthCredentialsPath);
        $this->setAccessType('offline');
        $this->setApprovalPrompt('force');
        $this->setPrompt('select_account consent');
        $this->setScopes([
            Google_Service_Calendar::CALENDAR,
            Google_Service_Calendar::CALENDAR_EVENTS
        ]);
    }

    /**
     * set Access Token from file 
     * 
     * @return void
     */
    private function setTokenFromFile()
    {
        // Load previously authorized token from a file, if it exists.
        // The file token.json stores the user's access and refresh tokens, and is
        // created automatically when the authorization flow completes for the first
        // time.
        if (file_exists($this->tokenPath)) {
            $accessToken = json_decode(file_get_contents($this->tokenPath), true);
            if (!empty($accessToken)) {
                $this->setAccessToken($accessToken);
            }
        }
    }

    /**
     * request authorization from user
     * 
     * @throws \Exception
     * @return void
     */
    private function requestAuthorization()
    {
        if (isset($_GET['code']) && isset($_GET['scope'])) {
            $authCode = $_GET['code'];
            // Exchange authorization code for an access token.
            $accessToken = $this->fetchAccessTokenWithAuthCode($authCode);
            $this->setAccessToken($accessToken);

            // Check to see if there was an error.
            if (array_key_exists('error', $accessToken)) {
                throw new Exception(join(', ', $accessToken));
            }
        }
    }

    /**
     * Save the token to a file.
     * 
     * @return void
     */
    private function saveToken()
    {
        if (!file_exists(dirname($this->tokenPath))) {
            mkdir(dirname($this->tokenPath), 0700, true);
        }
        file_put_contents($this->tokenPath, json_encode($this->getAccessToken()));
    }

    /**
     * process Access Token if expired, request new token
     * 
     * @return void
     */
    private function processToken()
    {
        // If there is no previous token or it's expired.
        if ($this->isAccessTokenExpired()) {
            // Refresh the token if possible, else fetch a new one.
            if ($this->getRefreshToken()) {
                $this->fetchAccessTokenWithRefreshToken($this->getRefreshToken());
            } else {
                $this->requestAuthorization();
            }
            $this->saveToken();
        }
    }

    /**
     * set Access Token
     * 
     * @return void
     */
    private function setToken()
    {
        $this->setTokenFromFile();

        $this->processToken();
    }

    /**
     * get Client for Google API
     * 
     * @return void
     */
    private function getClient()
    {
        $this->setClient();
        echo 
        
        $this->setToken();
    }

    public function checkAuthorizationFile()
    {
        if (file_exists($this->tokenPath)) {
            $google_token_json = file_get_contents($this->tokenPath);
            if ((empty($google_token_json) || ($google_token_json != 'null'))) {
                return json_decode($google_token_json, TRUE);
            } else {
                $google_auth_url = $this->createAuthUrl();
                redirect($google_auth_url);
            }
        }
        return false;
    }
}