<?php
require 'libs/Model.php';
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Установка программы</title>
    <link rel="stylesheet" href="public/css/default.css">
    <script src="public/js/jquery-2.2.3.min.js"></script>
    <link rel="stylesheet" href="public/font-awesome-4.6.1/css/font-awesome.min.css">
    <script>
        $(document).ready(function () {
            var dbhost;
            var dbuser;
            var dbpassword;
            var dbname;

            $(".cont .submit1").click(function () {
                var dbcheck = false;
                var id = $(this).attr("data-page");
                var page = id - 1;
                if(page==2){
                    dbhost =  $("#db-host").val();
                    dbuser =  $("#db-user").val();
                    dbpassword =  $("#db-password").val();
                    dbname =  $("#db-name").val();
                    $("#confirmBox").remove();
                    $("body").append("<div id='confirmBox'>Установка базы данных..</div>");
                    $("#confirmBox").show();

                    $.get("i_core.php",
                        {
                            check: true,
                            dbhost: dbhost,
                            dbuser: dbuser,
                            dbpassword: dbpassword,
                            dbname: dbname
                        },
                        function(data){
                            if($("#db-name").val() == "") data = "fail";
                            if(data!="fail"){
                                $("#"+page+".cont").css({"display":"none"});
                                $("#"+id).css({"display":"block"});
                                $("#confirmBox").remove();
                            }
                            else {
                                $("#confirmBox").remove();
                                $("body").append("<div id='confirmBox'>Ошибка подключения!</div>");
                                $("#confirmBox").show();
                                setTimeout(function () {
                                    $("#confirmBox").toggle(function () {
                                            $("#confirmBox").slideUp("fast");
                                        },
                                        function () {
                                            $("#confirmBox").remove();
                                        });
                                }, 3000);
                            }
                        });

                }
                if(page!=2 ){
                    $("#"+page+".cont").css({"display":"none"});
                    $("#"+id).css({"display":"block"});
                }
                if(page==3){
                    $.get("i_core.php",
                        {
                            mSettings: true,
                            dbhost: dbhost,
                            dbuser: dbuser,
                            dbpassword: dbpassword,
                            dbname: dbname,
                            url: $("#url").val(),
                            collegeName: $("#collegeName").val(),
                            adminLogin: $("#adminLogin").val(),
                            adminPassword: $("#adminPassword").val(),
                            email: $("#email").val(),
                            SMTPHost: $("#SMTPHost").val(),
                            SMTPUser: $("#SMTPUser").val(),
                            SMTPPassword: $("#SMTPPassword").val(),
                            MailName: $("#MailName").val()
                        },
                        function(data) {

                        });
                }
                if($(this).attr("data-page")=="final-del"){
                    $.get("i_core.php",
                        {
                          delInstall: true
                        },function () {
                            window.location = '/index.php';
                        });
                }

            });
        });
    </script>
</head>

<div class="install-form">
    <div class="title">Мастер установки</div>
    <div class="cont" id="1" >Здравствуйте!<br>Сейчас мы проведём установку системы.
        <br>Это не займёт много времени.<br><br>Настоятельно рекомендуем, проводить инсталяцию специалистам, для избежания возможных проблем.
        <br><br><b>Установите права "777" на папку config и внутри лежащие файлы</b>
        <p>config/database.php
            <?php if(is_writable("config/database.php")) echo '<i class="fa fa-check" aria-hidden="true"></i>';
            else echo '<i class="fa fa-times" aria-hidden="true"></i>'?>
        </p>
        <p>config/paths.php
            <?php if(is_writable("config/paths.php")) echo '<i class="fa fa-check" aria-hidden="true"></i>';
            else echo '<i class="fa fa-times" aria-hidden="true"></i>'?>
        </p>
        <?php if(is_writable("config/paths.php") && is_writable("config/database.php")): ?>
            <input type="button" data-page="2"  class="submit1" value="Поехали">
        <?php else: ?>
            <br><p>Настройте права и обновите страницу!</p>
        <?php endif; ?>
    </div>

    <div class="cont" id="2" style="display: none">
        <p><b>Настройка MySQL</b></p>
        <table class="setting-table">
            <tr>
                <td>Хост БД: </td><td><input type="text" id="db-host"></td>
            </tr>
            <tr>
                <td>Логин БД: </td><td><input type="text" id="db-user"></td>
            </tr>
            <tr>
                <td>Пароль БД: </td><td><input type="password" id="db-password"></td>
            </tr>
            <tr>
                <td>Название БД: </td><td><input type="text" id="db-name"></td>
            </tr>
        </table>
        <input type="button" data-page="3"  class="submit1" value="Далее">
    </div>


    <div class="cont" id="3" style="display: none">
        <p><b>Общие настройки</b></p>
        <table class="setting-table">
            <tr>
                <td>URL системы</td><td><input required type="text" id="url" value="http://<?=$_SERVER['SERVER_NAME']?>/"></td>
            </tr>
            <tr>
                <td>Название учебной организации: </td><td><input required type="text" id="collegeName"></td>
            </tr>
            <tr>
                <td>Логин администратора: </td><td><input required type="text" id="adminLogin"></td>
            </tr>
            <tr>
                <td>Пароль администратора: </td><td><input required type="password" id="adminPassword"></td>
            </tr>
            <tr>
                <td>E-mail администратора: </td><td><input required type="text" id="email"></td>
            </tr>
        </table>
        <p><b>Настройка почты</b></p>
        <table class="setting-table">
            <tr>
                <td>SMTP хост: </td><td><input required type="text" id="SMTPHost"></td>
            </tr>
            <tr>
                <td>SMTP пользователь: </td><td><input required type="text" id="SMTPUser"></td>
            </tr>
            <tr>
                <td>SMTP пароль: </td><td><input required type="password" id="SMTPPassword"></td>
            </tr>
            <tr>
                <td>Имя отправителя: </td><td><input required type="text" id="MailName"></td>
            </tr>
        </table>
        <input type="button" data-page="4"  class="submit1" value="Далее">
    </div>
    <div class="cont" id="4" style="display: none">
        <p><b>Конец установки</b></p>
        Вот и всё! Установка завершена! Настоятельно рекомендуем удалить файлы установки.
        <input type="button" data-page="final-del" class="submit1" value="Удалить файлы установки и перейти к системе">
        <input type="button" data-page="final" class="submit1" value="Перейти к системе">
    </div>
</div>
<?php
?>
