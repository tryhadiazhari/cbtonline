<?php
function enkripsi($string)
{
	$output = false;

	$encrypt_method = "AES-256-CBC";
	$secret_key = 'abcdefghijklmnopqrstuvwxyzABNCDEFGHIJKLMNOPQRSTUVWXYZ1234567890!@#$%^&*()_+|}{:?><';
	$secret_iv = 'abcdefghijklmnopqrstuvwxyzABNCDEFGHIJKLMNOPQRSTUVWXYZ1234567890!@#$%^&*()_+|}{:?><';

	// hash
	$key = hash('sha256', $secret_key);

	// iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
	$iv = substr(hash('sha256', $secret_iv), 0, 16);

	$output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
	$output = base64_encode($output);

	return $output;
}

function dekripsi($string)
{
	$output = false;

	$encrypt_method = "AES-256-CBC";
	$secret_key = 'abcdefghijklmnopqrstuvwxyzABNCDEFGHIJKLMNOPQRSTUVWXYZ1234567890!@#$%^&*()_+|}{:?><';
	$secret_iv = 'abcdefghijklmnopqrstuvwxyzABNCDEFGHIJKLMNOPQRSTUVWXYZ1234567890!@#$%^&*()_+|}{:?><';

	// hash
	$key = hash('sha256', $secret_key);

	// iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
	$iv = substr(hash('sha256', $secret_iv), 0, 16);

	$output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);

	return $output;
}
function cek_session_admin()
{

	$level = $_SESSION['level'];
	if ($level != 'admin') {
		echo "<script>document.location='.';</script>";
	}
}

function cek_session_guru()
{
	$level = $_SESSION['level'];
	if ($level != 'guru' and $level != 'admin') {
		echo "<script>document.location='.';</script>";
	}
}

function jump($page)
{
	echo "<script>location=('$page');</script>";
}
function info($string, $type = null)
{
	if ($type == 'OK') {
		$class = "success";
		$icon = "fa-check";
	} elseif ($type == 'NO') {
		$class = "danger";
		$icon = "fa-warning";
	} else {
		$class = "warning";
		$icon = "fa-info-circle";
	}
	return "<p class='text-$class'><i class='fa $icon'></i> $string</p>";
}
function timeAgo($tanggal)
{
	$ayeuna = date('Y-m-d H:i:s');
	$detik = strtotime($ayeuna) - strtotime($tanggal);
	if ($detik <= 0) {
		return "Baru saja";
	} else {
		if ($detik < 60) {
			return $detik . " detik yang lalu";
		} else {
			$menit = $detik / 60;
			if ($menit < 60) {
				return number_format($menit, 0) . " menit yang lalu";
			} else {
				$jam = $menit / 60;
				if ($jam < 24) {
					return number_format($jam, 0) . " jam yang lalu";
				} else {
					$hari = $jam / 24;
					if ($hari < 2) {
						return "Kemarin";
					} elseif ($hari < 3) {
						return number_format($hari, 0) . " hari yang lalu";
					} else {
						return $tanggal;
					}
				}
			}
		}
	}
}
function size($bytes = 0)
{
	$size = $bytes;
	$b = "B";
	if ($size > 1024) {
		$size = number_format($bytes / 1024, 2, '.', '');
		$b = "KB";
		if ($size > 1024) {
			$size = number_format($bytes / 1024 / 1024, 2, '.', '');
			$b = "MB";
			if ($size > 1024) {
				$size = number_format($bytes / 1024 / 1024 / 1024, 2, '.', '');
				$b = "GB";
				if ($size > 1024) {
					$size = number_format($bytes / 1024 / 1024 / 1024 / 1024, 2, '.', '');
					$b = "TB";
				}
			}
		}
	}
	$size = str_replace('.00', '', $size);
	return $size . ' ' . $b;
}

function bulan_indo($tanggal)
{
	$bulan = array(
		1 =>
		'Januari',
		'Februari',
		'Maret',
		'April',
		'Mei',
		'Juni',
		'Juli',
		'Agustus',
		'September',
		'Oktober',
		'November',
		'Desember'
	);
	$pecahkan = explode('-', $tanggal);
	return $bulan[(int) $pecahkan[1]];
}

function buat_tanggal($format, $time = null)
{
	$time = ($time == null) ? time() : strtotime($time);
	$str = date($format, $time);
	for ($t = 1; $t <= 9; $t++) {
		$str = str_replace("0$t ", "$t ", $str);
	}
	$str = str_replace("Jan", "Januari", $str);
	$str = str_replace("Feb", "Februari", $str);
	$str = str_replace("Mar", "Maret", $str);
	$str = str_replace("Apr", "April", $str);
	$str = str_replace("May", "Mei", $str);
	$str = str_replace("Jun", "Juni", $str);
	$str = str_replace("Jul", "Juli", $str);
	$str = str_replace("Aug", "Agustus", $str);
	$str = str_replace("Sep", "September", $str);
	$str = str_replace("Oct", "Oktober", $str);
	$str = str_replace("Nov", "November", $str);
	$str = str_replace("Dec", "Desember", $str);
	$str = str_replace("Mon", "Senin", $str);
	$str = str_replace("Tue", "Selasa", $str);
	$str = str_replace("Wed", "Rabu", $str);
	$str = str_replace("Thu", "Kamis", $str);
	$str = str_replace("Fri", "Jumat", $str);
	$str = str_replace("Sat", "Sabtu", $str);
	$str = str_replace("Sun", "Minggu", $str);
	return $str;
}
function enum($bool)
{
	$bool = ($bool == 1) ? 'Ya' : 'Tidak';
	return $bool;
}
function html2str($str)
{
	$str = str_replace('"', "”", $str);
	$str = str_replace("'", "’", $str);
	$str = str_replace("<", "&lt;", $str);
	$str = str_replace(">", "&gt;", $str);
	return $str;
}

