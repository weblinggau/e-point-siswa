<?php 

class Panel extends Controller {
    public function __construct()
    {
        $this->sandi = new Encrypt();
        $this->func = new Inc();
	    $this->model = $this->model('Model');
	    if (isset($_SESSION['id_user']) == false) {
            $this->func->riderect('/auth');
        }
        if ($_SESSION['status'] == '1') {
            $this->func->riderect('/auth/password');
        }
	    
    }

    public function index(){
        $data= array(
            'title' => 'Panel Dashboard',
            'menu' => 'themes/menu',
            'content' => 'panel/index',
            'menu-open' => '1',
            'menu-active' => '#dashboard',

        );
        $this->view('themes/template',$data);
    }
}

 ?>