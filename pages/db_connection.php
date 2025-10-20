<?php

$host = 'localhost';
$port = '5432'; 
$dbname = 'uts_pemroweb'; 
$user = 'postgres'; 
$password = '08112005prana'; 

$conn_string = "host={$host} port={$port} dbname={$dbname} user={$user} password={$password}";

$dbconn = pg_connect($conn_string);

if (!$dbconn) {
    die("Koneksi ke database gagal: " . pg_last_error());
}