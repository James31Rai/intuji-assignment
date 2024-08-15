<?php 

namespace Core;

class Controller 
{
    public $session;
    public $sessionData = [];
    public $renderData = [];
    /**
     * Render a view file
     * 
     * @param mixed $view
     * @param mixed $data
     * @return void
     */
    function __construct() 
    {
        $this->session = new Session();
        // For status message | Alert message
        if (!empty($this->session->get('status_response'))) { 
            $status_response = $this->session->get('status_response'); 
            $this->sessionData['status'] = ($status_response['status'])?'success':'error'; 
            $this->sessionData['statusMsg'] = $status_response['status_msg'];
            // Remove status message from session
            $this->session->remove('status_response');
        }
    }

    protected function render(mixed $view) : void
    {
        extract($this->sessionData);
        extract($this->renderData);

        $session = $this->session;

        include('app/Views/layouts/header.php');
        include("app/Views/$view.php");
        include('app/Views/layouts/footer.php');
    }

    protected function setRenderData(string $title = '', string $page = '', Array $data = [])
    {
        $data['title'] = $title;
        $data['page'] = $page;
        $this->renderData = $data;
    }
}