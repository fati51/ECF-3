<?php
require "PHPMailer/PHPMailerAutoload.php";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

try {
    $bdd = new PDO('mysql:host=localhost;dbname=zevent', 'root', 'root');
} catch (Exception $e) {
    die('Veuillez vérifier votre base de données');
}
