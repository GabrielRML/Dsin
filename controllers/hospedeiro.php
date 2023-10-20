<?php

class Hospedeiro extends Controller {

    function __construct() {
        parent::__construct();
        $this->view->js = array();
		$this->view->css = array();
    }
    
    function index() {
        $this->view->title = "Hospedeiro";
        /*Os array push devem ser feitos antes de instanciar o header e footer.*/
        array_push($this->view->js, "views/hospedeiro/app.vue.js");
        array_push($this->view->css, "views/hospedeiro/app.vue.css");

        array_push($this->view->js, "public/components/modal/modal.vue.js");
        array_push($this->view->css, "public/components/modal/modal.vue.css");
        $this->view->render("header");
        $this->view->render("footer");
    }

    public function getHospedeiros()
    {
        $this->model->getHospedeiros();
    }

    public function getStatus()
    {
        $this->model->getStatus();
    }

    public function getGenerosMusicais()
    {
        $this->model->getGenerosMusicais();
    }

    public function getEsportes()
    {
        $this->model->getEsportes();
    }

    public function getJogosPreferidos()
    {
        $this->model->getJogosPreferidos();
    }

    public function get_Hospedeiro_Gosto_Musical()
    {
        $this->model->get_Hospedeiro_Gosto_Musical();
    }

    public function get_Hospedeiro_Esporte()
    {
        $this->model->get_Hospedeiro_Esporte();
    }

    public function get_Hospedeiro_Jogo()
    {
        $this->model->get_Hospedeiro_Jogo();
    }

    public function Operacao()
    {
        $this->model->Operacao();
    }

}