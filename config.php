<?php
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'api';

$mysqli = new mysqli($host, $username, $password, $database);

if ($mysqli->connect_error) {
    die('Koneksi ke database gagal: ' . $mysqli->connect_error);
}
?>
