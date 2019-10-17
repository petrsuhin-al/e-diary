<?php
class Notes_Model extends Model {

    public function __construct()
    {
        parent::__construct();
    }
    public function getGroups()
    {
        $result = $this->db->query("SELECT groups.*, specialties.SpecName, teachers.TeachFIO FROM groups, specialties, teachers 
                                    WHERE groups.SpecID = specialties.id AND teachers.id = groups.CurID
                                    ORDER BY groups.Course, specialties.SpecName, groups.GrName");
        return $result->fetchAll(PDO::FETCH_OBJ);
    }
    public function getGroupsSubjects($id="")
    {
        $result = $this->db->query("SELECT *, groups_subjects.id As gsID FROM groups_subjects 
                                    INNER JOIN subjects ON groups_subjects.SubjID = subjects.id
                                    INNER JOIN teachers ON groups_subjects.TeachID = teachers.id
                                    WHERE groups_subjects.GroupID = $id");
        return $result->fetchAll(PDO::FETCH_OBJ);
    }
    public function getArgs($id="")
    {
        $result = $this->db->query("SELECT *, groups_subjects.id As gsID FROM groups_subjects 
                                    INNER JOIN subjects ON groups_subjects.SubjID = subjects.id
                                    INNER JOIN groups ON groups.id = groups_subjects.GroupID
                                    INNER JOIN teachers ON groups_subjects.TeachID = teachers.id
                                    WHERE groups_subjects.id = $id");
        return $result->fetch(PDO::FETCH_OBJ);
    }
    public function getTeachersSubjects($id="")
    {
        $result = $this->db->query("SELECT * FROM teachers_subjects 
                                    INNER JOIN subjects ON teachers_subjects.SubjID = subjects.id
                                    INNER JOIN teachers ON teachers_subjects.TeachID = teachers.id");
        return $result->fetchAll(PDO::FETCH_OBJ);
    }
    public function getLessons($GrID, $SubjID, $lessonID="")
    {
        $sql = "SELECT * FROM lessons 
                                    INNER JOIN subjects ON lessons.SubjID = subjects.id
                                    INNER JOIN teachers ON lessons.TeachID = teachers.id
                                    INNER JOIN groups ON lessons.GroupID = groups.id
                                    WHERE groups.id = $GrID AND subjects.id = $SubjID ";
        if($lessonID!="") $sql .= "AND lessons.LessonID = $lessonID";
        if($lessonID=="") $sql .= "ORDER BY Date";
        $result = $this->db->query($sql);
        return $result->fetchAll(PDO::FETCH_OBJ);
    }
    public function subjectInfo($GrID, $SubjID)
    {
        $result = $this->db->query("SELECT *, teachers.id As TeachID FROM groups_subjects 
                                    INNER JOIN subjects ON groups_subjects.SubjID = subjects.id
                                    INNER JOIN teachers ON groups_subjects.TeachID = teachers.id
                                    INNER JOIN groups ON groups_subjects.GroupID = groups.id
                                    WHERE groups_subjects.GroupID = $GrID AND groups_subjects.SubjID = $SubjID");
        return $result->fetchAll(PDO::FETCH_OBJ);
    }
    public function getMarks($GrID, $SubjID, $lessonID="")
    {
        $sql = "SELECT * FROM marks
                                    INNER JOIN lessons ON marks.LessonID = lessons.LessonID
                                    INNER JOIN students ON marks.StudID = students.id
                                    WHERE lessons.GroupID = $GrID AND lessons.SubjID = $SubjID";
        if($lessonID!="") $sql .= "AND lessons.LessonID = $lessonID";
        $result = $this->db->query($sql);
        return $result->fetchAll(PDO::FETCH_OBJ);
    }
    public function confirmAdd($arg)
    {
        switch($arg[0]){
            case "subject":
                $sth = $this->db->prepare("INSERT INTO groups_subjects(GroupID, SubjID, TeachID) 
                                           VALUES (:GroupID,:SubjID,:TeachID)");
                $sth->execute(array(
                    ':GroupID' => $arg[1],
                    ':SubjID' => $_POST['SubjID'],
                    ':TeachID' => $_POST['TeachID'],
                ));
                if(isset($_POST['add-save'])) header('Location: '.URL.'notes/subjectAdd/'.$arg[1]);
                else header('Location: '.URL.'notes/group/'.$arg[1]);
                
                break;
            case "lesson":
                $sth = $this->db->prepare("INSERT INTO lessons(Theme,Homework,Date,GroupID,TeachID,SubjID)
                                            VALUES (:Theme, :Homework, :Datee, :GroupID, :TeachID, :SubjID)");
                $sth->execute(array(
                   ':Theme' => $_POST['Theme'],
                    ':Homework' => $_POST['Homework'],
                    ':Datee' => $_POST['Date'],
                    ':GroupID' => $arg[1],
                    ':TeachID' => $arg[3],
                    ':SubjID' => $arg[2]
                ));
                header('Location: '.URL.'notes/lessons/'.$arg[1].'.'.$arg[2]);
                break;
        }

    }
    public function confirmEdit($gsID)
    {
        $sth = $this->db->prepare("UPDATE groups_subjects SET groups_subjects.TeachID = :TeachID WHERE groups_subjects.id = $gsID");

        $sth->execute(array('TeachID'=>$_POST['TeachID']));
        $arg = $this->getArgs($gsID);
        header('Location: '.URL.'notes/group/'.$arg->GroupID);

    }
    public function addMark($args)
    {
        $sth = $this->db->prepare("INSERT INTO marks(LessonID, StudID, Mark, Absent) 
                                    VALUES (:LessonID, :StudID, :Mark, :Absent)");
        $sth->execute(array(
            ':LessonID' => $args[0],
            ':StudID' => $args[1],
            ':Mark' => $args[2],
            ':Absent' => $args[3]
        ));
        if(isset($args[6])) header('Location: '.URL.'notes/marks/'.$args[4].'.'.$args[5].'.'.$args[6]);
        else header('Location: '.URL.'notes/marks/'.$args[4].'.'.$args[5]);

    }
    
    public function delMark($args)
    {
        $sth = $this->db->prepare("DELETE FROM marks WHERE LessonID=:LessonID AND StudID=:StudID");
        $sth->execute(array(
            ':LessonID' => $args[0],
            ':StudID' => $args[1]
        ));
        if(isset($args[4])) header('Location: '.URL.'notes/marks/'.$args[2].'.'.$args[3].'.'.$args[4]);
        else header('Location: '.URL.'notes/marks/'.$args[2].'.'.$args[3]);
    }
    public function  subjectDel($args){
        $gc = $this->db->query("SELECT GroupID FROM groups_subjects WHERE groups_subjects.id = $args");
        $gc = $gc->fetchObject()->GroupID;
        $sth = $this->db->query("DELETE FROM groups_subjects WHERE groups_subjects.id = $args");
        header('Location:'.URL.'notes/group/'.$gc);
    }
}