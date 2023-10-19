<?php

class Patos extends Controller {

    function __construct() {
        parent::__construct();
        $this->view->js = array();
		$this->view->css = array();
    }
    
    function index() {
        $this->view->title = "Manuteção dos Patos";
        /*Os array push devem ser feitos antes de instanciar o header e footer.*/
        array_push($this->view->js, "views/patos/app.vue.js");
        array_push($this->view->css, "views/patos/app.vue.css");

        array_push($this->view->js, "public/components/modal/modal.vue.js");
        array_push($this->view->css, "public/components/modal/modal.vue.css");
        $this->view->render("header");
        $this->view->render("footer");
    }

    public function getPatos()
    {
        $this->model->getPatos();
    }

    public function getStatus()
    {
        $this->model->getStatus();
    }

    public function Operacao()
    {
        $this->model->Operacao();
    }
}