<?php
if(isset($this->select)) { //если выбрали, что-то для отображения, активируем выборку
    $role =  Session::get("role");
    if($this->select=="groups" && $role=="admin" ||
        $this->select=="students" && $role=="admin" ||
        $this->select=="teachers" && $role=="admin" ||
        $this->select=="parents" && $role=="admin" ||
        $this->select=="subjects" && $role=="admin" ||
        $this->select=="specialties" && $role=="admin"){
    echo '<a href="'.URL.'lists/add/'.$this->select.'">
    <div class="list-add"><i class="fa fa-plus" aria-hidden="true" style="color: #dd5d42; font-size: 20px; "></i><span>добавить</span></div>
    </a><br>';
    }
    echo '<table class="main-table">';
    switch ($this->select) { //что конкретно будем отображать в таблицу
        case "students":
            echo '<thead><th>ФИО студента</th><th>Группа студента</th><th>Родитель студента</th>';
            if($role=="admin") echo '<th></th><th></th>';
            echo '</thead>';
            foreach ($this->list as $list) {
                if($list->StudFIO != "") {
                    echo '<tr>';
                    echo '<td><a href="' . URL . 'lists/info/students.' . $list->id . '">' . $list->StudFIO . '</a></td>';
                    echo '<td><a href="' . URL . 'lists/info/groups.' . $list->GrID . '">' . $list->GrName . '</a></td>';
                    echo '<td>' . $list->ParFIO . '</td>';
                    if($role=="admin"): echo '<td><a href="'.URL.'lists/edit/'.$this->select.'.'.$list->id.'">
                          <img src="'.URL.'public/images/list_edit.png" width="20">
                          </a></td>';
                    ?><td>
                    <img src="<?=URL?>public/images/list_del.png" width="20" onclick="conf('<?=URL?>lists/del/<?=$this->select?>.<?=$list->id?>','');"></td>
                    <?php
                        endif;
                    echo '</tr>';
                }
            }
            break;
        case "groups":
            echo '<th>Курс</th><th>Группа</th><th>Специальность</th><th>Куратор</th><th>Староста</th>';
            if($role=="admin") echo '<th></th><th></th>';
            foreach ($this->list as $list) {
                    if ($list->GrName != "") {
                        echo '<tr>';
                        echo '<td>'.$list->Course.'</td>';
                        echo '<td><a href="' . URL . 'lists/info/groups.' . $list->id . '">' . $list->GrName . '</a></td>';
                        echo '<td><a href="' . URL . 'lists/info/specialties.' . $list->SpecID . '">' . $list->SpecName . '</a></td>';
                        echo '<td><a href="' . URL . 'lists/info/teachers.' . $list->CurID . '">' . $list->TeachFIO . '</a></td>';
                        echo '<td><a href="' . URL . 'lists/info/students.' . $list->StewID . '">' . $list->StudFIO . '</a></td>';
                        if($role=="admin"):
                        echo '<td><a href="' . URL . 'lists/edit/' . $this->select . '.' . $list->id . '">
                          <img src="' . URL . 'public/images/list_edit.png" width="20">
                          </a></td>';
                        ?><td>
                        <img src="<?=URL?>public/images/list_del.png" width="20" onclick="conf('<?=URL?>lists/del/<?=$this->select?>.<?=$list->id?>','group');"></td>
                        <?php
                            endif;
                        echo '</tr>';
                    }
            }
            break;
        case "teachers":
            echo '<th>ФИО преподавателя</th>';
            if($role=="admin") echo '<th></th><th></th>';
            foreach ($this->list as $list){
                if($list->TeachFIO != "") {
                    echo '<tr>';
                    echo '<td><a href="' . URL . 'lists/info/teachers.' . $list->id . '">' . $list->TeachFIO . '</a></td>';
                    if($role=="admin"):
                    echo '<td><a href="'.URL.'lists/edit/'.$this->select.'.'.$list->id.'">
                          <img src="'.URL.'public/images/list_edit.png" width="20">
                          </a></td>';
                    ?><td>
                    <img src="<?=URL?>public/images/list_del.png" width="20" onclick="conf('<?=URL?>lists/del/<?=$this->select?>.<?=$list->id?>','');"></td>
                    <?php
                        endif;
                    echo '</tr>';
                }
            }
            break;
        case "parents":
            echo '<th>ФИО родителя</th>';
            if($role=="admin") echo '<th></th><th></th>';
            foreach ($this->list as $list){
                if($list->ParFIO != "") {
                    echo '<tr>';
                    echo '<td><a href="' . URL . 'lists/info/parents.' . $list->id . '">' . $list->ParFIO . '</a></td>';
                    if($role=="admin"):
                    echo '<td><a href="'.URL.'lists/edit/'.$this->select.'.'.$list->id.'">
                          <img src="'.URL.'public/images/list_edit.png" width="20">
                          </a></td>';
                    ?><td>
                    <img src="<?=URL?>public/images/list_del.png" width="20" onclick="conf('<?=URL?>lists/del/<?=$this->select?>.<?=$list->id?>','');"></td>
                    <?php
                        endif;
                    echo '</tr>';
                }
            }
            break;

        case "subjects":
            echo '<th>Название предмета</th>';
            if($role=="admin") echo '<th></th><th></th>';
            foreach ($this->list as $list){
                if($list->SubjName != "") {
                    echo '<tr>';
                    echo '<td><a href="' . URL . 'lists/info/subjects.' . $list->id . '">' . $list->SubjName . '</a></td>';
                    if($role=="admin"):
                    echo '<td><a href="'.URL.'lists/edit/'.$this->select.'.'.$list->id.'">
                          <img src="'.URL.'public/images/list_edit.png" width="20">
                          </a></td>';
                          ?><td>
                          <img src="<?=URL?>public/images/list_del.png" width="20" onclick="conf('<?=URL?>lists/del/<?=$this->select?>.<?=$list->id?>','');"></td>
                    <?php
                        endif;
                    echo '</tr>';
                }
            }
            break;
        case "specialties":
            echo '<th>Название специальности</th><th>Код специальности</th>';
            if($role=="admin") echo '<th></th><th></th>';
            foreach ($this->list as $list){
                if($list->SpecName != "") {
                    echo '<tr>';
                    echo '<td>' . $list->SpecName . '</td>';
                    echo '<td>' . $list->SpecCode . '</td>';
                    if($role=="admin"):
                    echo '<td><a href="'.URL.'lists/edit/'.$this->select.'.'.$list->id.'">
                          <img src="'.URL.'public/images/list_edit.png" width="20">
                          </a></td>';
                    ?><td>
                    <img src="<?=URL?>public/images/list_del.png" width="20" onclick="conf('<?=URL?>lists/del/<?=$this->select?>.<?=$list->id?>','');"></td>
                    <?php
                        endif;
                    echo '</tr>';
                }
            }
            break;
        default:
            echo "Ничего не выбрано";

    }
    echo '</table>';
}

