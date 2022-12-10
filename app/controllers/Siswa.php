<?php 

class Siswa extends Controller {
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
        $_SESSION['filter_siswa'] = '';
        $data= array(
            'title' => 'Data Siswa',
            'menu' => 'themes/menu',
            'content' => 'siswa/index',
            'menu-open' => '1',
            'menu-active' => '#siswa',

        );
        $this->view('themes/template',$data);
    }

    public function input(){
        if ($_SESSION['role'] != 'superadmin') {
            $this->func->riderect('/panel');
        }
        $data = array(
            'title' => 'Data Siswa',
            'menu' => 'themes/menu',
            'content' => 'siswa/input',
            'menu-open' => '1',
            'menu-active' => '#siswa',

        );
        $this->view('themes/template',$data);
    }
}

 ?>