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
        $this->setRenderData('Home', 'home');
        $this->render('home',);  
    }

    public function test()
    {
        echo "testing more page";
    }
    
}
