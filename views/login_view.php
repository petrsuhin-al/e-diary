<?php $model = new Model();
$logo = $model->db->query("SELECT Value FROM settings WHERE Attribute='CollegeLogo'")->fetchObject()->Value;
?>
<div class="login-logo"><img src="<?=URL?><?=$logo?>"></div>
<form class="login-form" action="<?=URL?>login/run" method="post">
    <div class="title">Авторизация в системе</div>
    <div class="input-group">
        <span class="input-group-icon"><i class="fa fa-user" style=" text-align: center; width: 14px;" aria-hidden="true"></i></span>
        <input type="text" name="login" placeholder="Логин">
    </div>
    <div class="input-group">
        <span class="input-group-icon"><i class="fa fa-key" aria-hidden="true"></i></span>
        <input type="password" name="password" placeholder="Пароль">
    </div>
    <div class="input-group-noborder">
        <input type="submit" value="Войти">
    </div>
    </form>
    <p style="text-align: center; width: 200px; color: #fff; padding: 10px;  margin: auto; background: #e14d43">Создано Синявским Иваном.</p>