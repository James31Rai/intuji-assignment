<?php

namespace App\Controllers;

use App\Services\EventService;
use App\Services\GoogleClient;
use Core\Controller;
use Core\Validation;

class CalendarEventController extends Controller
{
    private $client;
    private $service;
    private $eventService;

    public function __construct()
    {
        parent::__construct();

        $this->client = new GoogleClient();
        $this->service = new \Google_Service_Calendar($this->client);
        $this->eventService = new EventService();
    }

    /**
     * New event form for Google Calendar, acting as default page for Event
     * 
     * @return void
     */
    public function index()
    {
        $postData = [];
        if (!empty($this->session->get('postData'))) {
            $postData = $this->session->get('postData');
            $this->session->remove('postData');
        }
        $this->setRenderData('Calendar Event', 'index', $postData);
        $this->render('event/index');
    }

    /**
     * create new event for Google Calendar
     * 
     * @return void
     */
    public function addEvent()
    {
        $validation = new Validation();
        $validateRules = [
            ['summary', 'Title', ['required']],
            ['location', 'Location', ['required']],
            ['date', 'Date', ['required']],
            ['time_from', 'Time From', ['required']],
            ['time_to', 'Time To', ['required']],
        ];
        if ($validateRequest =$validation->validate($validateRules)) {
            $event =  $this->eventService->setEvent($validateRequest);
            $this->eventService->saveEvent($event);
        } else {
            if ($errors = $validation->getErrors()) {
                $errors = implode('<br/>', $errors);
                $status_response = ['status' => false, 'status_msg' => $errors];
                $this->session->set('status_response', $status_response);
            } else {
                $status_response = ['status' => false, 'status_msg' => "Nothing to validate."];
                $this->session->set('status_response', $status_response);
            }
        }
    }
    

    /**
     * listing out events for Google Calendar
     * 
     * @return void
     */
    public function listEvent()
    {
        $results = $this->eventService->showEvent();

        $this->setRenderData('Upcoming events', 'list', ['results' => $results->getItems()]);
        $this->render('event/list');
    }

    /**
     * deleting an event for Google Calendar
     * 
     * @return never
     */
    public function deleteEvent()
    {
        if ($this->eventService->removeEvent()) {
            $status_response = ['status' => true, 'status_msg' => 'Event deleted successfully.'];
            redirect(base_url() . 'event/list', ['status' => true, 'status_response' => $status_response]);
        }
        redirect(base_url());
    }
    
    /**
     * Disconnects the Google Client.
     * 
     * @return never
     */
    public function disconnectGoogle()
    {
        $this->session->clear();
        redirect(base_url());
    }

    /**
     * To Connect and Check Google Client Authorization.
     * 
     * @return void
     */
    public function googleAuthorize()
    {
        $this->eventService->googleAutorization();
    }
}