function create_zip($files = array(), $destination = '', $overwrite = false)
{
	//if the zip file already exists and overwrite is false, return false 	
	if (file_exists($destination) && !$overwrite) {
		return false;
	}
	//vars 	$valid_files = array(); 	 	
	//if files were passed in... 	
	if (is_array($files)) {
		//cycle through each file 		
		foreach ($files as $file) {
			//make sure the file exists
			if (file_exists($file)) {
				$valid_files[] = $file;
			}
		}
	} elseif (is_dir($files)) {
		if ($handle = opendir($files)) {
			while (false !== ($entry = readdir($handle))) {
				if ($entry != "." && $entry != ".." && !is_dir($files . '/' . $entry)) {
					$valid_files[] = $files . '/' . $entry;
				}
			}
			closedir($handle);
		}
	}
	//if we have good files...
	if (count($valid_files)) {
		//create the archive
		$zip = new ZipArchive();
		if ($zip->open($destination, $overwrite ? ZIPARCHIVE::OVERWRITE : ZIPARCHIVE::CREATE) !== true) {
			return false;
		}
		//add the files
		foreach ($valid_files as $file) {
			$zip->addFile($file, $file);
		}
		//close the zip -- done!
		$zip->close();
		//check to make sure the file exists
		return file_exists($destination);
	} else {
		return false;
	}
}

function restore($file)
{
	include "config.database.php";
	$koneksi = mysqli_connect($host, $user, $pass, $debe);
	global $rest_dir;
	$nama_file	= $file['name'];
	$ukrn_file	= $file['size'];
	$tmp_file	= $file['tmp_name'];

	if ($nama_file == "") {
		echo "Fatal Error";
	} else {
		$alamatfile	= $rest_dir . $nama_file;
		$templine	= array();

		if (move_uploaded_file($tmp_file, $alamatfile)) {
			$templine	= '';
			$lines		= file($alamatfile);

			foreach ($lines as $line) {
				if (substr($line, 0, 2) == '--' || $line == '')
					continue;

				$templine .= $line;

				if (substr(trim($line), -1, 1) == ';') {
					mysqli_query($koneksi, $templine);
					$templine = '';
				}
			}
			echo "<div class='alert alert-success alert-dismissible'>
				<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
				<h4><i class='icon fa fa-check'></i> Info</h4>
				berhasil upload restore data
				</div>";
		} else {
			echo "Proses upload gagal, kode error = " . $file['error'];
		}
	}
}

function backup($host, $user, $pass, $name, $nama_file, $tables)
{
	require("config.default.php");
	//untuk koneksi database
	$link = mysqli_connect($host, $user, $pass);
	mysqli_select_db($name, $link);
	// Jika Semua Tabel
	if ($tables == '*') {
		$tables = array();
		$result = mysqli_query($koneksi, 'SHOW TABLES');
		while ($row = mysqli_fetch_row($result)) {
			$tables[] = $row[0];
		}
	} else {
		//jika hanya table-table tertentu
		$tables = is_array($tables) ? $tables : explode(',', $tables);
	}
	foreach ($tables as $table) {
		$result = mysqli_query($koneksi, 'SELECT * FROM ' . $table);
		$num_fields = mysqli_num_fields($result);
		//menyisipkan query drop table untuk nanti hapus table yang lama
		$return = 'DROP TABLE ' . $table . '';
		$row2 = mysqli_fetch_row(mysqli_query($koneksi, 'SHOW CREATE TABLE ' . $table));
		$return .= "\n\n" . $row2[1] . ";\n\n";
		for ($i = 0; $i < $num_fields; $i++) {
			while ($row = mysqli_fetch_row($result)) {
				$return .= 'INSERT INTO ' . $table . ' VALUES(';
				for ($j = 0; $j < $num_fields; $j++) {
					$row[$j] = addslashes($row[$j]);
					$row[$j] = ereg_replace("\n", "\\n", $row[$j]);
					if (isset($row[$j])) {
						$return .= '"' . $row[$j] . '"';
					} else {
						$return .= '""';
					}
					if ($j < ($num_fields - 1)) {
						$return .= ',';
					}
				}
				$return .= ");\n";
			}
		}
		$return .= "\n\n\n";
	}

	$nama_file;
	$handle = fopen($nama_file, 'w+');
	fwrite($handle, $return);
	fclose($handle);
}
