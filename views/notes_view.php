<?php
$model = new Model();
if($this->role == "student" || $this->role == "teacher" || $this->role == "parent"){
    $logID = $model->getReal($this->logID)->fetchObject()->id;
    $admin = 0;
}
else if($this->role == "admin") $admin = 1;
$tg=0; $sg = 0; $pg=0; $cg = 0;
$role = $this->role;
if(isset($this->index)):
    ?>
    <table class="main-table">
        <th>Курс</th><th>Группа</th><th>Специальность</th>
        <?php foreach($this->groups as $group): ?>
            <?php
            if($group->GrName!=""):
                if($role == "teacher"){
                    $tg = $model->db->query("SELECT * FROM groups_subjects 
                                             WHERE GroupID=$group->id AND TeachID=$logID")->rowCount();
                    $cg = $model->db->query("SELECT * FROM groups 
                                             WHERE id=$group->id AND CurID=$logID")->rowCount();
                }
                if($role == "student")
                    $sg = $model->db->query("SELECT * FROM students WHERE GrID=$group->id AND id=$logID")->rowCount();
                if($role == "parent")
                    $pg = $model->db->query("SELECT * FROM students WHERE GrID=$group->id AND ParentID=$logID")->rowCount();
                if($role == "teacher" && $tg!=0 || $role == "teacher" && $cg!=0
                    || $role == "student" && $sg!=0 || $role == "parent" && $pg!=0 || $admin >=1):
                    ?>
                    <tr data-href="<?=URL?>notes/group/<?=$group->id?>">
                        <td><?=$group->Course?></td>
                        <td><?=$group->GrName?></td>
                        <td><?=$group->SpecName?></td>
                    </tr>
                <?php endif; endif; endforeach; ?>
    </table>

    <?php
endif;
if(isset($this->viewGroup)):
    if($role == "teacher") {
        $tg = $model->db->query("SELECT * FROM groups_subjects WHERE GroupID=$this->group AND TeachID=$logID")->rowCount();
        $cg = $model->db->query("SELECT * FROM groups WHERE id=$this->group AND CurID=$logID")->rowCount();
    }
    if($role == "student")
        $sg = $model->db->query("SELECT * FROM students WHERE GrID=$this->group AND id=$logID")->rowCount();
    if($role == "parent")
        $pg = $model->db->query("SELECT * FROM students WHERE GrID=$this->group AND ParentID=$logID")->rowCount();
    if($role == "teacher" && $tg!=0 || $role == "teacher" && $cg!=0 || $role == "student" && $sg!=0 || $role == "parent" && $pg!=0 || $admin >=1):
        ?>
        <div style="background-color: #444; padding: 30px; display: inline-block;">
            <h1 style="color: #fff;">Журнал группы <?=$this->grObject[0]->Course?> <?=$this->grObject[0]->GrName?></h1>

            <?php
            if($admin>=1):
                echo '<p><a href="'.URL.'notes/subjectAdd/'.$this->group.'">
    <div class="list-add"><i class="fa fa-plus" aria-hidden="true" style="color: #dd5d42; font-size: 20px; "></i><span>добавить предмет группе</span></div>
    </a> </p>';
            endif;
            ?>
            <table style="margin-top: 10px;" class="main-table">
                <th>Дисциплина</th><th>Преподаватель</th>
                <?php if($role=="admin"): ?><th></th><th></th><?php endif; ?>
                <?php foreach($this->subjects as $subject): ?>
                    <?php if($subject->SubjName!=""):?>
                        <tr>
                            <td ><a href="<?=URL?>notes/lessons/<?=$subject->GroupID?>.<?=$subject->SubjID?>"><?=$subject->SubjName?></td>
                            <td ><?=$subject->TeachFIO?></a></td>
                            <?php
                            if($role=="admin"):

                                if($role=="admin"): echo '<td><a href="'.URL.'notes/subjectEdit/'.$subject->gsID.'">
                          <img src="'.URL.'public/images/list_edit.png" width="20">
                          </a></td>'; endif;

                                ?><td>
                                <img style="cursor: pointer" src="<?=URL?>public/images/list_del.png" width="20" onclick="conf('<?=URL?>notes/subjectDel/<?=$subject->gsID?>','');"></td>
                                <?php

                            endif;

                            ?>
                        </tr>
                    <?php endif; endforeach; ?>
            </table>
        </div>
        <?php
    else: header('Location: '.URL.'notes');
    endif;
endif;

if(isset($this->viewLessons)):
    $group = $this->args[0];
    if($role == "teacher") {
        $tg = $model->db->query("SELECT * FROM groups_subjects WHERE GroupID=$group AND TeachID=$logID")->rowCount();
        $cg = $model->db->query("SELECT * FROM groups WHERE id=$group AND CurID=$logID")->rowCount();
    }
    if($role == "student")
        $sg = $model->db->query("SELECT * FROM students WHERE GrID=$group AND id=$logID")->rowCount();
    if($role == "parent")
        $pg = $model->db->query("SELECT * FROM students WHERE GrID=$group AND ParentID=$logID")->rowCount();
    if($role == "teacher" && $tg!=0 || $role == "teacher" && $cg!=0 || $role == "student" && $sg!=0 || $role == "parent" && $pg!=0 || $admin >=1):
        echo '<h1>'.$this->subjectInfo[0]->GrName.'</h1>';
        echo '<h3>Дисциплина: '.$this->subjectInfo[0]->SubjName.'</h3>';
        echo '<h3>Преподаватель: '.$this->subjectInfo[0]->TeachFIO.'</h3>';
        echo '<a href="'.URL.'notes/marks/'.$this->args[0].'.'.$this->args[1].'">
        <div class="list-add new-line"><i class="fa fa-table" aria-hidden="true" style="color: #fff; font-size: 20px; "></i><span>Сводная таблица по предмету</span></div>
        </a>';
        $subject = $this->args[1];
        if($role == "teacher") {
            $ag = $model->db->query("SELECT * FROM groups_subjects WHERE GroupID=$group AND TeachID=$logID AND SubjID = $subject")->rowCount();
        }
        else if($role == "admin") $ag = 1;
        else $ag = 0;
        if(isset($ag) && $ag >= 1):
            echo '<a href="'.URL.'notes/newLesson/'.$this->args[0].'.'.$this->args[1].'.'.$this->subjectInfo[0]->TeachID.'">
        <div class="list-add"><i class="fa fa-plus" aria-hidden="true" style="color: #fff; font-size: 20px; "></i><span>Новая пара</span></div>
        </a>';
            endif;
        echo '<br>';
        ?>

        <table class="main-table">
            <th></th><th>Дата</th><th>Тема</th><th>Домашнее задание</th>
            <?php foreach($this->lessons as $lesson): ?>
                <tr data-href="<?=URL?>notes/marks/<?=$lesson->GroupID?>.<?=$lesson->SubjID?>.<?=$lesson->LessonID?>">
                    <td><?=$lesson->GrName?></td>
                    <td><?=$lesson->Date?></td>
                    <td><?=$lesson->Theme?></td>
                    <td><?=$lesson->Homework?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: header('Location: '.URL.'notes'); endif;  endif;

if(isset($this->viewMarks)):
    $i=0;
    $group = $this->group[0]->id;
    $subject = $this->arg[1];
    if($role == "teacher") {
        $ag = $model->db->query("SELECT * FROM groups_subjects WHERE GroupID=$group AND TeachID=$logID AND SubjID = $subject")->rowCount();
    }
    else if($admin >=1) $ag = 1;
    else $ag = 0;
    ?><script>window.access = <?=$ag?>;</script><?php
    if($role == "teacher") {
        $tg = $model->db->query("SELECT * FROM groups_subjects WHERE GroupID=$group AND TeachID=$logID")->rowCount();
        $cg = $model->db->query("SELECT * FROM groups WHERE id=$group AND CurID=$logID")->rowCount();
    }

    if($role == "student")
        $sg = $model->db->query("SELECT * FROM students WHERE GrID=$group AND id=$logID")->rowCount();
    if($role == "parent")
        $pg = $model->db->query("SELECT * FROM students WHERE GrID=$group AND ParentID=$logID")->rowCount();
    if($role == "teacher" && $tg!=0 || $role == "teacher" && $cg!=0 || $role == "student" && $sg!=0 || $role == "parent" && $pg!=0 || $admin >=1):
        ?>
        <?php if(isset($this->one)): ?>
        <h3>Оценки группы <?=$this->group[0]->GrName?> <?=$this->group[0]->Course?> курса, по дисциплине "<?=$this->subject[0]->SubjName?>"</h3>
        <table style="margin: 0;" class="form-table"><th>Дата</th><th>Тема</th><th>Домашнее задание</th>
            <tr><td><?=$this->lessons[0]->Date?></td><td><?=$this->lessons[0]->Theme?></td><td><?=$this->lessons[0]->Homework?></td></tr></table>
        <?php endif; ?>
        <?php if(!isset($this->one)):?>
        <h3>Сводная таблица оценок группы <?=$this->group[0]->GrName?> <?=$this->group[0]->Course?> курса, по дисциплине "<?=$this->subject[0]->SubjName?>"</h3>
        <div class="sort-marks">
            <div class="s-m new-line" id="week">За эту неделю</div>
            <div class="s-m" id="two-week">За две недели</div>
            <div class="s-m" id="month">За этот месяц</div>
            <div class="s-m" id="all">Всё</div>
        </div>
    <?php endif;?>
        <?php if($ag>=1) echo '<br><div class="new-line inf-message">Нажмите по ячейке для добавления оценки или пропуска<br>Только администратор может удалять оценки</div>'; ?>

        <?php
        if(isset($ag) && $ag >= 1):
            echo '<a href="'.URL.'notes/newLesson/'.$this->arg[0].'.'.$this->arg[1].'.'.$this->subjectInfo[0]->TeachID.'">
        <div class="list-add"><i class="fa fa-plus" aria-hidden="true" style="color: #fff; font-size: 20px; "></i><span>Новая пара</span></div>
        </a>';
        endif;
        echo '<br>';
        ?>

        <table style="max-width: 200px;" class="main-table">
            <th></th>
            <th>ФИО</th>
            <?php foreach ($this->students as $student):
                if($role == "teacher") {
                    $tg = $model->db->query("SELECT * FROM groups_subjects WHERE GroupID=$group AND TeachID=$logID")->rowCount();
                    $cg = $model->db->query("SELECT * FROM groups WHERE id=$group AND CurID=$logID")->rowCount();
                }
                if($role == "student")
                    $sg = $model->db->query("SELECT * FROM students WHERE students.id = $student->id AND GrID=$group AND id=$logID")->rowCount();
                if($role == "parent")
                    $pg = $model->db->query("SELECT * FROM students WHERE students.id = $student->id AND GrID=$group AND ParentID=$logID")->rowCount();
                if($role == "teacher" && $tg!=0 || $role == "teacher" && $cg!=0 || $role == "student" && $sg!=0 || $role == "parent" && $pg!=0 || $admin >=1):
                    $i++;?>
                    <tr><td><?=$i?></td><td style="border-right: 1px solid rgba(0,0,0,0.08)">
                            <?=$model->getSmallFIO($student->StudFIO)?>
                        </td></tr>
                <?php endif; endforeach; ?>
        </table>
        <?php $gsl = implode($this->arg,"."); ?>

        <table style="max-width: calc(100% - 210px)" class="main-table marks <?php if(isset($this->one)):?> single <?php endif; ?> no-new-line" data-gsl="<?=$gsl?>" >
            <thead>
            <?php
            foreach($this->lessons as $lesson){
                $date = new DateTime($lesson->Date);
                echo '<th class="mark" data-date="'.$lesson->Date.'">'.$date->Format('d.m').'</th>';
            }
            ?>
            <?php if(!isset($this->one)):?>  <th>Ср.балл</th>
                <th>н</th>
                <th>п</th>
                <th>б</th>
            <?php endif; ?>
            </thead>

            <?php
            foreach ($this->students as $student):
                $count = 0;
                $sum = 0;
                $b = 0;
                $n = 0;
                //$o =0;
                $p = 0;
                $average = 0;
                $ratio_n = 0;
                $ratio_p = 0;
                $ratio_b = 0;
                $ratio_o = 0;
                $less_count = 0;
                if($role == "teacher") {
                    $tg = $model->db->query("SELECT * FROM groups_subjects WHERE GroupID=$group AND TeachID=$logID")->rowCount();
                    $cg = $model->db->query("SELECT * FROM groups WHERE id=$group AND CurID=$logID")->rowCount();
                }
                if($role == "student")
                    $sg = $model->db->query("SELECT * FROM students WHERE students.id = $student->id AND GrID=$group AND id=$logID")->rowCount();
                if($role == "parent")
                    $pg = $model->db->query("SELECT * FROM students WHERE students.id = $student->id AND GrID=$group AND ParentID=$logID")->rowCount();
                if($role == "teacher" && $tg!=0 || $role == "teacher" && $cg!=0 || $role == "student" && $sg!=0 || $role == "parent" && $pg!=0 || $admin >=1):
                    ?>

                    <tr>
                        <?php foreach($this->lessons as $lesson):
                            $less_count++;

                            ?><td class="mark" style="border-right: 1px solid rgba(0,0,0,0.08)" data-date="<?=$lesson->Date?>" data-lesson="<?=$lesson->LessonID ?>"
                                  data-student="<?=$student->id ?>"><?php
                            foreach($this->marks as $mark):
                                if($mark->LessonID == $lesson->LessonID && $mark->StudID == $student->id) {
                                    if($mark->Mark != 0){
                                        echo '<span style="margin: 0 5px;">'.$mark->Mark.'</span>';
                                        $count++;
                                    }
                                    if($mark->Absent=="н") {
                                        $n++;
                                        echo "н";
                                    }
                                    if($mark->Absent=="п") {
                                        $p++;
                                        echo "п";
                                    }
                                    if($mark->Absent=="б") {
                                        $b++;
                                        echo "б";
                                    }
                                  /*  if($mark->Absent=="о") {
                                        $o++;
                                        echo "о";
                                    }*/
                                    $sum = $sum + $mark->Mark;
                                }
                            endforeach;
                            ?></td>

                        <?php endforeach;
                        if(!isset($this->one)):
                            if($count == 0) $average = 0;
                            else $average = $sum/$count;
                            if($n>0) $ratio_n = 100/($less_count/$n);
                            if($p>0) $ratio_p = 100/($less_count/$p);
                            if($b>0) $ratio_b = 100/($less_count/$b);
                           // if($o>0) $ratio_o = 100/($less_count/$o);
                            ?><td style="background: #e9e9e9; border-right: 1px solid rgba(0,0,0,0.08)">
                            <?=round($average, 1, PHP_ROUND_HALF_DOWN)?>
                            </td>
                            <td style="background: #e9e9e9;"><?=round($ratio_n,1, PHP_ROUND_HALF_DOWN)?>% (<?=$n?>/<?=$less_count?>)</td>
                            <td style="background: #e9e9e9;"><?=round($ratio_p,1, PHP_ROUND_HALF_DOWN)?>% (<?=$p?>/<?=$less_count?>)</td>
                            <td style="background: #e9e9e9;"><?=round($ratio_b,1, PHP_ROUND_HALF_DOWN)?>% (<?=$b?>/<?=$less_count?>)</td>

                        <?php endif; ?>
                    </tr>
                    <?php
                endif;
            endforeach;
            ?>
        </table>
    <?php else: header('Location: '.URL.'notes');
    endif;
endif;
if(isset($this->subjectAdd)){
    ?>
    <h2>Добавить дисциплину для <?=$this->Group[0]->GrName ?></h2>
    <form action="<?=URL ?>notes/confirmAdd/subject.<?=$this->Group[0]->id?>" method="post">
        <table class="form-table">

            <tr><td>Дисциплина:</td>
                <td><select required id="subjSelect" name="SubjID">
                        <?php foreach ($this->subjectsList as $obj):
                            $check = true;
                            foreach($this->groupsSubjects as $subject):
                                if($obj->id == $subject->SubjID) $check = false; ?>
                            <?php endforeach; ?>
                            <?php if($check == true): ?>
                            <option  value="<?=$obj->id?>"> <?= $obj->SubjName ?>
                            </option>
                        <?php endif; endforeach; ?>
                    </select></td>
            </tr>
            <tr><td>Преподаватель:</td>
                <td><select required id="teachersSelect" name="TeachID">
                        <?php if(isset($_POST['subj'])) $subj = $_POST['subj']; else $subj = 0; ?>
                        <?php if($subj != 0): ?>
                            <?php foreach ($this->teachersSubjects as $tSubj): ?>
                                <?php if($tSubj->SubjID == $subj): ?>
                                    <option value="<?=$tSubj->id?>"> <?= $tSubj->TeachFIO ?>
                                    </option>
                                <?php endif;?>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <option disabled>Сначала выберите дисциплинцу</option>
                        <?php endif; ?>
                    </select></td>
            </tr>
        </table>
        <p>
            <input class="submit1" type="submit" name="add-save" value="Сохранить и добавить ещё">
            <input class="submit2" type="submit" name="add" value="Сохранить">
        </p>
    </form>
    <?php
}
if(isset($this->subjectEdit)){
    ?>
    <h2>Редактировать дисциплину для <?=$this->args->GrName?></h2>
    <form action="<?=URL ?>notes/confirmEdit/<?=$this->args->gsID?>" method="post">
        <table class="form-table">

           <h1>
               <?= $this->args->SubjName ?>
           </h1>
            <tr><td>Преподаватель:</td>
                <?php $subj = $this->args->SubjID ?>
                <td><select required id="teachersSelect" name="TeachID">
                            <?php

                            foreach ($this->teachersSubjects as $tSubj): ?>
                                <?php $selected = ""; if($tSubj->id==$this->args->TeachID) $selected = "selected"; ?>
                                <?php if($tSubj->SubjID == $subj): ?>
                                    <option <?=$selected?> value="<?=$tSubj->id?>"> <?= $tSubj->TeachFIO ?>
                                    </option>
                                <?php endif;?>
                            <?php endforeach; ?>
                    </select></td>
            </tr>
        </table>
        <p>
            <input class="submit1" style="width: 200px" type="submit" name="add" value="Сохранить">
        </p>
    </form>
    <?php
}
if(isset($this->newLesson)){
    ?>
    <form method="post" action="<?=URL ?>notes/confirmAdd/lesson.<?=$this->args[0]?>.<?=$this->args[1]?>.<?=$this->args[2]?>">
        <h2>Добавить что-то</h2>
        <table class="main-table">
            <tr><td style="font-size: 20px; font-weight: bold;"><?=$this->groupInfo[0]->GrName?></td><td style="font-size: 20px; font-weight: bold;"><?=$this->subjectInfo[0]->SubjName?></td></tr>
            <tr><td>Дата</td><td><input required type="text" name="Date" value="<?php echo date("Y-m-d");?>"></td></tr>
            <tr><td>Тема: </td><td><input required type="text" name="Theme"></td></tr>
            <tr><td>Домашнее задание:</td><td><textarea required name="Homework" style="min-width: 300px; min-height: 120px;"></textarea></td></tr>
        </table>
        <p><input class="submit2" type="submit" name="add" value="Сохранить"></p>
    </form>
    <?php
}
/*<script type="text/javascript">
    $(document).ready(function () {

        $("#subjSelect").change(function () {
            var val = $("#subjSelect").val();
            $.post("",
                {
                    subj: val,
                },
                function(data){
                    $("body").html(data);
                    $("#subjSelect").val(val);
                });
        });
    });
</script>
*/
?>

