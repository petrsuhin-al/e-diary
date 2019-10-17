<?php
class Notes extends Controller{
    public $method;
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->view->index = true;
        $this->view->method = "main";
        $this->view->groups = $this->model->getGroups();
        $this->view->render('notes');
    }
    public function getVars()
    {
        $this->view->logID = Session::get('logId');
        $this->view->role = Session::get('role');
        $this->view->subjectsList = $this->model->select("subjects");
        $this->view->teachersList = $this->model->select("teachers");
    }

    public function group($GrID){
        $this->view->viewGroup = true;
        $this->view->subjects = $this->model->getGroupsSubjects($GrID);
        $this->view->group = $GrID;
        $this->view->grObject = $this->model->select("groups",$GrID);
        $this->view->method = "don't main";
        $this->view->render('notes');
    }

    public function lessons($arg)
    {
        $this->view->viewLessons = true;
        $arg = explode(".",$arg);
        $this->view->args = $arg;
        $this->view->subjectInfo = $this->model->subjectInfo($arg[0],$arg[1]);
        $this->view->lessons = $this->model->getLessons($arg[0], $arg[1]);
        $this->view->render('notes');
    }

    public function marks($arg)
    {
        $this->view->viewMarks = true;
        $arg = explode(".",$arg);
        $this->view->subjectInfo = $this->model->subjectInfo($arg[0],$arg[1]);
        $this->view->arg = $arg;
        if(isset($arg[2])) {
            $this->view->lessons = $this->model->getLessons($arg[0], $arg[1], $arg[2]);
            $this->view->one = "true";
        }
        else $this->view->lessons = $this->model->getLessons($arg[0], $arg[1]);
        $this->view->subject = $this->model->select("subjects",$arg[1]);
        $this->view->students = $this->model->select("students","",$arg[0]);
        $this->view->group = $this->model->select("groups",$arg[0]);
        $this->view->marks = $this->model->getMarks($arg[0], $arg[1]);
        $this->view->render('notes');
    }
    public function subjectAdd($args)
    {
        $this->view->subjectAdd = true;
        $this->view->groupsSubjects = $this->model->getGroupsSubjects($args);
        $this->view->teachersSubjects = $this->model->getTeachersSubjects($args);
        $this->view->GrID = $args;
        $this->view->Group = $this->model->select("groups",$args);
        $this->view->render('notes');
    }
    public function subjectEdit($args){
        $this->view->subjectEdit = true;
        $this->view->args = $this->model->getArgs($args);
        $this->view->teachersSubjects = $this->model->getTeachersSubjects($args);
        $this->view->render('notes');
    }
    public function subjectDel($args){
        $this->model->subjectDel($args);
    }
    public function newLesson($args){
        $this->view->newLesson = true;
        $args = explode(".",$args);
        $this->view->subjectInfo = $this->model->select("subjects",$args[1]);
        $this->view->groupInfo = $this->model->select("groups",$args[0]);
        $this->view->args = $args;
        $this->view->render('notes');
    }
    public function confirmAdd($args)
    {
        $args = explode(".",$args);
        $this->model->confirmAdd($args);
    }
    public function confirmEdit($gsID)
    {
        $this->model->confirmEdit($gsID);
    }
    public function addMark($args)
    {
        $args = explode(".",$args);
        $this->model->addMark($args);
    }
    public function delMark($args)
    {
        $args = explode(".",$args);
        $this->model->delMark($args);
    }
}