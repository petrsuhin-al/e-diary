<h1>Настройки системы</h1>
<form action="<?=URL?>settings/save" method="post" enctype="multipart/form-data">
<table class="form-table" >

    <tr>
        <td><h3>Общие настройки</h3></td>
        <td>
            <?php
                if(isset($_GET['good'])) echo "Настройки успешно сохранены!";
            ?>
        </td>
    </tr>
    <tr>
        <td>Адрес системы:</td><td><input value="<?=$this->URL?>" name="URL" placeholder="Например: http://elj.cfuv.ru/" required type="text">
            <br>
            <span style="color: #999">* для корректной работы системы</span></td>
    </tr>
    <tr>
        <td>Название заведения:</td><td><input value="<?=$this->CollegeName?>" name="CollegeName" placeholder="Например: Таврический Колледж" required type="text"> </td>
    </tr>
    <tr>
        <td>Логотип заведения:</td>
        <td>
            <input style="min-width: 100px" type="file" name="filename">
        </td>
    </tr>
    <tr>
        <td></td><td><img class="logo" src="<?=URL.$this->CollegeLogo?>" height="100"></td>

    </tr>
    <tr>
        <td><h3>Настройки почты</h3></td><td></td>
    </tr>
    <tr>
        <td>SMTP хост:</td><td><input value="<?=$this->SMTP_HOST?>" name="SMTP_HOST" required type="text" placeholder="Например: smtp.mail.ru"></td>
    </tr>
    <tr>
        <td>SMTP пользователь:</td><td><input value="<?=$this->SMTP_USER?>" name="SMTP_USER" required type="text" placeholder="Например: smtplogin@mail.ss"></td>
    </tr>
    <tr>
        <td>SMTP пароль:</td><td><input value="<?=$this->SMTP_PASSWORD?>" name="SMTP_PASSWORD" required type="password"></td>
    </tr>
    <tr>
        <td>Имя отправителя:</td><td><input value="<?=$this->MAIL_NAME?>" name="MAIL_NAME" required type="text" placeholder="Например: Таврическая академия"><br>
        <span style="color: #999">* будет отображаться как автор в сообщениях</span></td>
    </tr>

</table>
    <br>
    <input class="submit1" type="submit" name="submit" value="Сохранить">
</form>
