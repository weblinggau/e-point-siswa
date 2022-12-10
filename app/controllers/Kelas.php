<?php 

class Kelas extends Controller {
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
        if ($_SESSION['role'] != 'superadmin') {
            $this->func->riderect('/panel');
        }
        $data= array(
            'title' => 'Managment Kelas',
            'menu' => 'themes/menu',
            'content' => 'kelas/index',
            'menu-open' => '1',
            'menu-active' => '#kelas',

        );
        $this->view('themes/template',$data);
    }
}

 ?>