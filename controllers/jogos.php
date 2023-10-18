<?php

class Jogos extends Controller {

    function __construct() {
        parent::__construct();
        $this->view->js = array();
		$this->view->css = array();
    }
    
    function index() {
        $this->view->title = "Manuteção dos Jogos";
        /*Os array push devem ser feitos antes de instanciar o header e footer.*/
        array_push($this->view->js, "views/jogos/app.vue.js");
        array_push($this->view->css, "views/jogos/app.vue.css");

        array_push($this->view->js, "public/components/modal/modal.vue.js");
        array_push($this->view->css, "public/components/modal/modal.vue.css");
        $this->view->render("header");
        $this->view->render("footer");
    }

    public function getJogos()
    {
        $this->model->getJogos();
    }

    public function Operacao()
    {
        $this->model->Operacao();
    }
    
}