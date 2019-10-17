<?php
class Index_Model extends Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function iCount($type){
        if($type=='students') $sth = $this->db->query("SELECT * FROM $type WHERE students.StudFIO <> ''");
        if($type=='teachers') $sth = $this->db->query("SELECT * FROM $type WHERE teachers.TeachFIO <> ''");
        if($type=='subjects') $sth = $this->db->query("SELECT * FROM $type WHERE subjects.SubjName <> ''");
        if($type=='parents') $sth = $this->db->query("SELECT * FROM $type WHERE parents.ParFIO <> ''");
        if($type=='specialties') $sth = $this->db->query("SELECT * FROM $type WHERE specialties.SpecName <> ''");
        if($type=='groups') $sth = $this->db->query("SELECT * FROM $type WHERE groups.GrName <> ''");
        return $sth->rowCount();
    }
    public function collegeName(){
        $sth = $this->db->query("SELECT Value FROM settings WHERE Attribute = 'CollegeName'");
        return $result = $sth->fetch(PDO::FETCH_ASSOC)['Value'];
    }
    public function AVG(){
        $sql2 = "SELECT Avg(marks.Mark) AS AvgMark, students.StudFIO
                 FROM subjects INNER JOIN (students INNER JOIN (lessons INNER JOIN marks ON lessons.LessonID = marks.LessonID) ON students.id = marks.StudID) ON subjects.id = lessons.SubjID 
                  WHERE (((marks.Mark)<>0)) 
                  GROUP BY students.StudFIO;";
        $result2 = $this->db->query($sql2);
        return $result2->fetchAll(PDO::FETCH_OBJ);
    }
    public function AbsCount(){
        $sql2 = "SELECT COUNT(marks.Absent) AS AbsCount, students.StudFIO
                 FROM subjects INNER JOIN (students INNER JOIN (lessons INNER JOIN marks ON lessons.LessonID = marks.LessonID) ON students.id = marks.StudID) ON subjects.id = lessons.SubjID 
                  WHERE marks.Absent='н'
                  GROUP BY students.StudFIO ORDER BY AbsCount DESC";
        $result2 = $this->db->query($sql2);
        return $result2->fetchAll(PDO::FETCH_OBJ);
    }
    public function countNull(){
        $result1 = $this->db->query("SELECT * FROM students");
        $i=0;
        while($student = $result1->fetchObject()){
            $res3 = $this->db->query("SELECT count(marks.Mark) AS AvgMark
                  FROM subjects INNER JOIN (students INNER JOIN (lessons INNER JOIN marks ON lessons.LessonID = marks.LessonID) ON students.id = marks.StudID) ON subjects.id = lessons.SubjID 
                  WHERE students.id = $student->id GROUP BY students.StudFIO ");
            if(!isset($res3->fetch(PDO::FETCH_OBJ)->AvgMark)) $i++;
        }
        return $i-1; //1 студент нулевой
    }

}