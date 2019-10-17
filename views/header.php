<!doctype html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta charset="UTF-8">
    <title>Электронный журнал</title>
    <link rel="stylesheet" href="<?=URL; ?>/public/font-awesome-4.6.1/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?=URL; ?>/public/css/default.css">
    <link rel="stylesheet" href="<?=URL; ?>/public/css/select2.min.css">
    <script>window.sessionData = <?=json_encode($_SESSION)?>;</script>
    <script src="<?=URL?>public/js/jquery-2.2.3.min.js"></script>
    <script src="<?=URL?>public/js/select2/select2.min.js"></script>
    <script src="<?=URL?>public/js/main.js"></script>
    <link rel="shortcut icon" href="<?=URL; ?>/public/favicon.png" type="image/png">

</head>
<body>
<?php   $model = new Model(); ?>
<?php if(Session::get('loggedIn') == true):?>
<div id="top-panel">
    <div class="angle"></div>

    <div class="logo-block"><?=$model->getSettings("CollegeName")?></div>
    <div class="profile">

        <?php
        if(Session::get("role")!="admin")
            echo $model->getSmallFIO($model->getReal(Session::get("logId"))->fetchObject()->FIO);
        else echo "Администратор";
        $role = Session::get("role");
        ?>
        <i class="ar fa fa-caret-down" aria-hidden="true"></i>
    </div>
</div>
<div id="profile-menu">
    <ul>
        <li><a href="<?=URL?>dashboard/changePass">Сменить пароль</a></li>
        <li><a href="<?=URL?>dashboard/logout">Выйти</a></li>
    </ul>
</div>
<div id="left-panel">
    <ul class="menu">
        <li><a href="<?php echo URL; ?>"><i class="fa fa-home" aria-hidden="true"></i></a>
            <div class="sub-menu"><a href="<?php echo URL; ?>"><span>Главная</span></a>
            </div>
        </li>
        <li><a href="<?php echo URL; ?>notes"><i class="fa fa-book" aria-hidden="true"></i></a>
            <div class="sub-menu"><a href="<?php echo URL; ?>notes"><span>Журнал</span></a>
            </div>
        </li>
        <li><a href="<?php echo URL; ?>lists/select/groups"><i class="fa fa-users" aria-hidden="true"></i></a>
            <div class="sub-menu"><a href="<?php echo URL; ?>lists/select/groups"><span>Группы</span></a>
                <?php if($role=="admin"):?><ul><li><a href="<?=URL?>lists/add/groups">Добавить</a></li></ul> <?php endif; ?>
            </div>
        </li>
        <li><a href="<?php echo URL; ?>lists/select/students"><i class="fa fa-graduation-cap" aria-hidden="true"></i></a>
            <div class="sub-menu"><a href="<?php echo URL; ?>lists/select/students"><span>Студенты</span></a>
                <?php if($role=="admin"):?><ul><li><a href="<?=URL?>lists/add/students">Добавить</a></li></ul><?php endif; ?>
            </div>
        </li>
        <li><a href="<?php echo URL; ?>lists/select/parents"><i class="fa fa-eye" aria-hidden="true"></i></a>
            <div class="sub-menu"><a href="<?php echo URL; ?>lists/select/parents"><span>Родители</span></a>
                <?php if($role=="admin"):?><ul><li><a href="<?=URL?>lists/add/parents">Добавить</a></li></ul><?php endif; ?>
            </div>
        </li>
        <li><a href="<?php echo URL; ?>lists/select/teachers"><i class="fa fa-suitcase" aria-hidden="true"></i></a>
            <div class="sub-menu"><a href="<?php echo URL; ?>lists/select/teachers"><span>Преподаватели</span></a>
                <?php if($role=="admin"):?><ul><li><a href="<?=URL?>lists/add/teachers">Добавить</a></li></ul><?php endif; ?>
            </div>
        </li>
        <li><a href="<?php echo URL; ?>lists/select/subjects"><i class="fa fa-flask" aria-hidden="true"></i></a>
            <div class="sub-menu"><a href="<?php echo URL; ?>lists/select/subjects"><span>Дисциплины</span></a>
                <?php if($role=="admin"):?><ul><li><a href="<?=URL?>lists/add/subjects">Добавить</a></li></ul><?php endif; ?>
            </div>
        </li>
        <li><a href="<?php echo URL; ?>lists/select/specialties"><i class="fa fa-crosshairs" aria-hidden="true"></i></a>
            <div class="sub-menu"><a href="<?php echo URL; ?>lists/select/specialties"><span>Специальности</span></a>
                <?php if($role=="admin"):?><ul><li><a href="<?=URL?>lists/add/specialties">Добавить</a></li></ul><?php endif; ?>
            </div>
        </li>
        <?php if(Session::get("role")=="admin"):?>
            <li><a href="<?php echo URL; ?>settings"><i class="fa fa-cog" aria-hidden="true"></i></a>
                <div class="sub-menu"><a href="<?php echo URL; ?>options"><span>Настройки</span></a>
                </div>
            </li>
        <?php endif; ?>
    </ul>
</div>
<div id="main-panel">
    <div id="container">
<?php endif;?>