<?php 

namespace App\Controllers;

use Core\Controller;

class HomeController extends Controller 
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Starting Page
     * 
     * @return void
     */
    public function index() 
    {
        if (isset($_POST['authorizeSubmit'])) {
            redirect(base_url() . 'google_authorize');
        }
        if ($this->session->has('google_access_token') && !empty($this->session->get('google_access_token'))) {
            redirect(base_url() . 'event');
        }
        $this->setRenderData('Home', 'home');
        $this->render('home',);  
    }
    
}
