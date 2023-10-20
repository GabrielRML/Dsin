<?php

class GostoMusical_Model extends Model
{
    public function __construct()
    {   
        parent::__construct();
    }

    public function getGenero()
    {
      
        $sql = "SELECT 
                    g.CODGENERO,
                    g.GENERO,
                    g.DESCRICAO,
                    g.FORCA,
                    g.VELOCIDADE,
                    g.INTELIGENCIA,
                    g.ATIVO
                FROM 
                    laboratorio.gosto_musical g";

        echo(json_encode($this->db->select($sql)));exit;
        
    }
    public function Operacao()
    {
        $post = json_decode(file_get_contents('php://input'));
        if($post->acao == 'Novo' || $post->acao == 'Editar'){

            if (empty($post->dados->GENERO) || empty($post->dados->FORCA) || empty($post->dados->VELOCIDADE) || 
                empty($post->dados->INTELIGENCIA)){
                $result = array(
                    'code' => 0,
                    'msg' => 'Campos com * são obrigatórios.'
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
            $sql = "INSERT INTO laboratorio.gosto_musical
                        (GENERO,
                        DESCRICAO,
                        FORCA,
                        VELOCIDADE,
                        INTELIGENCIA,
                        ATIVO)
                    VALUES
                        (:GENERO,
                        :DESCRICAO,
                        :FORCA,
                        :VELOCIDADE,
                        :INTELIGENCIA,
                        :ATIVO)";

            $insert = $this->db->insert($sql, array('GENERO' => $post->dados->GENERO,'DESCRICAO'=> $post->dados->DESCRICAO ?? '', 'FORCA'=> $post->dados->FORCA, 'VELOCIDADE'=>$post->dados->VELOCIDADE, 'INTELIGENCIA'=>$post->dados->INTELIGENCIA, 'ATIVO'=>$post->dados->ATIVO ? 'S':'N'));

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
            
            $sql = "UPDATE 
                        laboratorio.gosto_musical
                    SET
                        GENERO = :GENERO,
                        DESCRICAO = :DESCRICAO,
                        FORCA = :FORCA,
                        VELOCIDADE = :VELOCIDADE,
                        INTELIGENCIA = :INTELIGENCIA,
                        ATIVO = :ATIVO
                    WHERE 
                        CODGENERO = :CODGENERO";

            $update = $this->db->update($sql, array('GENERO' => $post->dados->GENERO,'DESCRICAO'=> $post->dados->DESCRICAO ?? '', 'FORCA'=> $post->dados->FORCA, 'VELOCIDADE'=>$post->dados->VELOCIDADE, 'INTELIGENCIA'=>$post->dados->INTELIGENCIA, 'ATIVO'=>$post->dados->ATIVO ? 'S':'N', 'CODGENERO' => $post->dados->CODGENERO));

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

        if ($post->acao == 'Deletar') {
            $sql = "DELETE FROM laboratorio.gosto_musical WHERE CODGENERO = :CODGENERO";

            $delete = $this->db->delete($sql, array('CODGENERO' => $post->dados->CODGENERO));

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