<?php
class Settings_Model extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    function save()
    {
        if ($_FILES["filename"]["size"] > 1024 * 3 * 1024) {
            echo("Размер файла превышает три мегабайта");
        }
// Проверяем загружен ли файл
        if (is_uploaded_file($_FILES["filename"]["tmp_name"])) {
            // Если файл загружен успешно, перемещаем его
            // из временной директории в конечную
            move_uploaded_file($_FILES["filename"]["tmp_name"], "public/images/".$_FILES["filename"]["name"]);
            $file_url = "public/images/".$_FILES["filename"]["name"];
        }
        $this->db->query("UPDATE settings SET Value='{$_POST['CollegeName']}' WHERE Attribute = 'CollegeName'");
        $this->db->query("UPDATE settings SET Value='{$_POST['URL']}' WHERE Attribute = 'URL'");
        if(isset($file_url))
        $this->db->query("UPDATE settings SET Value='$file_url' WHERE Attribute = 'CollegeLogo'");
        $this->db->query("UPDATE settings SET Value='{$_POST['SMTP_HOST']}' WHERE Attribute = 'SMTP_HOST'");
        $this->db->query("UPDATE settings SET Value='{$_POST['SMTP_USER']}' WHERE Attribute = 'SMTP_USER'");
        $this->db->query("UPDATE settings SET Value='{$_POST['SMTP_PASSWORD']}' WHERE Attribute = 'SMTP_PASSWORD'");
        $this->db->query("UPDATE settings SET Value='{$_POST['MAIL_NAME']}' WHERE Attribute = 'MAIL_NAME'");
        $_POST['s-save'] = "true";
        header('Location: '.URL.'settings?good');
    }
    function getAttributes($attr)
    {
        $sth = $this->db->query("SELECT * FROM settings WHERE Attribute='$attr'");
        return $sth->fetchObject()->Value;
    }
}