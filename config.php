<!-- Code by Ferhat OZCELIK -->
<?php

$conn = mysqli_connect("localhost", "root", "", "test");
$conn->set_charset("utf8");

if (!$conn) {
    echo "Connection Failed";
}

$domain = "localhost";
$ConfigName = "";
$ConfigHost = "";
$ConfigUsername = "";
$ConfigEmail = "";
$ConfigPassword = "";
$ConfigPort = 465;

$ConfigSignature = "";