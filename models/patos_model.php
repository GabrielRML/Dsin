<?php

class Patos_Model extends Model
{
    public function __construct()
    {   
        parent::__construct();
    }

    public function getPatos()
    {

        $sql = "SELECT P.CODPATO, P.NOME, P.DESCRICAO, P.FORCA, P.VELOCIDADE, P.INTELIGENCIA, P.POSSUI_CHIP, P.CODSTATUS, (SELECT NOME FROM LABORATORIO.STATUS WHERE CODSTATUS = P.CODSTATUS) NOMESTATUS FROM LABORATORIO.PATOS P";

        echo(json_encode($this->db->select($sql)));exit;
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
                    'msg' => 'Por Favor, Coloque um nome para o Pato.'
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
    
            if ((($post->dados->FORCA ?? 0) < 1 || ($post->dados->FORCA ?? 0) > 100) ||
                (($post->dados->VELOCIDADE ?? 0) < 1 || ($post->dados->VELOCIDADE ?? 0) > 100) ||
                (($post->dados->INTELIGENCIA ?? 0) < 1 || ($post->dados->INTELIGENCIA ?? 0) > 100))
            {
                $result = array(
                    'code' => 0,
                    'msg' => 'Erro ao validar nivel Força, Velocidade ou Inteligência. Nível dos abributos tem que estar entre 1 a 100.'
                );
                echo json_encode($result);exit;
            }
        }

        if ($post->acao == 'Novo') {

            $sql = "INSERT INTO LABORATORIO.PATOS (NOME, DESCRICAO, FORCA, VELOCIDADE, INTELIGENCIA, POSSUI_CHIP, CODSTATUS) VALUES
                (:NOME, :DESCRICAO, :FORCA, :VELOCIDADE, :INTELIGENCIA, :POSSUI_CHIP, :CODSTATUS)";

            $insert = $this->db->insert($sql, array('NOME' => $post->dados->NOME,'DESCRICAO'=> $post->dados->DESCRICAO ?? '', 'FORCA'=> $post->dados->FORCA, 'VELOCIDADE'=>$post->dados->VELOCIDADE, 'INTELIGENCIA'=>$post->dados->INTELIGENCIA, 'POSSUI_CHIP' => $post->dados->POSSUI_CHIP ? 'S':'N', 'CODSTATUS'=>$post->dados->CODSTATUS));

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
            $sql = "UPDATE LABORATORIO.PATOS SET NOME = :NOME, DESCRICAO = :DESCRICAO, FORCA = :FORCA, VELOCIDADE = :VELOCIDADE, INTELIGENCIA = :INTELIGENCIA, POSSUI_CHIP = :POSSUI_CHIP, CODSTATUS = :CODSTATUS
                WHERE CODPATO = :CODPATO";

            $update = $this->db->update($sql, array('NOME' => $post->dados->NOME,'DESCRICAO'=> $post->dados->DESCRICAO ?? '', 'FORCA'=> $post->dados->FORCA, 'VELOCIDADE'=>$post->dados->VELOCIDADE, 'INTELIGENCIA'=>$post->dados->INTELIGENCIA, 'POSSUI_CHIP'=>$post->dados->POSSUI_CHIP ? 'S':'N', 'CODSTATUS'=>$post->dados->CODSTATUS, 'CODPATO' => $post->dados->CODPATO));

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
            $sql = "DELETE FROM LABORATORIO.PATOS WHERE CODPATO = :CODPATO";
            $delete = $this->db->delete($sql, array('CODPATO'=>$post->dados->CODPATO));

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