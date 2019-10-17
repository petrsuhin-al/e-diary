<?php
class Index extends Controller{
      public function __construct()
      {
          parent::__construct();
          $this->loadModel("index");

      }

      public function index()
      {
          $this->view->studsCount = $this->model->iCount("students");
          $this->view->parentsCount = $this->model->iCount("parents");
          $this->view->groupsCount = $this->model->iCount("groups"); 
          $this->view->teachersCount = $this->model->iCount("teachers");
          $this->view->subjectsCount = $this->model->iCount("subjects"); 
          $this->view->specCount = $this->model->iCount("specialties"); 
          $this->view->collegeName = $this->model->collegeName();
          $this->view->avg = $this->model->avg();
          $this->view->AbsCount = $this->model->AbsCount();
          $this->view->countNull = $this->model->countNull();
          $this->view->render('index');
          /*$mail = $this->mail;
          
          $mail->addAddress('linki_98i@bk.ru');
          $mail->Subject = 'Test Mail Subject!';
          $mail->Body    = 'This is SMTP Email Test';

          $mail->send();*/

      }
      
  }