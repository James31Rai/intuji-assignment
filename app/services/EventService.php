<?php

namespace App\Services;

use Core\Request;
use Core\Session;
use Google_Service_Calendar_EventDateTime;

class EventService
{
    private $client;
    private $service;
    private $session;

    function __construct()
    {
        $this->client = new GoogleClient();
        $this->service = new \Google_Service_Calendar($this->client);
        $this->session = new Session();
    }

    /**
     * set new event for saving in Google Calendar
     * 
     * @param mixed $validateRequest
     * @return \Google_Service_Calendar_Event
     */
    public function setEvent($validateRequest)
    {
        $timezone = $_ENV['APP_TIMEZONE'];
        $timezone_offset = ':00+05:45';
        // $timezone_offset = ':00.000Z';

        $event = new \Google_Service_Calendar_Event();
        $event->setSummary($validateRequest['summary']);
        $event->setLocation($validateRequest['location']);
        $event->setDescription($validateRequest['description']);
        $startDateTime = $validateRequest['date'] . 'T' . $validateRequest['time_from'] . $timezone_offset;
        // echo $startDateTime;exit;
        $start = new Google_Service_Calendar_EventDateTime();
        $start->setDateTime($startDateTime);
        $event->setStart($start);
        $endDateTime = $validateRequest['date'] . 'T' . $validateRequest['time_to'] . $timezone_offset;
        $end = new Google_Service_Calendar_EventDateTime();
        $end->setDateTime($endDateTime);
        $event->setEnd($end);

        return $event;
    }

    /**
     * saving new Event for Google Calendar
     * @param mixed $event
     * @return never
     */
    public function saveEvent($event)
    {
        $calendarId = 'primary';
        $event = $this->service->events->insert($calendarId, $event);
        $event_link = $event->getHtmlLink();
        $status_response = ['status' => true, 'status_msg' => 'Event added successfully. You can view your event <a href="' . $event_link . ' target="_blank">here</a>'];
        redirect(base_url() . 'event', ['status' => true, 'status_response' => $status_response]);
    }

    /**
     * show list of events for Google Calendar
     * 
     * @return mixed
     */
    public function showEvent()
    {
        $calendarId = 'primary';
        $optParams = array(
            'maxResults' => 10,
            'orderBy' => 'startTime',
            'singleEvents' => true,
            'timeMin' => date('c'),
        );
        return $this->service->events->listEvents($calendarId, $optParams);
    }

    /**
     * removing an event from Google Calendar
     * 
     * @return bool
     */
    public function removeEvent()
    {
        $request = new Request();
        if ($eventId =$request->get('delete')) {
            $this->service->events->delete('primary', $eventId);
            return true;
        }
        return false;
    }

    public function googleAutorization()
    {
        if ($access_token = $this->client->checkAuthorizationFile()) {
            $this->session->set('google_access_token', $access_token);
            redirect(base_url() . 'event');
        }
        redirect(base_url());
    }
}