<?php
session_start();

error_reporting(0);

set_time_limit(0);

// (!isset($_SESSION['id_siswa'])) ? header("Location: $homeurl/login") : $id_siswa = $_SESSION['id_siswa'];
(isset($_SESSION['id_siswa'])) ? $id_siswa = $_SESSION['id_siswa'] : $id_siswa = "";

//$ref = $_SERVER['HTTP_REFERER'];
$uri = $_SERVER['REQUEST_URI'];
$pageurl = explode("/", $uri);

if ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] && !in_array(strtolower($_SERVER['HTTPS']), array('off', 'no'))) == "on") {
	$homeurl = "https://" . $_SERVER['HTTP_HOST'];
	(isset($pageurl[1])) ? $pg = $pageurl[1] : $pg = '';
	(isset($pageurl[2])) ? $ac = $pageurl[2] : $ac = '';
	(isset($pageurl[3])) ? $id = $pageurl[3] : $id = 0;
} else {
	$homeurl = "http://" . $_SERVER['HTTP_HOST'];
	(isset($pageurl[1])) ? $pg = $pageurl[1] : $pg = '';
	(isset($pageurl[2])) ? $ac = $pageurl[2] : $ac = '';
	(isset($pageurl[3])) ? $id = $pageurl[3] : $id = 0;
}

require "config.database.php";
$host = $host;
$user = $user;
$pass = $pass;
$debe = $debe;

$koneksi = mysqli_connect($host, $user, $pass);
if ($koneksi) {
	$pilihdb = mysqli_select_db($koneksi, $debe);
	if ($pilihdb) {
		date_default_timezone_set('Asia/Jakarta');
	}
}

$no = $jam = $mnt = $dtk = 0;
$info = '';
$waktu = date('H:i:s');
$tanggal = date('Y-m-d');
$datetime = date('Y-m-d H:i:s');

$copyright = 'HAz Development';
define("REVISI", "3");
define("APLIKASI", "HAz CBT Online");

if (strpos($_SERVER['HTTP_USER_AGENT'], 'Netscape')) {
	$browser = 'Netscape';
} else if (strpos($_SERVER['HTTP_USER_AGENT'], 'Firefox')) {
	$browser = 'Firefox';
} else if (strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome')) {
	$browser = 'Chrome';
} else if (strpos($_SERVER['HTTP_USER_AGENT'], 'Opera')) {
	$browser = 'Opera';
} else if (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE')) {
	$browser = 'Internet Explorer';
} else $browser = 'Other';
