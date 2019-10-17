<?php
ini_set("display_errors",1);
error_reporting(E_ALL);
require 'libs/Bootstrap.php';
require 'libs/Controller.php';
require 'libs/View.php';
require 'libs/Database.php';
require 'public/PHPMailer/PHPMailerAutoload.php';
require 'libs/Session.php';
require 'libs/Model.php';
require 'libs/Functions.php';
require 'config/paths.php';
require 'config/database.php';

Session::init();
$app = new Bootstrap();