<?php

class Hospedeiro_Model extends Model
{
    public function __construct()
    {   
        parent::__construct();
    }

    public function getHospedeiros()
    {

        $sql = "SELECT H.CODHOSPEDEIRO, H.NOME, H.IDADE, H.SEXO, H.PESO, H.ALTURA, H.TIPO_SANGUINEO, H.CODSTATUS, (SELECT NOME FROM LABORATORIO.STATUS WHERE CODSTATUS = H.CODSTATUS) NOMESTATUS FROM LABORATORIO.HOSPEDEIRO H";

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

    public function getStatus()
    {

        $sql = "SELECT CODSTATUS, NOME
                FROM LABORATORIO.STATUS
                WHERE ATIVO = 'S'";
        
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

    public function Operacao()
    {
        $post = json_decode(file_get_contents('php://input'));

        if ($post->acao == 'Novo' || $post->acao == 'Editar') {
            if (empty($post->dados->NOME)) {
                $result = array(
                    'code' => 0,
                    'msg' => 'Por Favor, Coloque um nome para o Hospedeiro.'
                );
                echo json_encode($result);exit;
            }
    
            if (strlen($post->dados->NOME ?? '') < 5) {
                $result = array(
                    'code' => 0,
                    'msg' => 'Por Favor, Coloque um nome com mais de 5 caracteres.'
                );
                echo json_encode($result);exit;
            }
    
            if (empty($post->dados->SEXO)) {
                $result = array(
                    'code' => 0,
                    'msg' => 'Por Favor, Selecione um Sexo para o Hospedeiro.'
                );
                echo json_encode($result);exit;
            }
    
            if (($post->dados->IDADE ?? 0) < 1) {
                $result = array(
                    'code' => 0,
                    'msg' => 'Por Favor, Coloque uma idade, a Idade não pode ser menor que 0.'
                );
                echo json_encode($result);exit;
            }
    
            if (($post->dados->ALTURA ?? 0) < 0 || ($post->dados->ALTURA ?? 0) > 3) {
                $result = array(
                    'code' => 0,
                    'msg' => 'A Altura tem que ser maior que 0 e tem um limite de 3 metros.'
                );
                echo json_encode($result);exit;
            }
    
            if (empty($post->dados->TIPO_SANGUINEO)) {
                $result = array(
                    'code' => 0,
                    'msg' => 'Por Favor, Selecione um Tipo Sanguíneo para o Hospedeiro.'
                );
                echo json_encode($result);exit;
            }
    
            if (empty($post->dados->CODSTATUS)) {
                $result = array(
                    'code' => 0,
                    'msg' => 'Por Favor, Selecione um Status para o Hospedeiro.'
                );
                echo json_encode($result);exit;
            }
        }

        if ($post->acao == 'Novo') {

            $sql = "INSERT INTO LABORATORIO.HOSPEDEIRO (NOME, IDADE, SEXO, PESO, ALTURA, TIPO_SANGUINEO, CODSTATUS) VALUES
                (:NOME, :IDADE, :SEXO, :PESO, :ALTURA, :TIPO_SANGUINEO, :CODSTATUS)";

            //var_dump($post);exit;

            $insert = $this->db->insert($sql, array('NOME' => $post->dados->NOME, 'IDADE'=> intval($post->dados->IDADE), 'SEXO'=> $post->dados->SEXO, 'PESO'=> $post->dados->PESO, 'ALTURA' => floatval($post->dados->ALTURA), 'TIPO_SANGUINEO'=>$post->dados->TIPO_SANGUINEO, 'CODSTATUS' => $post->dados->CODSTATUS));

            if (!$insert) {
                $msg = array(
                    'code' => 0,
                    'msg' => 'Erro ao realizar operação.'
                );
                echo(json_encode($msg));exit;
            }
    
            $msg = array(
                'code' => 1,
                'msg' => 'Operação realizada com sucesso!.'
            );
            echo(json_encode($msg));exit;
        }

        if ($post->acao == 'Editar') {
            $sql = "UPDATE LABORATORIO.HOSPEDEIRO SET NOME = :NOME, IDADE = :IDADE, SEXO = :SEXO, PESO = :PESO, ALTURA = :ALTURA, TIPO_SANGUINEO = :TIPO_SANGUINEO, CODSTATUS = :CODSTATUS WHERE CODHOSPEDEIRO = :CODHOSPEDEIRO";

            $update = $this->db->update($sql, array('NOME' => $post->dados->NOME, 'IDADE'=> intval($post->dados->IDADE), 'SEXO'=> $post->dados->SEXO, 'PESO'=> $post->dados->PESO, 'ALTURA' => floatval($post->dados->ALTURA), 'TIPO_SANGUINEO'=>$post->dados->TIPO_SANGUINEO, 'CODSTATUS' => $post->dados->CODSTATUS, 'CODHOSPEDEIRO' => $post->dados->CODHOSPEDEIRO));

            if (!$update) {
                $msg = array(
                    'code' => 0,
                    'msg' => 'Erro ao realizar operação.'
                );
                echo(json_encode($msg));exit;
            }

            $msg = array(
                'code' => 1,
                'msg' => 'Operação realizada com sucesso!.'
            );
            echo(json_encode($msg));exit;
        }

        if ($post->acao == 'Excluir') {
            $sql = "DELETE FROM LABORATORIO.HOSPEDEIRO WHERE CODHOSPEDEIRO = :CODHOSPEDEIRO";
            $delete = $this->db->delete($sql, array('CODHOSPEDEIRO'=>$post->dados->CODHOSPEDEIRO));

            if (!$delete) {
                $msg = array(
                    'code' => 0,
                    'msg' => 'Erro ao realizar operação.'
                );
                echo(json_encode($msg));exit;
            }

            $msg = array(
                'code' => 1,
                'msg' => 'Operação realizada com sucesso!.'
            );
            echo(json_encode($msg));exit;
        }
    }
}