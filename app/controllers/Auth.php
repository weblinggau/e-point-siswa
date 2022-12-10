<?php 
class Auth extends Controller {
    public function __construct()
    {
        $this->sandi = new Encrypt();
        $this->func = new Inc();
	    $this->model = $this->model('Model');

    }

    public function index(){
        if (isset($_SESSION['id_user'])) {
             $this->func->riderect('/panel');
        }
    	$this->view('auth/index');
    }

    public function logout(){
        session_destroy();
        $this->func->riderect('/auth');
    }

    public function user(){
        if ($_SESSION['role'] != 'superadmin') {
            $this->func->riderect('/panel');
        }
        if ($_SESSION['status'] == '1') {
            $this->func->riderect('/auth/password');
        }
        $data= array(
            'title' => 'Data User Login',
            'menu' => 'themes/menu',
            'content' => 'auth/user',
            'menu-open' => '1',
            'menu-active' => '#user',
        );
        $this->view('themes/template',$data);
    }

    public function password(){
        if (isset($_SESSION['id_user']) == false) {
             $this->func->riderect('/auth');
        }
        $data= array(
            'title' => 'Ubah Password',
            'menu' => 'themes/menu',
            'content' => 'auth/password',
            'menu-open' => '1',
            'menu-active' => '#password',
        );
        $this->view('themes/template',$data);
    }
}


 ?>