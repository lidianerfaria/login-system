<?php
// Concexão com o banco de dados
$serverName = "localhost";
$username = "root";
$password = "";
$dbName = "sistemalogin";

$connect = mysqli_connect($serverName, $username, $password, $dbName); // função que vai conectar com o banco de dados

if (mysqli_connect_error()) :
  echo "Falha" . mysqli_connect_error();
endif;
