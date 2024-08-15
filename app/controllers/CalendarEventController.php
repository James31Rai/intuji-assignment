<?php

namespace App\Controllers;

use App\Services\GoogleClient;
use Core\Controller;

class CalendarEventController extends Controller
{
    private $client;
    private $service;

    public function __construct()
    {
        parent::__construct();

        $this->client = new GoogleClient();
        $this->service = new \Google_Service_Calendar($this->client);
    }

    public function index()
    {
        $this->setRenderData('Calendar Event', 'index');
        $this->render('event/index');
    }
    /**
     * To Connect and Check Google Client Authorization.
     * 
     * @return never
     */
    public function googleAuthorize()
    {
        if ($access_token = $this->client->checkAuthorizationFile()) {
            $this->session->set('google_access_token', $access_token);
            redirect(base_url() . 'event');
        }
        redirect(base_url());
    }
}