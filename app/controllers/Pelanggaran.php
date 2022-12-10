<?php 

class Pelanggaran extends Controller {
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
            'title' => 'Managment Pelanggaran',
            'menu' => 'themes/menu',
            'content' => 'pelanggaran/index',
            'menu-open' => '1',
            'menu-active' => '#pelanggaran',

        );
        $this->view('themes/template',$data);
    }

    public function input(){
        if ($_SESSION['role'] == 'kepsek') {
            $this->func->riderect('/panel');
        }
        $data= array(
            'title' => 'Managment Pelanggaran',
            'menu' => 'themes/menu',
            'content' => 'pelanggaran/input',
            'menu-open' => '1',
            'menu-active' => '#input',

        );
        $this->view('themes/template',$data);
    }
}

 ?>