<?php

$host = 'localhost';
$dbname = 'trung_tam_tiem_chung';
$username = 'root';
$password = '12345678';


$conn = new mysqli($host, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Kết nối database thất bại: " . $conn->connect_error);
}


?>