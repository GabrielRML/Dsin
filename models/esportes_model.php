<?php

class Esportes_Model extends Model
{
    public function __construct()
    {   
        parent::__construct();
    }

    public function getEsportes()
    {

        $sql = "SELECT CODESPORTE, NOME, DESCRICAO, FORCA, VELOCIDADE, INTELIGENCIA, ATIVO
                FROM LABORATORIO.ESPORTE";

        echo(json_encode($this->db->select($sql)));exit;
    }

    public function Operacao()
    {
        $post = json_decode(file_get_contents('php://input'));

        if (empty($post->dados->NOME)) {
            $result = array(
                'code' => 0,
                'msg' => 'Por Favor, Coloque um nome para o esporte.'
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

        if ($post->acao == 'Novo') {

            $sql = "INSERT INTO LABORATORIO.ESPORTE (NOME, DESCRICAO, FORCA, VELOCIDADE, INTELIGENCIA, ATIVO) VALUES
                (:NOME, :DESCRICAO, :FORCA, :VELOCIDADE, :INTELIGENCIA, :ATIVO)";

            $insert = $this->db->insert($sql, array('NOME' => $post->dados->NOME,'DESCRICAO'=> $post->dados->DESCRICAO ?? '', 'FORCA'=> $post->dados->FORCA, 'VELOCIDADE'=>$post->dados->VELOCIDADE, 'INTELIGENCIA'=>$post->dados->INTELIGENCIA, 'ATIVO'=>$post->dados->ATIVO ? 'S':'N'));

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
            $sql = "UPDATE LABORATORIO.ESPORTE SET NOME = :NOME, DESCRICAO = :DESCRICAO, FORCA = :FORCA, VELOCIDADE = :VELOCIDADE, INTELIGENCIA = :INTELIGENCIA, ATIVO = :ATIVO
                WHERE CODESPORTE = :CODESPORTE";

            $update = $this->db->update($sql, array('NOME' => $post->dados->NOME,'DESCRICAO'=> $post->dados->DESCRICAO ?? '', 'FORCA'=> $post->dados->FORCA, 'VELOCIDADE'=>$post->dados->VELOCIDADE, 'INTELIGENCIA'=>$post->dados->INTELIGENCIA, 'ATIVO'=>$post->dados->ATIVO ? 'S':'N', 'CODESPORTE' => $post->dados->CODESPORTE));

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
    }
}