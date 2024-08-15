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

    /**
     * Render a view file
     * 
     * @param mixed $view
     * @return void
     */
    protected function render(mixed $view) : void
    {
        if ($view != 'home') {
            $this->checkAuthorization();
        }
        
        extract($this->sessionData);
        extract($this->renderData);

        $session = $this->session;

        include('app/Views/layouts/header.php');
        include("app/Views/$view.php");
        include('app/Views/layouts/footer.php');
    }

    /**
     * set render data
     * 
     * @param string $title
     * @param string $page
     * @param array $data
     * @return void
     */
    protected function setRenderData(string $title = '', string $page = '', Array $data = [])
    {
        $data['title'] = $title;
        $data['page'] = $page;
        $this->renderData = $data;
    }

    /**
     * check for authorization for access token
     * 
     * @return bool
     */
    public function checkAuthorization()
    {
        if ($this->session->has('google_access_token') && !empty($this->session->get('google_access_token'))) { 
            return true;
        } else {
            redirect(base_url());
        }
    }

}