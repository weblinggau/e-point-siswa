<?php 
class Model {
    private $db;

    public function __construct()
    {
        $this->sandi = new Encrypt();
        $this->db = new Medoo([
        'database_type' => 'mysql',
        'database_name' => DB_NAME,
        'server' => DB_HOST,
        'username' => DB_USER,
        'password' => DB_PASS
        ]);

    }

    public function login($data,$rules){
        if ($rules == 'user') {
            $a = $this->db->select('db_user',[
                'id_user'
            ],[
                'username' => $data['username']
            ]);
            $b = count($a);
        }elseif ($rules == 'password') {
            $a = $this->db->select('db_user',[
                'id_user'
            ],[
                'username' => $data['username'],
                'password' => $data['password']
            ]);
            $b = count($a);
        }elseif ($rules == 'data') {
            $b = $this->db->get('db_user',[
                'id_user',
                'username',
                'nama_user',
                'role_user',
                'status',

            ],[
                'username' => $data['username'],
                'password' => $data['password']
            ]);
        }

        return $b;
    }

    public function validasiUser($data){
        $a = $this->db->select('db_user',[
            'id_user'
        ],[
            'username' => $data
        ]);

        $b = count($a);
        return $b;
    }

    public function getUser($data,$rule=''){
        $iduser = $this->sandi->Buka($_SESSION['id_user']);
        if ($rule == 'data') {
            $a = $this->db->select('db_user',[
                'id_user',
                'nama_user',
                'username',
                'role_user'
            ],[
                "ORDER" => [
                    'id_user' => "DESC"
                ],
                "LIMIT" => [$data['start'],$data['fh']]
            ]);

        }elseif ($rule == 'total') {
            $a = $this->db->select('db_user',[
                'id_user',
            ],[
                "ORDER" => [
                    'id_user' => "DESC"
                ],
            ]);
        }elseif ($rule == 'cari') {
             $a = $this->db->select('db_user',[
                'id_user',
                'nama_user',
                'username',
                'role_user'
            ],[
                "nama_user[~]" => $data['cari'],
                "ORDER" => [
                    'id_user' => "DESC"
                ]
            ]);
        }

        return $a;
    }

    public function UserGetData($id){
        $a = $this->db->get('db_user',[
            'id_user',
            'nama_user',
            'username',
            'role_user'
        ],[
            'id_user' => $id
        ]);

        return $a;
    }

    public function addUser($data){
        $a = $this->db->insert('db_user',[
            'nama_user' => $data['nama_user'],
            'username' => $data['username'],
            'password' => $data['password'],
            'role_user' => $data['role_user'],
            'status' => '1'
        ]);
        return;
    }

    public function hapusUser($data){
        $this->db->delete('db_user',[
            'id_user' => $data
        ]);
        return;
    }


    public function UpdateUser($data,$rule,$ps=''){
        if ($rule == 'psn') {
            $this->db->update('db_user',[
                'nama_user' => $data['nama'],
                'role_user' => $data['role']
            ],[
                'id_user' => $data['iduser']
            ]);
        }elseif ($rule == 'psa') {
            $this->db->update('db_user',[
                'nama_user' => $data['nama'],
                'role_user' => $data['role'],
                'password' => $ps,
                'status' => '1'
            ],[
                'id_user' => $data['iduser']
            ]);
        }
        return;
    }


    public function getKelas($data,$rule=''){
        if ($rule == 'data') {
            $a = $this->db->select('db_kelas',[
                'id_kelas',
                'nama_kelas'
            ],[
                "ORDER" => [
                    'id_kelas' => "DESC"
                ],
                "LIMIT" => [$data['start'],$data['fh']]
            ]);

        }elseif ($rule == 'total') {
            $a = $this->db->select('db_kelas',[
                'id_kelas',
            ],[
                "ORDER" => [
                    'id_kelas' => "DESC"
                ],
            ]);
        }elseif ($rule == 'cari') {
             $a = $this->db->select('db_kelas',[
                'id_kelas',
                'nama_kelas'
            ],[
                "nama_kelas[~]" => $data['cari'],
                "ORDER" => [
                    'id_kelas' => "DESC"
                ]
            ]);
        }

        return $a;
    }

    public function validasiKelas($data){
        $a = $this->db->select('db_kelas',[
            'id_kelas'
        ],[
            'nama_kelas' => $data
        ]);

        $b = count($a);
        return $b;
    }

