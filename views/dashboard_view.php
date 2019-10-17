<?php
if($this->changePass==true){
    $trouble = "";
    if(isset($_GET['good'])) $trouble = "Пароль изменён";
    else if(isset($_GET['trouble'])) $trouble = "Не верно введён старый пароль";
    else $trouble = "";
    ?><form method="post" action="<?=URL ?>dashboard/chPassSubmit">
    <table class="form-table">
            <caption>Изменение пароля</caption>
            <tr><td>Cтарый пароль: </td><td><input name="old" type="password"></td></tr>
            <tr><td>Новый пароль: </td><td><input name="password" type="password"></td></tr>
            <tr><td></td><td></td></tr>
            <tr><td><input class="submit2" type="submit" value="Изменить"></td><td><?=$trouble?></td></tr>
           </table>
    <?php
    echo '</form>';
}