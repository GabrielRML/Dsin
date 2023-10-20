<?php

class Localizar_Pato_Model extends Model
{
    public function __construct()
    {   
        parent::__construct();
    }

    public function getPatos()
    {

        $sql = "SELECT P.CODPATO, P.NOME, P.DESCRICAO, P.FORCA, P.VELOCIDADE, P.INTELIGENCIA, P.POSSUI_CHIP, P.CODSTATUS, (SELECT NOME FROM LABORATORIO.STATUS WHERE CODSTATUS = P.CODSTATUS) NOMESTATUS
                FROM LABORATORIO.PATOS P
                WHERE P.POSSUI_CHIP = 'S'";

        $result = $this->db->select($sql);

        if (!$result) {
            $result = array(
                'code' => 0,
                'msg' => 'Nenhum dado encontrado.'
            );
            echo(json_encode($result));exit;
        }

        $result = array(
            'code' => 1,
            'data' => $result
        );
        echo(json_encode($result));exit;
    }

    public function getRandomHospedeiro()
    {

        $sql = "SELECT CODHOSPEDEIRO, NOME, IDADE, SEXO, ALTURA, TIPO_SANGUINEO, CODSTATUS
                FROM laboratorio.hospedeiro WHERE CODSTATUS = 2 /* NÃO ELIMINADO */
                ORDER BY RAND()
                LIMIT 1";
                
        $result = $this->db->select($sql);

        if (!$result) {
            $result = array(
                'code' => 0,
                'msg' => 'Nenhum dado encontrado.'
            );
            echo(json_encode($result));exit;
        }

        $result = array(
            'code' => 1,
            'data' => $result
        );
        echo(json_encode($result));exit;
    }
}