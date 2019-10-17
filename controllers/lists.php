<?php
class Lists extends Controller{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->view->msg = "sd";
        $this->view->render('lists');
        //выведем объекты с выборкой из БД в "ВЬЮ"
    }
    public function getVars()
    {
        $this->view->specList = $this->model->select("specialties");
        $this->view->groupsList = $this->model->select("groups");
        $this->view->parentsList = $this->model->select("parents");
        $this->view->studentsList = $this->model->select("students");
        $this->view->teachersList = $this->model->select("teachers");
        $this->view->subjectsList = $this->model->select("subjects");
    }

    public function select($list="")
    {
        $arr = $this->model->select($list);
        $this->view->select = $list;
        $this->view->list = $arr;
        $this->view->render('lists');
    }
    public function add($list=""){
        if(session::get("role")=="admin"){
         $this->view->add_edit = $list;
         $this->view->render('lists');   
        }
        else header('Location: '.URL.'lists/select/'.$list);
    }
    public function edit($list=""){
        $list = explode(".",$list);
        if(session::get("role")=="admin"){
        $this->view->old = $this->model->select($list[0],$list[1]);
        $this->view->add_edit = $list[0];
        $this->view->id = $list[1];
        $this->view->teachSubjects = $this->model->selectSubjects($list[1],"teachers");
        $this->view->groupsSubjects = $this->model->selectSubjects($list[1],"groups");
        $this->view->render('lists');
        }
        else header('Location: '.URL.'lists/select/'.$list[0]);
    }
    public function info($arg){
        $this->view->info = true;
        $this->view->args = explode(".",$arg);
        if(explode(".",$arg)[1]!=null) {
            $type = explode(".", $arg)[0];
            if($this->model->info($arg)==null) header('Location: '.URL.'lists/select/'.$type);
            $this->view->mainInfo = $this->model->info($arg);
            $this->view->render('lists');
        }
        else header('Location: '.URL.'lists/select/'.explode(".",$arg)[0]);

    }
    public function selectSubjects($id,$table){

    }
    public function confirmAdd($arg)
    {
        $this->model->confirmAdd($arg);
        if(isset($_POST['add-save'])) header('Location: '.URL.'lists/add/'.$arg.'?good');
        else header('Location: '.URL.'lists/select/'.$arg);
    }
    public function confirmEdit($arg)
    {
        $this->model->confirmEdit($arg);
        $arg = explode(".", $arg)[0];
        header('Location: '.URL.'lists/select/'.$arg);
    }
    public function del($arg){
        $arg = explode(".",$arg);
        $this->model->del($arg);
        header('Location: '.URL.'lists/select/'.$arg[0]);
    }


}