    public function addKelas($data){
        $this->db->insert('db_kelas',[
            'nama_kelas' => $data['nama_kelas']
        ]);
        return;
    }

    public function hapuskelas($id){
        $this->db->delete('db_kelas',[
            'id_kelas' => $id
        ]);
        return;
    }

    public function getKelasId($id){
        $a = $this->db->get('db_kelas',[
            'id_kelas',
            'nama_kelas',
        ],[
            'id_kelas' => $id
        ]);

        return $a;
    }

    public function UpdateKelas($data){
        $this->db->update('db_kelas',[
                'nama_kelas' => $data['nama_kelas']
        ],[
                'id_kelas' => $data['id_kelas']
        ]);
        
        return;
    }

    public function getPelanggaran($data,$rule=''){
        if ($rule == 'data') {
            $a = $this->db->select('db_pelanggaran',[
                'id_pelanggaran',
                'nama_pelanggaran',
                'point_pelanggaran'
            ],[
                "ORDER" => [
                    'id_pelanggaran' => "DESC"
                ],
                "LIMIT" => [$data['start'],$data['fh']]
            ]);

        }elseif ($rule == 'total') {
            $a = $this->db->select('db_pelanggaran',[
                'id_pelanggaran',
            ],[
                "ORDER" => [
                    'id_pelanggaran' => "DESC"
                ],
            ]);
        }elseif ($rule == 'cari') {
             $a = $this->db->select('db_pelanggaran',[
                'id_pelanggaran',
                'nama_pelanggaran',
                'point_pelanggaran'
            ],[
                "nama_pelanggaran[~]" => $data['cari'],
                "ORDER" => [
                    'id_pelanggaran' => "DESC"
                ]
            ]);
        }

        return $a;
    }

    public function validasiPelanggaran($data){
        $a = $this->db->select('db_pelanggaran',[
            'id_pelanggaran'
        ],[
            'nama_pelanggaran' => $data
        ]);

        $b = count($a);
        return $b;
    }

    public function addPelanggaran($data){
        $this->db->insert('db_pelanggaran',[
            'nama_pelanggaran' => $data['nama'],
            'point_pelanggaran' => $data['point']
        ]);
        return;
    }

    public function hapuspelanggaran($id){
        $this->db->delete('db_pelanggaran',[
            'id_pelanggaran' => $id
        ]);
        return;
    }


    public function getPelanggaranId($id){
        $a = $this->db->get('db_pelanggaran',[
            'id_pelanggaran',
            'nama_pelanggaran',
            'point_pelanggaran',
        ],[
            'id_pelanggaran' => $id
        ]);

        return $a;
    }

    public function UpdatePelanggaran($data,$id){
        $this->db->update('db_pelanggaran',$data,[
            'id_pelanggaran' => $id
        ]);
        return;
    }

    public function GetSiswa($key){
        $a = $this->db->select('db_siswa',[
           "[>]db_kelas" => ["id_kelas" => 'id_kelas'], 
        ],[
            'db_siswa.nama_siswa',
            'db_siswa.id_siswa',
            'db_kelas.nama_kelas',
        ],[
            "db_siswa.nama_siswa[~]" => $key,
            'db_siswa.status'=> '0',
            'LIMIT' => 4
        ]);

        return $a;
    }

    public function GetPelanggaranKey($key){

        $a = $this->db->select('db_pelanggaran',[
            'id_pelanggaran',
            'nama_pelanggaran',
            'point_pelanggaran',
        ],[
            'nama_pelanggaran[~]' => $key,
        ]);

        return $a;
    }

    public function TambahPoint($data){
        $this->db->insert('db_riwayat_pelanggaran',$data);
        return;
    }

