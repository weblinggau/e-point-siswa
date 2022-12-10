<?php 
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class Api extends Controller {
    public function __construct()
    {
        $this->sandi = new Encrypt();
        $this->func = new Inc();
        $this->model = $this->model('Model');
        // if (isset($_SESSION['id_user']) == false) {
        //  $this->func->riderect('/auth');
        // }
    }

    public function index(){
        $joke = array(
            'status' => 'error',
            'pesan' => 'anda berada di path yang salah.!'
            );
        echo json_encode($joke);
    }

    public function auth(){
        $json = file_get_contents('php://input');
        $input = $this->func->cryptoJsAesDecrypt(KEY,$json);
        if($input['action'] == 'auth'){
            if (isset($_SESSION['id_user'])) {
                $res = array(
                    'status' => 'error',
                    'pesan' => 'Terjadi kesalahan saat mengirim parameter'
                );
            }
            $username = $this->func->filter(2,$input['username']);
            $password = sha1($input['password']);

            $array = array(
                'username' => $username,
                'password' => $password
            );

            $valuser = $this->model->login($array,'user');
            if ($valuser > 0) {
                $valpass = $this->model->login($array,'password');
                if ($valpass > 0) {
                    $data = $this->model->login($array,'data');
                    $_SESSION['id_user'] = $this->sandi->kunci($data['id_user']);
                    $_SESSION['role'] = $data['role_user'];
                    $_SESSION['status'] = $data['status'];
                    $joke = array(
                        'status' => 'sukses',
                        'href' => BASEURL.('/panel'),
                        'pesan' => 'Login berhasil, anda akan diarahkan ke halaman dashboard'
                     );
                }else{
                    $joke = array(
                        'status' => 'error',
                        'pesan' => 'Password yang anda masukan salah, masukan password yang benar !'
                     );
                }
            }else{
                $joke = array(
                    'status' => 'error',
                    'pesan' => 'Username tidak ditemukan, coba login lagi'
                );
            }
            
            $res = $this->func->cryptoJsAesEncrypt(KEY, $joke);
        // akhir fungsi auth login
        }else{
            $res = array(
                'status' => 'error',
                'pesan' => 'Permintaan server salah, coba lagi !'
            );
        }
        echo json_encode($res);
    }

    public function userlist(){
        if (isset($_SESSION['id_user']) == false) {
            $res = array(
                    'status' => 'error',
                    'pesan' => 'Permintaan server salah, coba lagi !'
            );

            echo json_encode($res);
            exit();
        }
            if ($_SESSION['role'] != 'superadmin') {
               $res = array(
                    'status' => 'error',
                    'pesan' => 'Permintaan server salah, coba lagi !'
                );
            }else{
                $start = $_POST['start'];
                $fh = $_POST['length'];
                $push = array(
                    'start' => $start,
                    'fh' => $fh,
                    'cari' => $_POST['search']['value']
                );
                if ($_POST['search']['value'] != '') {
                    $data = $this->model->getUser($push,'cari');
                    $dat = $this->model->getUser($push,'total');
                }else{
                    $data = $this->model->getUser($push,'data');
                    $dat = $this->model->getUser($push,'total');
                }
                    if (empty($data)) {
                        $jumlah = 0;
                        $datas[] = array('','','','','');
                    }else{
                        $jumlah = count($dat);
                        $no = 1+$start;
                        foreach ($data as $temp) {
                            $datas[] = array(
                                $no++,
                                $temp['nama_user'],
                                $temp['username'],
                                $temp['role_user'],
                                '<button id="hapus" iduser="'.$temp['id_user'].'" type="button" class="btn btn-danger btn-sm"><i class="fa fa-trash" ></i></button>
                                <button data-toggle="modal" data-target="#edituser" iduser="'.$temp['id_user'].'" type="button" class="btn btn-success btn-sm"><i class="fa fa-user" ></i></button>
                                '
                            );
                        }
                    }
                $res = array(
                    'draw' => $_POST['draw'],
                    'recordsTotal' => $jumlah,
                    'recordsFiltered' => $jumlah,
                    'data' => $datas,
                );
            }
        echo json_encode($res);     
    }

    public function kelaslist(){
        if (isset($_SESSION['id_user']) == false) {
            $res = array(
                    'status' => 'error',
                    'pesan' => 'Permintaan server salah, coba lagi !'
            );

            echo json_encode($res);
            exit();
        }
            if ($_SESSION['role'] == 'kepsek') {
               $res = array(
                    'status' => 'error',
                    'pesan' => 'Permintaan server salah, coba lagi !'
                );
            }else{
                $start = $_POST['start'];
                $fh = $_POST['length'];
                $push = array(
                    'start' => $start,
                    'fh' => $fh,
                    'cari' => $_POST['search']['value']
                );
                if ($_POST['search']['value'] != '') {
                    $data = $this->model->getKelas($push,'cari');
                    $dat = $this->model->getKelas($push,'total');
                }else{
                    $data = $this->model->getKelas($push,'data');
                    $dat = $this->model->getKelas($push,'total');
                }
                    if (empty($data)) {
                        $jumlah = 0;
                        $datas[] = array('','','');
                    }else{
                        $jumlah = count($dat);
                        $no = 1+$start;
                        foreach ($data as $temp) {
                            $datas[] = array(
                                $no++,
                                $temp['nama_kelas'],
                                '<button id="hapus" idkelas="'.$temp['id_kelas'].'" type="button" class="btn btn-danger btn-sm"><i class="fa fa-trash" ></i></button>
                                <button data-toggle="modal" data-target="#editkelas" idkelas="'.$temp['id_kelas'].'" type="button" class="btn btn-success btn-sm"><i class="fa fa-user" ></i></button>
                                '
                            );
                        }
                    }
                $res = array(
                    'draw' => $_POST['draw'],
                    'recordsTotal' => $jumlah,
                    'recordsFiltered' => $jumlah,
                    'data' => $datas,
                );
            }
        echo json_encode($res);     
    }

    public function pelanggaranlist(){
        if (isset($_SESSION['id_user']) == false) {
            $res = array(
                    'status' => 'error',
                    'pesan' => 'Permintaan server salah, coba lagi !'
            );

            echo json_encode($res);
            exit();
        }
            if ($_SESSION['role'] != 'superadmin') {
               $res = array(
                    'status' => 'error',
                    'pesan' => 'Permintaan server salah, coba lagi !'
                );
            }else{
                $start = $_POST['start'];
                $fh = $_POST['length'];
                $push = array(
                    'start' => $start,
                    'fh' => $fh,
                    'cari' => $_POST['search']['value']
                );
                if ($_POST['search']['value'] != '') {
                    $data = $this->model->getPelanggaran($push,'cari');
                    $dat = $this->model->getPelanggaran($push,'total');
                }else{
                    $data = $this->model->getPelanggaran($push,'data');
                    $dat = $this->model->getPelanggaran($push,'total');
                }
                    if (empty($data)) {
                        $jumlah = 0;
                        $datas[] = array('','','','');
                    }else{
                        $jumlah = count($dat);
                        $no = 1+$start;
                        foreach ($data as $temp) {
                            $datas[] = array(
                                $no++,
                                $temp['nama_pelanggaran'],
                                $temp['point_pelanggaran'],
                                '<button id="hapus" idpelang="'.$temp['id_pelanggaran'].'" type="button" class="btn btn-danger btn-sm"><i class="fa fa-trash" ></i></button>
                                <button data-toggle="modal" data-target="#editpelanggaran" idpelang="'.$temp['id_pelanggaran'].'" type="button" class="btn btn-success btn-sm"><i class="fa fa-user" ></i></button>
                                '
                            );
                        }
                    }
                $res = array(
                    'draw' => $_POST['draw'],
                    'recordsTotal' => $jumlah,
                    'recordsFiltered' => $jumlah,
                    'data' => $datas,
                );
            }
        echo json_encode($res);     
    }

    public function siswalist(){
        if (isset($_SESSION['id_user']) == false) {
            $res = array(
                    'status' => 'error',
                    'pesan' => 'Permintaan server salah, coba lagi !'
            );

            echo json_encode($res);
            exit();
        }
                $start = $_POST['start'];
                $fh = $_POST['length'];
                $push = array(
                    'start' => $start,
                    'fh' => $fh,
                    'cari' => $_POST['search']['value']
                );
                if ($_POST['search']['value'] != '') {
                    $data = $this->model->getSiswaList($push,'cari');
                    $dat = $this->model->getSiswaList($push,'total');
                }else{
                    $data = $this->model->getSiswaList($push,'data');
                    $dat = $this->model->getSiswaList($push,'total');
                }
                    if (empty($data)) {
                        $jumlah = 0;
                        $datas[] = array('','','','','','','','');
                    }else{
                        $jumlah = count($dat);
                        $no = 1+$start;
                        foreach ($data as $temp) {
                            if ($_SESSION['role'] == 'guru' || $_SESSION['role'] == 'guru') {
                                $action = '';
                            }else{
                                $action = '<button id="hapus" idsiswas="'.$temp['id_siswa'].'" type="button" class="btn btn-danger btn-sm"><i class="fa fa-trash" ></i></button>
                                <button data-toggle="modal" data-target="#editsiswa" idsiswa="'.$temp['id_siswa'].'" type="button" class="btn btn-success btn-sm"><i class="fa fa-edit" ></i></button>
                                ';
                            }
                            $datas[] = array(
                                $no++,
                                $temp['nama_siswa'],
                                $temp['nis'],
                                $temp['nama_kelas'],
                                $this->getJmlPelanggar($temp['id_siswa'],'jumlah'),
                                $this->getJmlPelanggar($temp['id_siswa'],'total'),
                                '<button data-toggle="modal" data-target="#detail" idsiswa="'.$temp['id_siswa'].'" type="button" class="btn btn-info btn-sm"><i class="fa fa-eye" ></i></button>',
                                $action
                            );
                        }
                    }
                $res = array(
                    'draw' => $_POST['draw'],
                    'recordsTotal' => $jumlah,
                    'recordsFiltered' => $jumlah,
                    'data' => $datas,
                );
        echo json_encode($res);     
    }

    public function inputsiswa(){
                if (isset($_SESSION['id_user']) == false) {
                    $res = array(
                            'status' => 'error',
                            'pesan' => 'Permintaan server salah, coba lagi !'
                    );

                    echo json_encode($res);
                    exit();
                }
                if ($_SESSION['role'] != 'superadmin') {
                   $res = array(
                        'status' => 'error',
                        'pesan' => 'Permintaan server salah, coba lagi !'
                    );
                   echo json_encode($res);
                    exit();
                }
                $start = $_POST['start'];
                $fh = $_POST['length'];
                $push = array(
                    'start' => $start,
                    'fh' => $fh,
                    'cari' => $_POST['search']['value']
                );
                if ($_POST['search']['value'] != '') {
                    $data = $this->model->getSiswaInput($push,'cari');
                    $dat = $this->model->getSiswaInput($push,'total');
                }else{
                    $data = $this->model->getSiswaInput($push,'data');
                    $dat = $this->model->getSiswaInput($push,'total');
                }
                    if (empty($data)) {
                        $jumlah = 0;
                        $datas[] = array('','','','','');
                    }else{
                        $jumlah = count($dat);
                        $no = 1+$start;
                        foreach ($data as $temp) {
                            $datas[] = array(
                                $no++,
                                $temp['nama_siswa'],
                                $temp['nis'],
                                $temp['tahun_masuk'],
                                '<button id="hapus" idsiswa="'.$temp['id_siswa'].'" type="button" class="btn btn-danger btn-sm"><i class="fa fa-trash" ></i></button>
                                '
                            );
                        }
                    }
                $res = array(
                    'draw' => $_POST['draw'],
                    'recordsTotal' => $jumlah,
                    'recordsFiltered' => $jumlah,
                    'data' => $datas,
                );
        echo json_encode($res);     
    }

    private function getJmlPelanggar($id,$rule=''){
        $data = $this->model->GetRiwayatPelanggar($id);
        if ($rule == 'jumlah') {
            foreach ($data as $a) {
            $ar[] = $a['id_riwayat'];
            }
            if ($ar == '' ) {
                $b = 0;
            }else{
                $b = count($ar);
            }
            return $b;
        }elseif ($rule == 'total') {
            foreach ($data as $a) {
            $ar[] = $a['point_pelanggaran'];
            }
            if ($ar == '' ) {
                $b = 0;
            }else{
                $b = array_sum($ar);
            }

            return $b;
        }
    }

    public function ubahpassword(){
                if (isset($_SESSION['id_user']) == false) {
                    $res = array(
                            'status' => 'error',
                            'pesan' => 'Permintaan server salah, coba lagi !'
                    );

                    echo json_encode($res);
                    exit();
                }
                
        $json = file_get_contents('php://input');
        $input = $this->func->cryptoJsAesDecrypt(KEY,$json);
        if($input['action'] == 'ubahpassword'){
                $iduser = $this->sandi->Buka($_SESSION['id_user']);
                $array = array(
                    'passlama' => $input['passlama'],
                    'passbaru' => $input['passbaru'],
                );

                if ($array['passlama'] == '') {
                    $joke = array(
                        'status' => 'error',
                        'pesan' => 'Password lama harus dimasukan'
                    );
                }elseif ($array['passbaru'] == '') {
                    $joke = array(
                        'status' => 'error',
                        'pesan' => 'Password baru harus dimasukan'
                    );
                }else{
                    $data = array(
                        'passlama' => sha1($input['passlama']),
                        'passbaru' => sha1($input['passbaru']),
                    );

                    $val = $this->model->cekPass($data);
                    if ($val > 0) {
                        $this->model->UbahPassword($data,$iduser);
                         $joke = array(
                            'status' => 'sukses',
                            'pesan' => 'Password berhasil diubah, kamu akan diarahkn untuk login ulang',
                            'download' => BASEURL.('/auth/logout')
                        );
                    }else{
                        $joke = array(
                            'status' => 'error',
                            'pesan' => 'Password lama yang kamu masukan salah coba lagi'
                        );
                    }
                }
            $res = $this->func->cryptoJsAesEncrypt(KEY, $joke);
        } 
        echo json_encode($res);
    }

    public function user(){
        if (isset($_SESSION['id_user']) == false) {
            $res = array(
                'status' => 'error',
                'pesan' => 'Permintaan server salah, coba lagi !'
            );

            echo json_encode($res);
            exit();
        }
                
        if ($_SESSION['role'] != 'superadmin') {
            $res = array(
                'status' => 'error',
                'pesan' => 'Permintaan server salah, coba lagi !'
            );
        }else{
            $json = file_get_contents('php://input');
            $input = $this->func->cryptoJsAesDecrypt(KEY,$json);
             if($input['action'] == 'tambah'){
                $data = array(
                    'nama_user' => $this->func->filter('2',$input['nama']),
                    'username' => $this->func->filter('2',$input['username']),
                    'role_user' => $this->func->filter('2',$input['role']),
                    'password' => sha1($input['password'])
                );
                $cekVal = $this->model->validasiUser($data['username']);
                if ($cekVal > 0) {
                    $joke = array(
                        'status' => 'error',
                        'pesan' => "Gagal ditambahkan, username sudah ada di system silahkan gunakan username lain"
                    );
                }else{
                    $this->model->addUser($data);
                    $joke = array(
                        'status' => 'sukses',
                        'pesan' => "User berhasil di tambahkan "
                    );
                }
                
             }elseif ($input['action'] == 'hapus') {
                $this->model->hapusUser($this->func->filter('2',$input['iduser']));
                $joke = array(
                        'status' => 'sukses',
                        'pesan' => "Data berhasil dihapus"
                );
             }elseif ($input['action'] == 'praedit') {
                 $iduser = $this->func->filter('2',$input['id']);
                 $data = $this->model->UserGetData($iduser);
                 if ($data['role_user'] == 'superadmin') {
                     $userRole = '<option value="superadmin">Superadmin</option>
                            <option value="guru">Guru</option>
                            <option value="kepsek">Kepala Sekolah</option>';
                 }elseif ($data['role_user'] == 'guru') {
                     $userRole = '<option value="guru">Guru</option>
                            <option value="superadmin">Superadmin</option>
                            <option value="kepsek">Kepala Sekolah</option>';
                 }elseif ($data['role_user'] == 'kepsek') {
                     $userRole = '<option value="kepsek">Kepala Sekolah</option>
                            <option value="superadmin">Superadmin</option>
                            <option value="guru">Guru</option>
                            ';
                 }
                 $content = '
                    <div class="row">
                      <div class="col-lg-6">
                        <div class="form-group">
                          <label>Nama</label>
                          <input type="hidden" id="iduserEdit" value="'.$data['id_user'].'">
                          <input type="text" class="form-control" id="namaEdit" value="'.$data['nama_user'].'" required>
                        </div>
                      </div>
                      <div class="col-lg-6">
                        <div class="form-group">
                          <label>Username</label>
                          <input type="text" class="form-control" id="usernameEdit" value="'.$data['username'].'" disabled>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-lg-6">
                          <label>Role User</label>
                          <select class="form-control" id="roleEdit">
                            '.$userRole.'
                          </select>
                      </div>
                       <div class="col-lg-6">
                          <label>Password</label>
                          <input type="text" class="form-control" id="passwordEdit" required disabled>
                      </div>
                    </div>
                 ';

                 $joke = array(
                        'status' => 'sukses',
                        'pesan' => "Data berhasil dihapus ",
                        'content' => $content
                );
                 // var_dump($data);
            }elseif ($input['action'] == 'updateUser') {
                $dataEdit = array(
                    'iduser' => $this->func->filter('2',$input['iduser']),
                    'nama' => $this->func->filter('2',$input['nama']),
                    'role' => $this->func->filter('2',$input['role'])
                );
                if ($input['password'] == '') {
                    $this->model->UpdateUser($dataEdit,'psn');
                }else{
                    $password = sha1($input['password']);
                    $this->model->UpdateUser($dataEdit,'psa',$password);
                }
                $joke = array(
                        'status' => 'sukses',
                        'pesan' => "Data berhasil diubah ".$dataEdit['nama'],
                );
            }
             $res = $this->func->cryptoJsAesEncrypt(KEY, $joke);
        }
        echo json_encode($res);
    }

    public function kelas(){
        if (isset($_SESSION['id_user']) == false) {
            $res = array(
                'status' => 'error',
                'pesan' => 'Permintaan server salah, coba lagi !'
            );

             echo json_encode($res);
            exit();
        }
        if ($_SESSION['role'] != 'superadmin') {
            $res = array(
                'status' => 'error',
                'pesan' => 'Permintaan server salah, coba lagi !'
            );
        }else{
            $json = file_get_contents('php://input');
            $input = $this->func->cryptoJsAesDecrypt(KEY,$json);
             if($input['action'] == 'tambah'){
                $data = array(
                    'nama_kelas' => $this->func->filter('2',$input['nama'])
                );
                $cekVal = $this->model->validasiKelas($data['nama_kelas']);
                if ($cekVal > 0) {
                    $joke = array(
                        'status' => 'error',
                        'pesan' => "Gagal ditambahkan, nama kelas sudah ada di system silahkan gunakan nama kelas lain"
                    );
                }else{
                    $this->model->addKelas($data);
                    $joke = array(
                        'status' => 'sukses',
                        'pesan' => "Data kelas berhasil di tambahkan "
                    );
                }
                
             }elseif ($input['action'] == 'hapus') {
                $this->model->hapuskelas($this->func->filter('2',$input['idkelas']));
                $joke = array(
                        'status' => 'sukses',
                        'pesan' => "Data berhasil dihapus"
                );
             }elseif ($input['action'] == 'praedit') {
                 $iduser = $this->func->filter('2',$input['id']);
                 $data = $this->model->getKelasId($iduser);
                 $content = '
                        <div class="form-group">
                          <label>Nama Kelas</label>
                          <input type="hidden" id="idKelas" value="'.$data['id_kelas'].'">
                          <input type="text" class="form-control" id="namaKelas" value="'.$data['nama_kelas'].'" required>
                        </div>
                 ';

                 $joke = array(
                        'status' => 'sukses',
                        'pesan' => "Data berhasil dihapus ",
                        'content' => $content
                );
                 // var_dump($data);
            }elseif ($input['action'] == 'updateKelas') {
                $dataEdit = array(
                    'id_kelas' => $this->func->filter('2',$input['idkelas']),
                    'nama_kelas' => $this->func->filter('2',$input['nama'])
                );
                $this->model->UpdateKelas($dataEdit);
                $joke = array(
                        'status' => 'sukses',
                        'pesan' => "Data berhasil diubah ",
                );
            }
             $res = $this->func->cryptoJsAesEncrypt(KEY, $joke);
        }
        echo json_encode($res);
    }


    public function pelanggaran(){
        if (isset($_SESSION['id_user']) == false) {
            $res = array(
                'status' => 'error',
                'pesan' => 'Permintaan server salah, coba lagi !'
            );

            echo json_encode($res);
            exit();
        }
                
        if ($_SESSION['role'] == 'kepsek') {
            $res = array(
                'status' => 'error',
                'pesan' => 'Permintaan server salah, coba lagi !'
            );
        }else{
            $json = file_get_contents('php://input');
            $input = $this->func->cryptoJsAesDecrypt(KEY,$json);
             if($input['action'] == 'tambah'){
                if ($_SESSION['role'] != 'superadmin') {
                    $res = array(
                        'status' => 'error',
                        'pesan' => 'Permintaan server salah, coba lagi !'
                    );
                    echo json_encode($res);
                    exit();
                }
                $data = array(
                    'nama' => $this->func->filter('2',$input['nama']),
                    'point' => $this->func->filter('2',$input['point'])
                );
                $cekVal = $this->model->validasiPelanggaran($data['nama']);
                if ($cekVal > 0) {
                    $joke = array(
                        'status' => 'error',
                        'pesan' => "Gagal ditambahkan, nama pelanggaran sudah ada di system silahkan gunakan nama pelanggaran lain"
                    );
                }else{
                    $this->model->addPelanggaran($data);
                    $joke = array(
                        'status' => 'sukses',
                        'pesan' => "nama pelanggaran berhasil di tambahkan "
                    );
                }
                
             }elseif ($input['action'] == 'hapus') {
                if ($_SESSION['role'] != 'superadmin') {
                    $res = array(
                        'status' => 'error',
                        'pesan' => 'Permintaan server salah, coba lagi !'
                    );
                    echo json_encode($res);
                    exit();
                }

                $this->model->hapuspelanggaran($this->func->filter('2',$input['idpelang']));
                $joke = array(
                        'status' => 'sukses',
                        'pesan' => "Data berhasil dihapus"
                );
             }elseif ($input['action'] == 'praedit') {
                if ($_SESSION['role'] != 'superadmin') {
                    $res = array(
                        'status' => 'error',
                        'pesan' => 'Permintaan server salah, coba lagi !'
                    );
                    echo json_encode($res);
                    exit();
                }
                 $idpelang = $this->func->filter('2',$input['id']);
                 $data = $this->model->getPelanggaranId($idpelang);
                 $content = '
                        <div class="row">
                          <div class="col-lg-6">
                            <div class="form-group">
                              <label>Nama Pelanggaran</label>
                              <input type="hidden" id="idPelanggar" value="'.$data['id_pelanggaran'].'">
                              <input type="text" class="form-control" id="namaPelang" value="'.$data['nama_pelanggaran'].'" required>
                            </div>
                          </div>
                          <div class="col-lg-6">
                            <div class="form-group">
                              <label>Skor Pelanggaran</label>
                              <input type="number" class="form-control" id="pointPelang" value="'.$data['point_pelanggaran'].'" >
                            </div>
                          </div>
                        </div>
                 ';

                 $joke = array(
                        'status' => 'sukses',
                        'pesan' => "Data berhasil dihapus ",
                        'content' => $content
                );
            }elseif ($input['action'] == 'updatePelanggaran') {
                if ($_SESSION['role'] != 'superadmin') {
                    $res = array(
                        'status' => 'error',
                        'pesan' => 'Permintaan server salah, coba lagi !'
                    );
                    echo json_encode($res);
                    exit();
                }
                $dataEdit = array(
                    'nama_pelanggaran' => $this->func->filter('2',$input['nama']),
                    'point_pelanggaran' => $this->func->filter('2',$input['point']),
                );
                $id = $this->func->filter('2',$input['idpelanggar']);
                $a = $this->model->UpdatePelanggaran($dataEdit,$id);
                $joke = array(
                        'status' => 'sukses',
                        'pesan' => "Data berhasil diubah ",
                );
            }elseif ($input['action'] == 'getSiswa') {
                $key = $this->func->filter('2',$input['keyword']);
                if ($key == '') {
                    $ar[] = '';
                }else{
                    $data = $this->model->GetSiswa($key);
                    foreach ($data as $keye) {
                        $ar[] = array('id' => $keye['id_siswa'],'text' => $keye['nama_siswa'].' '.$keye['nama_kelas']);
                    }
                }
                $joke = $ar;
            }elseif ($input['action'] == 'getPelanggaran') {
                $key = $this->func->filter('2',$input['keyword']);
                $data = $this->model->GetPelanggaranKey($key);
                foreach ($data as $keye) {
                    $ar[] = array('id' => $keye['id_pelanggaran'],'text' => $keye['nama_pelanggaran'].' (Point '.$keye['point_pelanggaran'].')');
                }
                $joke = $ar;
            }elseif ($input['action'] == 'tambahPoint') {
                $iduser = $this->sandi->Buka($_SESSION['id_user']);
                $data = array(
                    'id_siswa' => $this->func->filter('2',$input['nama']),
                    'id_pelanggaran' => $this->func->filter('2',$input['point']),
                    'catatan' => $this->func->filter('2',$input['catatan']),
                    'id_input' => $iduser,
                    'tanggal_pelanggaran' => date('Y-m-d')
                );
                if ($data['id_siswa'] == '') {
                    $joke = array(
                        'status' => 'error',
                        'pesan' => "Nama siswa tidak boleh kosong",
                    );
                }elseif ($data['id_pelanggaran'] == '') {
                    $joke = array(
                        'status' => 'error',
                        'pesan' => "Point pelanggaran harus di isi",
                    );
                }else{
                    $this->model->TambahPoint($data);
                    $joke = array(
                            'status' => 'sukses',
                            'pesan' => "Data berhasil ditambahkan ",
                    );
                }
                
            }
             $res = $this->func->cryptoJsAesEncrypt(KEY, $joke);
        }
        echo json_encode($res);
    }

    public function siswa(){
        if (isset($_SESSION['id_user']) == false) {
            $res = array(
                'status' => 'error',
                'pesan' => 'Permintaan server salah, coba lagi !'
            );

            echo json_encode($res);
            exit();
        }
            $json = file_get_contents('php://input');
            $input = $this->func->cryptoJsAesDecrypt(KEY,$json);
             if($input['action'] == 'tambah'){
                $data = array(
                    'nama_siswa' => $this->func->filter('2',$input['nama']),
                    'nis' => $this->func->filter('2',$input['nis']),
                    'id_input' => $this->sandi->Buka($_SESSION['id_user']),
                    'tahun_masuk' => $this->func->filter('2',$input['tahun']),
                    'status' => '1'
                );
                $this->model->addSiswa($data);
                $joke = array(
                    'status' => 'sukses',
                    'pesan' => "Data siswa berhasil di tambahkan "
                );
                
             }elseif ($input['action'] == 'hapus') {
                $this->model->hapusSiswa($this->func->filter('2',$input['idsiswa']));
                $joke = array(
                        'status' => 'sukses',
                        'pesan' => "Data berhasil dihapus"
                );
             }elseif ($input['action'] == 'praedit') {
                 $iduser = $this->func->filter('2',$input['id']);
                 $val = $this->model->ValSiswa($iduser);
                 if ($val > 0) {
                     $data = $this->model->GetsSiswaById($iduser);
                     $option = $this->model->GetKelasSiswa($data[0]['id_kelas']);
                     foreach ($option as $op) {
                         $ops .= '<option value="'.$op['id_kelas'].'">'.$op['nama_kelas'].'</option>';
                     }
                     $content = '
                            <div class="row">
                            <div class="col-lg-6">
                              <div class="form-group">
                                <label>Nama Siswa</label>
                                <input type="hidden" class="form-control" id="siswaEdit" value="'.$data[0]['id_siswa'].'">
                                <input type="text" class="form-control" id="namaSiswa" value="'.$data[0]['nama_siswa'].'">
                              </div>
                            </div>
                            <div class="col-lg-6">
                              <div class="form-group">
                                <label>NISN</label>
                                <input type="number" class="form-control" id="nisnSiswa" value="'.$data[0]['nis'].'">
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-lg-6">
                              <div class="form-group">
                                <label>Kelas</label>
                                <select class="form-control" id="kelasSiswa">
                                    <option value="'.$data[0]['id_kelas'].'">'.$data[0]['nama_kelas'].'</option>
                                    '.$ops.'
                                </select>
                              </div>
                            </div>
                            <div class="col-lg-6">
                              <div class="form-group">
                                <label>Tahun Masuk</label>
                                <input type="number" class="form-control" id="tahunSiswa" value="'.$data[0]['tahun_masuk'].'">
                              </div>
                            </div>
                          </div>
                     ';

                     $joke = array(
                            'status' => 'sukses',
                            'pesan' => "Data berhasil diambil",
                            'content' => $content
                    );
                 }else{
                    $joke = array(
                        'status' => 'error',
                        'pesan' => "Data tidak ditemukan"
                    );
                 }
                 // var_dump($data);
            }elseif ($input['action'] == 'updateSiswa') {
                $dataEdit = array(
                    'nama_siswa' => $this->func->filter('2',$input['nama']),
                    'id_kelas' => $this->func->filter('2',$input['kelas']),
                    'nis' => $this->func->filter('2',$input['nis']),
                    'tahun_masuk' => $this->func->filter('2',$input['tahun']),
                );

                $id = array('id_siswa' => $this->func->filter('2',$input['idsiswa']), );
                $val = $this->model->ValSiswa($id['id_siswa']);
                if ($val > 0) {
                    $this->model->UpdateSiswa($dataEdit,$id);
                     $joke = array(
                        'status' => 'sukses',
                        'pesan' => "Data berhasil diedit",
                    );
                }else{
                    $joke = array(
                        'status' => 'error',
                        'pesan' => "Data tidak ditemukan",
                    );
                }
                
                
            }elseif ($input['action'] == 'getkelas') {
                $data = $this->model->GetKelasAll();
                $content .= '<option value="0">pilih kelas</option>';
                foreach ($data as $k) {
                    $content.='<option value="'.$k['id_kelas'].'">'.$k['nama_kelas'].'</option>';
                }
                $joke = array(
                        'status' => 'sukses',
                        'content' => $content,
                        'pesan' => "Data berhasil diambil",
                );
            }elseif ($input['action'] == 'filterAdd') {
                $_SESSION['filter_siswa'] = array('kelas' => $this->func->filter('2',$input['keyword']));
                $joke = array(
                        'status' => 'sukses',
                        'pesan' => "Data berhasil diambil",
                );
            }elseif ($input['action'] == 'detail') {
                $id = $this->func->filter('2',$input['id']);
                $val = $this->model->ValSiswa($id);
                if ($val > 0) {
                    $datasiswa = $this->model->GetsSiswaById($id);
                    $datapelanggran = $this->model->GetPelanggaranSiswa($id);
                    $no = 1;
                    $content.= '
                            <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Nama Siswa</label>
                            <div class="col-sm-10">
                              <input type="text" class="form-control" value="'.$datasiswa[0]['nama_siswa'].'">
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-sm-2 col-form-label">NISN</label>
                            <div class="col-sm-10">
                              <input type="text" class="form-control" value="'.$datasiswa[0]['nis'].'">
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Kelas</label>
                            <div class="col-sm-10">
                              <input type="text" class="form-control" value="'.$datasiswa[0]['nama_kelas'].'">
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Tahun Masuk</label>
                            <div class="col-sm-10">
                              <input type="text" class="form-control" value="'.$datasiswa[0]['tahun_masuk'].'">
                            </div>
                          </div>
                          <div class="text-center"><p>Detail Pelanggaran</p></div>
                          <div>
                            <table class="table table-bordered">
                              <thead>                  
                                <tr>
                                  <th style="width: 10px">No</th>
                                  <th>Nama Pelanggaran</th>
                                  <th>Pemberi Skor</th>
                                  <th style="width: 40px">Skor</th>
                                </tr>
                              </thead>
                              <tbody>
                    ';

                    if (empty($datapelanggran)) {
                        $content .= '
                            <tr>
                                <td colspan="4" class="text-center">Data Pelanggaran Kosong</td>
                            </tr>
                        ';

                    }else{

                        foreach ($datapelanggran as $p) {
                            $content .= '
                                <tr>
                                  <td>'.$no++.'</td>
                                  <td>'.$p['nama_pelanggaran'].'</td>
                                  <td>'.$p['nama_user'].'</td>
                                  <td>'.$p['point_pelanggaran'].'</td>
                                </tr>
                            ';
                        }
                    }

                    $content.='
                        </tbody>
                          <tfoot>
                            <tr>
                              <td  colspan="3" class="text-center"> Total Skor</td>
                              <td>'.$this->getJmlPelanggar($datasiswa[0]['id_siswa'],'total').'</td>
                            </tr>
                          </tfoot>
                        </table>
                      </div>
                    ';
                    $joke = array(
                        'status' => 'sukses',
                        'content' => $content,
                        'pesan' => "Data berhasil diambil",
                    );
                    
                }else{
                    $joke = array(
                        'status' => 'error',
                        'pesan' => "Data tidak ditemukan",
                    );

                }
            }elseif ($input['action'] == 'download'){
                    $data = $this->model->getSiswaList($push,'data');
                    if (empty($data)) {
                        $joke = array(
                            'status' => 'error',
                            'pesan' => "Data pada filter ini kosong, silahkan filter data lain",
                        );
                    }else{
                        $spreadsheet = new Spreadsheet();
                        $sheet = $spreadsheet->getActiveSheet();
                        $sheet->setCellValue('A1', 'No');
                        $sheet->setCellValue('B1', 'Nama Siswa');
                        $sheet->setCellValue('C1', 'NISN');
                        $sheet->setCellValue('D1', 'Kelas');
                        $sheet->setCellValue('E1', 'Jumlah Pelanggaran');
                        $sheet->setCellValue('F1', 'Total Skor Pelangaran');
                        $no = 2;
                        $nos = 1;
                        foreach ($data as $iv) {
                            $cel = $no++;
                            $sheet->setCellValue('A'.$cel, $nos++);
                            $sheet->setCellValue('B'.$cel, $iv['nama_siswa']);
                            $sheet->setCellValue('C'.$cel, $iv['nis']);
                            $sheet->setCellValue('D'.$cel, $iv['nama_kelas']);
                            $sheet->setCellValue('E'.$cel, $this->getJmlPelanggar($iv['id_siswa'],'jumlah'));
                            $sheet->setCellValue('F'.$cel, $this->getJmlPelanggar($iv['id_siswa'],'total'));
                        }
                        $writer = new Xlsx($spreadsheet);
                        $aa = 'public/upload/siswa'.date('y-m-d-i').'.xlsx';
                        $writer->save($aa);
                        $joke = array(
                                'status' => 'sukses',
                                'pesan' => 'Data Berhasil di export dan akan di download',
                                'download' => BASEURL.'/'.$aa
                        );
                    }
            }elseif ($input['action'] == 'upload'){
                $data = $this->model->TotalDataSiswa();
                if (empty($data)) {
                    $joke = array(
                        'status' => 'error',
                        'pesan' => 'Data kosong, silahkan tambahkan terlebih dahulu',
                    );
                }else{
                    $kelas = $this->func->filter('2',$input['kelas']);
                    if ($kelas == 0) {
                        $joke = array(
                            'status' => 'error',
                            'pesan' => 'Data kelas harus diisi dahulu',
                        );
                    }else{
                        foreach ($data as $up) {
                            $ar = array(
                                'id_kelas' => $kelas,
                                'status' => '0'
                            );
                            $id = array('id_siswa' => $up['id_siswa']);
                            $this->model->UploadSiswa($ar,$id);
                        }
                        $joke = array(
                            'status' => 'sukses',
                            'pesan' => 'Data berhasil di upload',
                        );
                    }
                }
            }elseif ($_POST['action'] == 'import') {
                    $allowedFileType = [
                    'application/vnd.ms-excel',
                    'text/xls',
                    'text/xlsx',
                    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
                ];
                if (in_array($_FILES["file"]["type"], $allowedFileType)) {
                    $this->exel = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                    $spreadSheet = $this->exel->load($_FILES['file']['tmp_name']);
                    $excelSheet = $spreadSheet->getActiveSheet();
                    $spreadSheetAry = $excelSheet->toArray();
                    $sheetCount = count($spreadSheetAry);
                    $iduser = $this->sandi->Buka($_SESSION['id_user']);
                    for ($i = 1; $i <= $sheetCount; $i ++) {
                        $nama = $spreadSheetAry[$i][1];
                        $nis = $spreadSheetAry[$i][2];
                        $tahun = $spreadSheetAry[$i][3];
                        if ($nama != '') {
                            $arra = array(
                                'nama_siswa' => $this->func->filter('2',$nama),
                                'nis' => $this->func->filter('2',$nis),
                                'tahun_masuk' => $this->func->filter('2',$tahun),
                                'id_input' => $iduser,
                                'status' => '1'
                            );
                            $this->model->addSiswa($arra);
                        }   
                    }
                    $joke = array(
                            'status' => 'sukses',
                            'pesan' => 'Data berhasil di import'
                    );
                }else{
                    $joke = array(
                            'status' => 'error',
                            'pesan' => 'Format file bukan ms.excel silahkan upload ulang !'
                    );
                }
            }
        $res = $this->func->cryptoJsAesEncrypt(KEY, $joke);
        echo json_encode($res);
    }

    public function panel(){
        if (isset($_SESSION['id_user']) == false) {
            $res = array(
                'status' => 'error',
                'pesan' => 'Permintaan server salah, coba lagi !'
            );

            echo json_encode($res);
            exit();
        }
            $json = file_get_contents('php://input');
            $input = $this->func->cryptoJsAesDecrypt(KEY,$json);
            if($input['action'] == 'wid2'){
                $data = $this->widget1();
                $no = 1;
                foreach ($data as $wd) {
                    $content .= '
                        <tr>
                            <td>'.$no++.'</td>
                            <td>'.$wd['nama_siswa'].'</td>
                            <td>'.$wd['jumlah'].'</td>
                        </tr>
                    ';
                }
                $joke = array(
                            'status' => 'sukses',
                            'content' => $content
                );
            }elseif ($input['action'] == 'wid1') {
                $data = $this->widget2();
                $no = 1;
                foreach ($data as $wd) {
                    $content .= '
                        <tr>
                            <td>'.$no++.'</td>
                            <td>'.$wd['nama_siswa'].'</td>
                            <td>'.$wd['total'].'</td>
                        </tr>
                    ';
                }
                $joke = array(
                            'status' => 'sukses',
                            'content' => $content
                );
            }
        $res = $this->func->cryptoJsAesEncrypt(KEY, $joke);
        echo json_encode($res);
    }

    private function widget1(){
        $a = $this->model->GetRiwayat();
        foreach ($a as $k) {
            $b[] = $k['id_siswa'];
        }
        $c = array_count_values($b);
        $x = $c; arsort($x);
        $d = array_keys($x);
        foreach ($d as $a) {
            $hasil[]= array(
                'nama_siswa' => $this->model->GetRiwayatNama($a)['nama_siswa'], 
                'jumlah' => $this->getJmlPelanggar($a,'jumlah')
            );
            if(++$i > 4)
            break;
        }
        return $hasil;
    }

    private function widget2(){
        $a = $this->model->GetRiwayat();
        foreach ($a as $k) {
            $b[] = $k['id_siswa'];
        }
        $c = array_count_values($b);
        $d = array_keys($c);
        foreach ($d as $a) {
            $e[] = array(
                'id_siswa' => $a,
                'total' => $this->getJmlPelanggar($a,'total')
            );
        }

        foreach ($e as $key => $row) {
            $total[$key]  = $row['total'];
        }
        array_multisort($total, SORT_DESC, $e);
        foreach ($e as $k) {
            $hasil[] = array(
                'nama_siswa' => $this->model->GetRiwayatNama($k['id_siswa'])['nama_siswa'],
                'total' => $k['total'] 
            );
            if(++$i > 4)
            break;
        }

        return $hasil;
    }

}

 ?>