else if(isset($this->add_edit)){
    if(isset($this->old)) $latest = $this->old[0];
    if(isset($latest)):
        ?><form action="<?=URL ?>lists/confirmEdit/<?=$this->add_edit?>.<?=$latest->id?>" method="post"><?php
    else:
        ?><form action="<?=URL ?>lists/confirmAdd/<?=$this->add_edit?>" method="post"><?php
    endif;
    switch ($this->add_edit){
        case "groups":
            ?>
            <?php if(isset($latest)):?>
            <h2>Изменить группу</h2>
            <?php else:?>
            <h2>Добавить группу</h2>
            <?php if(isset($_GET['good'])): ?>
                <div style=" background: #fff; padding: 0 5px; float: left; margin: 5px 0 0 0; line-height: 44px;">Успешно добавлено</div>
            <?php endif; ?>
            <?php endif;?>
            <table class="form-table">
                <tr><td>Курс:</td>
                    <td><select name="Course">
                            <?php for ($i=1; $i<=4; $i++):?>
                                <option
                                    <?php if(isset($latest) && $i==$latest->Course) echo "selected"; ?>
                                    value="<?=$i?>"><?=$i?>
                                </option>
                            <?php endfor; ?>
                        </select></td>
                </tr>
                <tr><td>Группа:</td>
                    <td>
                        <input placeholder="Например: ПКС5" autofocus <?php if(isset($latest)): ?>value="<?=$latest->GrName?>"<?php endif;?> required name="GrName">
                    </td></tr>
                <tr><td>Специальность:</td>
                    <td><select name="SpecID">
                        <?php foreach ($this->specList as $obj): ?>
                             <option
                                 <?php if(isset($latest) && $obj->id==$latest->SpecID) echo "selected"; ?>
                                 value="<?=$obj->id?>"> <?= $obj->SpecName ?>
                             </option>
                        <?php endforeach; ?>
                    </select></td>
                </tr>
                <tr><td>Куратор:</td>
                    <td><select name="CurID">
                            <?php foreach ($this->teachersList as $obj): ?>
                                <option
                                    <?php if(isset($latest) && $obj->id==$latest->CurID) echo "selected"; ?>
                                    value="<?=$obj->id?>"> <?= $obj->TeachFIO ?>
                                </option>
                            <?php endforeach; ?>
                        </select></td>
                </tr>
                <tr><td>Староста:</td>
                    <td><select name="StewID">
                            <?php foreach ($this->studentsList as $obj): ?>
                                <option
                                    <?php if(isset($latest) && $obj->id==$latest->StewID) echo "selected"; ?>
                                    value="<?=$obj->id?>"> <?= $obj->StudFIO ?>
                                </option>
                            <?php endforeach; ?>
                        </select></td>
                </tr>
            </table>

            <?php
            break;
        case "students":
            ?>
            <?php if(isset($latest)):?>
            <h2>Изменить студента</h2>
        <?php else:?>
            <h2>Добавить студента</h2>
            <?php if(isset($_GET['good'])): ?>
                <div style=" background: #fff; padding: 0 5px; float: left; margin: 5px 0 0 0; line-height: 44px;">Успешно добавлено</div>
            <?php endif; ?>
        <?php endif;?>
            <table class="form-table">
                <tr>
                    <td>ФИО студента: </td>
                    <td><input autofocus <?php if(isset($latest)): ?>value="<?=$latest->StudFIO?>"<?php endif;?>  required name="StudFIO"></td>
                </tr>
                <tr><td>Группа студента: </td>
                    <td><select name="GrID">
                            <?php foreach ($this->groupsList as $obj): ?>
                                <option
                                    <?php if(isset($latest) && $obj->id==$latest->GrID) echo "selected"; ?>
                                    value="<?=$obj->id?>"> <?= $obj->GrName ?>
                                </option>
                            <?php endforeach; ?>
                        </select></td>
                </tr>
                <tr><td>Родитель студента: </td>
                    <td><select class="js-example-basic-single" name="ParentID">
                            <?php foreach ($this->parentsList as $obj): ?>
                                <option <?php if(isset($latest) && $obj->id==$latest->ParentID) echo "selected"; ?>
                                    value="<?=$obj->id?>"> <?= $obj->ParFIO ?>
                                </option>
                            <?php endforeach; ?>
                        </select></td>
                </tr>
               <?php if(!isset($latest)):?> <tr>
                    <td>E-mail:</td><td><input type="text" name="Email"></td>
                </tr>
                <?php endif; ?>
            </table>
            <?php
            break;
        case "teachers":
            ?>
            <?php if(isset($latest)):?>
            <h2>Изменить информацию о преподавателе</h2>
        <?php else:?>
            <h2>Добавить преподавателя</h2>
            <?php if(isset($_GET['good'])): ?>
                <div style=" background: #fff; padding: 0 5px; float: left; margin: 5px 0 0 0; line-height: 44px;">Успешно добавлено</div>
            <?php endif; ?>
        <?php endif;?>
            <table class="form-table">
                <tr><td>ФИО преподавателя: </td>
                    <td><input autofocus <?php if(isset($latest)): ?>value="<?=$latest->TeachFIO?>"<?php endif;?>  required name="TeachFIO"></td>
                </tr>
                <tr><td>Дисциплины:</td>
                <td>
                    <select name="subjects[]" multiple>
                        <?php foreach ($this->subjectsList as $obj): ?>
                            <?php
                            $check = "";
                            if(isset($latest)) {
                                foreach ($this->teachSubjects as $subject) {
                                    if ($subject->SubjID == $obj->id) $check = "selected";
                                }
                            }
                            ?>
                            <option <?=$check?> value="<?=$obj->id?>"> <?= $obj->SubjName ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </td>
                </tr>
                <?php if(!isset($latest)):?> <tr>
                    <td>E-mail:</td><td><input type="text" name="Email"></td>
                </tr>
                <?php endif; ?>
            </table>
            <?php
            break;
        case "parents":
            ?>
            <?php if(isset($latest)):?>
            <h2>Изменить информацию о родителе</h2>
        <?php else:?>
            <h2>Добавить родителя</h2>
            <?php if(isset($_GET['good'])): ?>
                <div style=" background: #fff; padding: 0 5px; float: left; margin: 5px 0 0 0; line-height: 44px;">Успешно добавлено</div>
            <?php endif; ?>
        <?php endif;?>
            <table class="form-table">
                <tr><td>ФИО родителя: </td>
                    <td><input autofocus <?php if(isset($latest)): ?>value="<?=$latest->ParFIO?>"<?php endif;?>  required name="ParentFIO"></td>
                </tr>
                <tr><td>Дети:</td>
                    <td>
                        <select name="childs[]" multiple>
                            <?php foreach ($this->studentsList as $obj): ?>
                                <?php
                                $check = "";
                                if(isset($latest)) {
                                    if ($latest->id == $obj->ParentID) $check = "selected";
                                }
                                ?>
                                <option <?=$check?> value="<?=$obj->id?>"> <?= $obj->StudFIO ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                </tr>
                <?php if(!isset($latest)):?> <tr>
                    <td>E-mail:</td><td><input type="text" name="Email"></td>
                </tr>

                <?php endif; ?>
            </table>
            <?php
            break;
        case "subjects":
            ?>
        <?php if(isset($latest)):?>
            <h2>Изменить информацию о дисциплине</h2>
        <?php else:?>
        <h2>Добавить дисциплину</h2>
        <?php if(isset($_GET['good'])): ?>
            <div style=" background: #fff; padding: 0 5px; float: left; margin: 5px 0 0 0; line-height: 44px;">Успешно добавлено</div>
        <?php endif; endif;?>
            <table class="form-table">
                <tr>
                    <td>Название дисциплины: </td>
                    <td><input autofocus <?php if(isset($latest)): ?>value="<?=$latest->SubjName?>"<?php endif;?>  required name="SubjName"></td>
                </tr>
            </table>
            <?php
            break;
        case "specialties":
            ?>
            <?php if(isset($latest)):?>
            <h2>Изменить информацию о специальносте</h2>
        <?php else:?>
            <h2>Добавить специальность</h2>
            <?php if(isset($_GET['good'])): ?>
                <div style=" background: #fff; padding: 0 5px; float: left; margin: 5px 0 0 0; line-height: 44px;">Успешно добавлено</div>
            <?php endif; ?>
        <?php endif;?>
            <table class="form-table">
                <tr><td>Название специальности: </td><td><input autofocus <?php if(isset($latest)): ?>value="<?=$latest->SpecName?>"<?php endif;?>  required name="SpecName"></td></tr>
                <tr><td>Код специальности: </td><td><input <?php if(isset($latest)): ?>value="<?=$latest->SpecCode?>"<?php endif;?>  required name="SpecCode"></td></tr>
            </table>
            <?php
            break;

    }
    ?>
    <p>
        <?php if(isset($latest)): else: ?><input class="submit1" type="submit" name="add-save" value="Сохранить и добавить ещё"><?php endif; ?>
        <input class="submit2" type="submit" name="add" value="Сохранить">
    </p>
    </form>
    <?php
}
    else if(isset($this->info)){
        $type = $this->args[0];


        switch ($type){
            case "groups":
                $attr = array("Курс:","Название:","Куратор:","Староста:","Специальность:","Код специальности:");
                $i=0;
                echo '<h2>Информация о группе</h2>';
                echo '<table class="form-table">';
                foreach ($this->mainInfo[0] as $mi):
                ?>
                    <tr>
                        <td style="font-weight: bold"><?=$attr[$i]?></td><td><?=$mi?></td>
                    </tr>
                <?php
                    $i++;
                endforeach;
                echo '</table>';
                echo '<table class="form-table no-new-line"><caption>Студенты</caption>';
                        foreach ($this->mainInfo[1] as $student):
                            ?>
                                <tr>
                                    <td <?php if($this->mainInfo[2] == $student->StudID):?>title="Староста"<?php endif; ?>><?=$student->StudFIO?>
                                    <?php if($this->mainInfo[2] == $student->StudID) echo " СТ" ?></td>

                                </tr>
                            <?php
                        endforeach;
                echo '</table>';
                break;


            case "students":
                $attr = array("ФИО:","Группа:","ФИО родителя:");
                $i=0;
                echo '<h2>Информация о студенте</h2>';
                echo '<table class="form-table">';
                    foreach ($this->mainInfo[0] as $mi):
                        ?>
                        <tr>
                            <td style="font-weight: bold"><?=$attr[$i]?></td><td><?=$mi?></td>
                        </tr>
                        <?php
                        $i++;
                    endforeach;
                echo '</table>';


                
                $acs = array(
                    "Средний бал по предметам",
                    "Прогулов по не уважительной причине",
                    "Прогулов по причине болезни",
                    "Прогулов по уважительной причине");
                for($i=0; $i<4; $i++) {
                    if($this->mainInfo[$i+1]!=null) {
                    echo '<table class="form-table no-new-line">';
                        echo '<caption>'.$acs[$i].'</caption>';
                        $j=0;
                        foreach ($this->mainInfo[$i + 1] as $mi):
                            ?>
                            <tr>
                                <td><?= $mi->SubjName ?></td>
                                <td><?= $mi->AvgMark ?><?php if($i!=0): ?>/<?=$this->mainInfo[5][$j]->AvgMark?><?php endif; ?></td>
                            </tr>
                            <?php
                        $j++;
                        endforeach;
                        echo '</table>';
                    }
                }
                if($this->mainInfo[2]==null && $this->mainInfo[3]==null && $this->mainInfo[4]==null){
                    echo '<table class="form-table no-new-line" ><tr><td>У студента нет пропусков.</td></tr></table>';
                }
                if($this->mainInfo[1]==null){
                    echo '<table class="form-table no-new-line"><tr><td>У студента нет оценок.</td></tr></table>';
                }





                break;


            case "teachers":
                $attr = array("ФИО:");
                $i=0;
                echo '<h2>Информация о преподавателе</h2>';
                echo '<table class="form-table">';
                    foreach ($this->mainInfo[0] as $mi):
                        ?>
                        <tr>
                            <td style="font-weight: bold"><?=$attr[$i]?></td><td><?=$mi?></td>
                        </tr>
                        <?php
                        $i++;
                    endforeach;
                echo '</table>';

                break;
            case "parents":
                break;
            case "subjects":
                break;
            case "specialties":
                break;

        }
    }
    else{
        echo $this->msg;
    }
?>
