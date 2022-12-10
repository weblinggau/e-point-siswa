<?php
class Inc{
	public function __construct()
	{
		$this->sandi = new Encrypt();
		$this->koneksi = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME) or die("GAGAL");
		// $this->db = $this->model('LoginModel');
	}

	// funsgi riderect url
	// $url = String ('/auth' atau '/panel' ada krakter '/' didpan)
	public function riderect($url){
		$urli = BASEURL.$url;
		echo '
        <script>
        window.location = "'. $urli .'"
        </script>
        ';
        exit;
	}

	// untuk create session data untuk notif dan pesan alert
	// $pesan = String
	// $atribut = String (alert-danger, alert-warning, alert-succes)
	public function sendNotif($pesan,$atribut){
		$_SESSION['atribut'] = $atribut;
        $_SESSION['pesan'] = $pesan;
	}

	// menampilkan notif alert di view
	public function notif(){
		if (isset($_SESSION['pesan']) && $_SESSION['pesan'] <> '') {
		echo '
			<div class="alert '.$_SESSION['atribut'].' alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-exclamation-triangle"></i> Upss Peringatan!</h5>'
                  .$_SESSION['pesan'].'
	        </div>';
    	}
        $_SESSION['pesan'] = '';
        $_SESSION['atribut'] = '';
	}

	public function notifToas(){
		if (isset($_SESSION['pesan']) && $_SESSION['pesan'] <> '') {
			if ($_SESSION['atribut'] == 'success') {
				echo "
	            toastr.success('pesan sukses', '" . $_SESSION['pesan'] . "');
	        	";
			} elseif ($_SESSION['atribut'] == 'error') {
				echo "
	            toastr.error('pesan kesalahan', '" . $_SESSION['pesan'] . "');
	        	";
			} 
			
			
	    }
	    $_SESSION['pesan'] = '';
        $_SESSION['atribut'] = '';

	}
	
	// sanitasi filter total dan tidak
	// $rule = Integer (1,2)
	// $par = String
	public function filter($rule,$par){
		$d = mysqli_real_escape_string($this->koneksi, $par);
		if ($rule == 1) {
			$d = htmlspecialchars($d, ENT_QUOTES, 'UTF-8');
		}elseif ($rule == 2) {
			$d = filter_var($d, FILTER_SANITIZE_STRING);
		}
	    return $d;
	}

	// sanitasi untuk post
	// $param = String
	public function post($param)
	{
	    $d = isset($_POST[$param]) ? $_POST[$param] : null;
	    $d = mysqli_real_escape_string($this->koneksi, $d);
	    $d = filter_var($d, FILTER_SANITIZE_STRING);
	    return $d;
	}

	public function cryptoJsAesDecrypt($passphrase, $jsonString){
	    $jsondata = json_decode($jsonString, true);
	    $salt = hex2bin($jsondata["s"]);
	    $ct = base64_decode($jsondata["ct"]);
	    $iv  = hex2bin($jsondata["iv"]);
	    $concatedPassphrase = $passphrase.$salt;
	    $md5 = array();
	    $md5[0] = md5($concatedPassphrase, true);
	    $result = $md5[0];
	    for ($i = 1; $i < 3; $i++) {
	        $md5[$i] = md5($md5[$i - 1].$concatedPassphrase, true);
	        $result .= $md5[$i];
	    }
	    $key = substr($result, 0, 32);
	    $data = openssl_decrypt($ct, 'aes-256-cbc', $key, true, $iv);
	    return json_decode($data, true);
	}

	public function cryptoJsAesEncrypt($passphrase, $value){
	    $salt = openssl_random_pseudo_bytes(8);
	    $salted = '';
	    $dx = '';
	    while (strlen($salted) < 48) {
	        $dx = md5($dx.$passphrase.$salt, true);
	        $salted .= $dx;
	    }
	    $key = substr($salted, 0, 32);
	    $iv  = substr($salted, 32,16);
	    $encrypted_data = openssl_encrypt(json_encode($value), 'aes-256-cbc', $key, true, $iv);
	    $data = array(
	    	"ct" => base64_encode($encrypted_data), 
	    	"iv" => bin2hex($iv), 
	    	"s" => bin2hex($salt));
	    return $data;
	}




}
?>