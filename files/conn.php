<?php

$uri = "mysql://avnadmin:AVNS_1h23CLhSqBRatZf429L@lipus-test-kapieksperimental-2f90.g.aivencloud.com:15657/defaultdb?ssl-mode=REQUIRED";

$fields = parse_url($uri);

// Konfiguracja połączenia do MySQL
$host = $fields["host"];
$port = $fields["port"];
$dbname = 'defaultdb';
$username = $fields["user"];
$password = $fields["pass"];
$ssl_ca = 'ca.pem';

// Nawiązanie połączenia z użyciem mysqli_connect oraz SSL
$conn = mysqli_init();
if (!$conn) {
    die('mysqli_init failed');
}

mysqli_ssl_set($conn, NULL, NULL, $ssl_ca, NULL, NULL);

if (!mysqli_real_connect($conn, $host, $username, $password, $dbname, $port, NULL, MYSQLI_CLIENT_SSL)) {
    die('Connect Error (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
}

?>
