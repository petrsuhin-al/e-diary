<form method="post">
<input name="price" type="text">
<input type="submit" name="subm">
</form>
<?php

require 'public/PHPMailer/PHPMailerAutoload.php';
require 'config/paths.php';
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = "smtp.bk.ru";
        $mail->SMTPAuth = true;
        $mail->Username = "linki_98i@bk.ru";
        $mail->Password = "mail.ru";
        $mail->SMTPSecure = 'tls';
        $mail->From = "linki_98i@bk.ru";
        $mail->FromName = "Ваня";
        $mail->isHTML(true);
        $mail->CharSet = 'utf-8';
		echo preg_replace('~[^0-9]+~','',$_POST['price']);
if(isset($_POST['subm'])){
	if(preg_replace('~[^0-9]+~','',$_POST['price'])<7000 && preg_replace('~[^0-9]+~','',$_POST['price'])>4000){
			$mail->addAddress("linki_98i@bk.ru");
                $mail->Subject = 'Найдена хорошая цена';
                $mail->Body    = 'Цена на билет: '.preg_replace('~[^0-9]+~','',$_POST['price']).' Время: '.date("d.m H:i");
                $mail->send();

	}

}
			
?>