    public function getSiswaList($data,$rule=''){
        if ($rule == 'data') {
            if ($_SESSION['filter_siswa'] == '') {
                $a = $this->db->select('db_siswa',[
                "[>]db_kelas" => ["id_kelas" => 'id_kelas']
                ],[
                    'db_siswa.id_siswa',
                    'db_siswa.nama_siswa',
                    'db_siswa.nis',
                    'db_kelas.nama_kelas'
                ],[
                    'db_siswa.status'=> '0',
                    "ORDER" => [
                        'db_siswa.id_siswa' => "DESC"
                    ],
                    "LIMIT" => [$data['start'],$data['fh']]
                ]);   
            }elseif ($_SESSION['filter_siswa']['kelas'] != '') {
                $a = $this->db->select('db_siswa',[
                "[>]db_kelas" => ["id_kelas" => 'id_kelas']
                ],[
                    'db_siswa.id_siswa',
                    'db_siswa.nama_siswa',
                    'db_siswa.nis',
                    'db_siswa.id_kelas',
                    'db_kelas.nama_kelas'
                ],[
                   'db_siswa.id_kelas' => $_SESSION['filter_siswa']['kelas'],
                   'db_siswa.status'=> '0', 
                    "ORDER" => [
                        'db_siswa.id_siswa' => "DESC"
                    ],
                    "LIMIT" => [$data['start'],$data['fh']]
                ]);  
            }
        }elseif ($rule == 'total') {
            if ($_SESSION['filter_siswa'] == '') {
                $a = $this->db->select('db_siswa',[
                    'id_siswa',
                ],[
                    'status'=> '0',
                    "ORDER" => [
                        'id_siswa' => "DESC"
                    ],
                ]);
            }elseif ($_SESSION['filter_siswa']['kelas'] != '') {
                $a = $this->db->select('db_siswa',[
                    'id_siswa',
                ],[
                    'id_kelas' => $_SESSION['filter_siswa']['kelas'],
                    'status'=> '0',
                    "ORDER" => [
                        'id_siswa' => "DESC"
                    ],
                ]);
            }
        }elseif ($rule == 'cari') {
            if ($_SESSION['filter_siswa'] == '') {
                $a = $this->db->select('db_siswa',[
                "[>]db_kelas" => ["id_kelas" => 'id_kelas']
                ],[
                    'db_siswa.id_siswa',
                    'db_siswa.nama_siswa',
                    'db_siswa.nis',
                    'db_siswa.id_kelas',
                    'db_kelas.nama_kelas'
                ],[
                    'db_siswa.nama_siswa[~]' => $data['cari'],
                    'db_siswa.status'=> '0',
                    "ORDER" => [
                        'db_siswa.id_siswa' => "DESC"
                    ],
                    "LIMIT" => [$data['start'],$data['fh']]
                ]);   
            }elseif ($_SESSION['filter_siswa']['kelas'] != '') {
                $a = $this->db->select('db_siswa',[
                "[>]db_kelas" => ["id_kelas" => 'id_kelas']
                ],[
                    'db_siswa.id_siswa',
                    'db_siswa.nama_siswa',
                    'db_siswa.nis',
                    'db_siswa.id_kelas',
                    'db_kelas.nama_kelas'
                ],[
                   'db_siswa.id_kelas' => $_SESSION['filter_siswa']['kelas'],
                   'db_siswa.nama_siswa[~]' => $data['cari'], 
                   'db_siswa.status'=> '0',
                    "ORDER" => [
                        'db_siswa.id_siswa' => "DESC"
                    ],
                    "LIMIT" => [$data['start'],$data['fh']]
                ]);  
            }
        }

        return $a;
    }

    public function GetRiwayatPelanggar($id){
        $a = $this->db->select('db_riwayat_pelanggaran',[
            "[>]db_pelanggaran" => ["id_pelanggaran" => 'id_pelanggaran']
        ],[
            'db_riwayat_pelanggaran.id_riwayat',
            'db_riwayat_pelanggaran.id_pelanggaran',
            'db_pelanggaran.nama_pelanggaran',
            'db_pelanggaran.point_pelanggaran'
        ],[
            'db_riwayat_pelanggaran.id_siswa' => $id
        ]);

        return $a;
    }

    public function GetKelasAll(){
        $a = $this->db->select('db_kelas',[
            'id_kelas',
            'nama_kelas',
        ]);
        return $a;
    }

    public function hapusSiswa($data){
        $this->db->delete('db_siswa',[
            'id_siswa' => $data
        ]);

        $this->db->delete('db_riwayat_pelanggaran',[
            'id_siswa' => $data
        ]);
        return;
    }
    public function GetsSiswaById($id){
        $a = $this->db->select('db_siswa',[
             "[>]db_kelas" => ["id_kelas" => 'id_kelas']
        ],[
            'db_siswa.id_siswa',
            'db_siswa.id_kelas',
            'db_siswa.tahun_masuk',
            'db_siswa.nama_siswa',
            'db_siswa.nis',
            'db_kelas.nama_kelas',
        ],[
            'db_siswa.id_siswa'=> $id,
            'db_siswa.status'=> '0',
        ]);
        return $a;
    }

