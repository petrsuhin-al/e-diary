<?php
$dbHost = $_GET['dbhost'];
$dbUser = $_GET['dbuser'];
$dbPassword = $_GET['dbpassword'];
$dbName = $_GET['dbname'];
if(!isset($dbName)) $dbName = "a";
if($_GET['check']==true){
    try {
        $dbh = new PDO('mysql:host='.$dbHost.';dbname='.$dbName.'', ''.$dbUser.'', ''.$dbPassword.'');
        $dbCount = $dbh->query("SHOW DATABASES LIKE '$dbName'")->rowCount();

        if($dbCount!=0){
            echo 'good';
        $f = @fopen("dump.sql", "r");
        if($f)
        {
            $q = '';

            while(!feof($f))
            {
                // читаем построчно в буфер $q
                $q .= fgets($f);

                // пока не упрёмся в ;
                if(substr(rtrim($q), -1) == ';')
                {
                    // выполяем запрос
                    $dbh->query($q);

                    // обнуляем буфер
                    $q = '';
                }
            }
        }
            $database = "<?php
define('DB_TYPE', 'mysql');
define('DB_HOST', '".$dbHost."');
define('DB_NAME', '".$dbName."');
define('DB_USER', '".$dbUser."');
define('DB_PASS', '".$dbPassword."');";
            file_put_contents("config/database.php", $database);

        }
        else echo 'fail';

    } catch (PDOException $e) {
        echo 'fail';
    }
}
if($_GET['mSettings']==true){
    $dbh = new PDO('mysql:host='.$dbHost.';dbname='.$dbName.'', ''.$dbUser.'', ''.$dbPassword.'');
    $dbh->exec("set names utf8");
    $collegeName = $_GET['collegeName'];
    $adminLogin = $_GET['adminLogin'];
    $adminPassword = $_GET['adminPassword'];
    $SMTPHost = $_GET['SMTPHost'];
    $SMTPUser = $_GET['SMTPUser'];
    $SMTPPassword = $_GET['SMTPPassword'];
    $MailName = $_GET['MailName'];
    $url = $_GET['url'];
    $email = $_GET['email'];
    $dbh->query("UPDATE settings SET Value='$collegeName' WHERE Attribute = 'CollegeName'");
    $dbh->query("UPDATE settings SET Value='$SMTPHost' WHERE Attribute = 'SMTP_HOST'");
    $dbh->query("UPDATE settings SET Value='$SMTPUser' WHERE Attribute = 'SMTP_USER'");
    $dbh->query("UPDATE settings SET Value='$SMTPPassword' WHERE Attribute = 'SMTP_PASSWORD'");
    $dbh->query("UPDATE settings SET Value='$MailName' WHERE Attribute = 'MAIL_NAME'");

    $dbh->query("INSERT INTO users(login,password,Email,Admin) VALUES('$adminLogin','$adminPassword','$email',1)");

    $file = 'config/paths.php';
    $text = "<?php
define('URL', '".$url."');";
    file_put_contents($file, $text);
}
if($_GET['delInstall']==true){
    unlink("install.php");
    unlink("i_core.php");
}