    public function GetPelanggaranSiswa($id){
        $a = $this->db->select('db_riwayat_pelanggaran',[
             "[>]db_user" => ["id_input" => 'id_user'],
             "[>]db_pelanggaran" => ["id_pelanggaran" => 'id_pelanggaran'],
        ],[
            'db_riwayat_pelanggaran.catatan',
            'db_user.nama_user',
            'db_pelanggaran.nama_pelanggaran',
            'db_pelanggaran.point_pelanggaran'
        ],[
            'db_riwayat_pelanggaran.id_siswa'=> $id,
             "ORDER" => [
                'db_riwayat_pelanggaran.id_riwayat' => "DESC"
            ],
        ]);

        return $a;
    }

    public function ValSiswa($id){
        $a = $this->db->select('db_siswa',[
            'id_siswa'
        ],[
            'id_siswa' => $id
        ]);
        return count($a);
    }

    public function GetKelasSiswa($id){
        $a = $this->db->select('db_kelas',[
            'id_kelas',
            'nama_kelas'
        ],[
            'id_kelas[!]' => $id
        ]);

        return $a;
    }

    public function UpdateSiswa($data,$id){
        $this->db->update('db_siswa',$data,$id);
        return;
    }


    public function getSiswaInput($data,$rule=''){
        $iduser = $this->sandi->Buka($_SESSION['id_user']);
        if ($rule == 'data') {
                $a = $this->db->select('db_siswa',[
                    'id_siswa',
                    'nama_siswa',
                    'tahun_masuk',
                    'nis',
                ],[
                    'status'=> '1',
                    'id_input'=> $iduser,
                    "ORDER" => [
                        'id_siswa' => "DESC"
                    ],
                    "LIMIT" => [$data['start'],$data['fh']]
                ]);   
            
        }elseif ($rule == 'total') {
                $a = $this->db->select('db_siswa',[
                    'id_siswa',
                ],[
                    'status'=> '1',
                    'id_input'=> $iduser,
                    "ORDER" => [
                        'id_siswa' => "DESC"
                    ],
                ]);
        }elseif ($rule == 'cari') {
                $a = $this->db->select('db_siswa',[
                    'id_siswa',
                    'nama_siswa',
                    'tahun_masuk',
                    'nis',
                ],[
                   'nama_siswa[~]' => $data['cari'], 
                   'status'=> '1',
                   'id_input'=> $iduser,
                    "ORDER" => [
                        'id_siswa' => "DESC"
                    ],
                    "LIMIT" => [$data['start'],$data['fh']]
                ]);  
        }

        return $a;
    }

    public function ValSiswaNama($nama){
        $a = $this->db->select('db_siswa',[
            'id_siswa'
        ],[
            'nama_siswa' => $nama
        ]);
        return count($a);
    }

    public function addSiswa($data){
        $this->db->insert('db_siswa',$data);
        return;
    }

    public function TotalDataSiswa(){
        $iduser = $this->sandi->Buka($_SESSION['id_user']);
         $a = $this->db->select('db_siswa',[
                    'id_siswa',
                ],[
                    'status'=> '1',
                    'id_input'=> $iduser
                ]);  
        return $a; 
    }

    public function UploadSiswa($ar,$id){
        $this->db->update('db_siswa',$ar,$id);
        return;
    }

    public function GetRiwayat(){
        $a = $this->db->select('db_riwayat_pelanggaran',[
            'id_riwayat',
            'id_siswa',
            'id_pelanggaran'
        ]);

        return $a;
    }

    public function GetRiwayatNama($id){
        $a = $this->db->get('db_siswa',[
            'nama_siswa'
        ],[
            'id_siswa' => $id
        ]);

        return $a;
    }

    public function cekPass($data){
        $iduser = $this->sandi->Buka($_SESSION['id_user']);
        $a = $this->db->select('db_user',[
            'id_user'
        ],[
            'id_user' => $iduser,
            'password' => $data['passlama']
        ]);

        return count($a);
    }

    public function UbahPassword($data,$id){
        $this->db->update('db_user',[
            'password' => $data['passbaru'],
            'status' => '0'
        ],[
            'id_user' => $id,
        ]);
        return;
     }

}


 ?>