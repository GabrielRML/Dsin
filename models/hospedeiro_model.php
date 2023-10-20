<?php

class Hospedeiro_Model extends Model
{
    public function __construct()
    {   
        parent::__construct();
    }

    public function getHospedeiros()
    {

        $sql = "SELECT
                    X.CODHOSPEDEIRO, X.NOME, X.SEXO, X.IDADE, X.PESO, X.ALTURA, X.TIPO_SANGUINEO, X.CODSTATUS,
                    (SELECT NOME FROM LABORATORIO.STATUS WHERE CODSTATUS = X.CODSTATUS) NOMESTATUS,
                    AVG(X.FORCA) FORCA,
                    (CASE WHEN (X.PESO / (X.ALTURA * X.ALTURA)) > 29.9 THEN AVG(X.VELOCIDADE) - (AVG(X.VELOCIDADE) * (ROUND(((X.PESO / (X.ALTURA * X.ALTURA) - 29.9) / 29.9) * 100))/100) ELSE AVG(X.VELOCIDADE) END) VELOCIDADE,
                    AVG(X.INTELIGENCIA) INTELIGENCIA,
                    (SELECT COUNT(CODHOSPEDEIRO) FROM LABORATORIO.hospedeiro_esporte WHERE CODHOSPEDEIRO = X.CODHOSPEDEIRO) QTD_ESPORTE,
                    (SELECT COUNT(CODHOSPEDEIRO) FROM laboratorio.hospedeiro_gosto_musical WHERE CODHOSPEDEIRO = X.CODHOSPEDEIRO) QTD_GENERO_MUSICAL,
                    (SELECT COUNT(CODHOSPEDEIRO) FROM laboratorio.hospedeiro_jogo WHERE CODHOSPEDEIRO = X.CODHOSPEDEIRO) QTD_JOGO
                FROM (
                    SELECT H.CODHOSPEDEIRO, H.NOME, H.SEXO, H.IDADE, H.PESO, H.ALTURA, H.TIPO_SANGUINEO, H.CODSTATUS, GM.FORCA, GM.VELOCIDADE, GM.INTELIGENCIA
                    FROM LABORATORIO.HOSPEDEIRO H
                    LEFT JOIN LABORATORIO.HOSPEDEIRO_GOSTO_MUSICAL HGM ON
                        H.CODHOSPEDEIRO = HGM.CODHOSPEDEIRO
                    LEFT JOIN LABORATORIO.GOSTO_MUSICAL GM ON 
                        GM.CODGENERO = HGM.CODGENERO
                    WHERE
                        (GM.FORCA IS NOT NULL OR GM.VELOCIDADE IS NOT NULL OR GM.INTELIGENCIA IS NOT NULL)
                    UNION
                    SELECT H.CODHOSPEDEIRO, H.NOME, H.SEXO, H.IDADE, H.PESO, H.ALTURA, H.TIPO_SANGUINEO, H.CODSTATUS, E.FORCA, E.VELOCIDADE, E.INTELIGENCIA
                    FROM LABORATORIO.HOSPEDEIRO H
                    LEFT JOIN LABORATORIO.HOSPEDEIRO_ESPORTE HE ON
                        HE.CODHOSPEDEIRO = H.CODHOSPEDEIRO
                    LEFT JOIN LABORATORIO.ESPORTE E ON
                        E.CODESPORTE = HE.CODESPORTE
                    WHERE
                        (E.FORCA IS NOT NULL OR E.VELOCIDADE IS NOT NULL OR E.INTELIGENCIA IS NOT NULL)
                    UNION
                    SELECT H.CODHOSPEDEIRO, H.NOME, H.SEXO, H.IDADE, H.PESO, H.ALTURA, H.TIPO_SANGUINEO, H.CODSTATUS, J.FORCA, J.VELOCIDADE, J.INTELIGENCIA
                    FROM LABORATORIO.HOSPEDEIRO H
                    LEFT JOIN LABORATORIO.HOSPEDEIRO_JOGO HJ ON
                        HJ.CODHOSPEDEIRO = H.CODHOSPEDEIRO
                    LEFT JOIN LABORATORIO.JOGO J ON 
                        J.CODJOGO = HJ.CODJOGO
                    WHERE
                        (J.FORCA IS NOT NULL OR J.VELOCIDADE IS NOT NULL OR J.INTELIGENCIA IS NOT NULL)
                    ) X
                GROUP BY
                    X.CODHOSPEDEIRO";

        $result = $this->db->select($sql);

        if (!$result) {
            $result = array(
                'code' => 0,
                'msg' => 'Nenhum dado encontrado.'
            );
            echo(json_encode($result));exit;
        }

        foreach ($result as &$hospedeiro) {
            $hospedeiro['IDADE'] = intval($hospedeiro['IDADE']);
            $hospedeiro['QTD_GENERO_MUSICAL'] = intval($hospedeiro['QTD_GENERO_MUSICAL']);
            $hospedeiro['QTD_JOGO'] = intval($hospedeiro['QTD_JOGO']);
            $hospedeiro['QTD_ESPORTE'] = intval($hospedeiro['QTD_ESPORTE']);
            $hospedeiro['FORCA'] = floatval($hospedeiro['FORCA']);
            $hospedeiro['VELOCIDADE'] = floatval($hospedeiro['VELOCIDADE']);
            $hospedeiro['INTELIGENCIA'] = floatval($hospedeiro['INTELIGENCIA']);

            if ($hospedeiro['VELOCIDADE'] < 0)
                $hospedeiro['VELOCIDADE'] = 1;
            
            // Caso o hospedeiro pratique pelo menos um esporte
            if ($hospedeiro['QTD_ESPORTE'] > 0) {
                // Caso a idade for menor que 18
                if ($hospedeiro['IDADE'] < 18) {
                    // Incluindo velocidade e inteligência
                    $aux = $hospedeiro['QTD_ESPORTE'] * 0.03;
                    $hospedeiro['VELOCIDADE'] = $hospedeiro['VELOCIDADE'] + ($hospedeiro['VELOCIDADE'] * $aux);
                    $hospedeiro['FORCA'] = $hospedeiro['FORCA'] + ($hospedeiro['FORCA'] * $aux);
                    // Incluindo inteligência
                    $aux = $hospedeiro['QTD_ESPORTE'] * 0.04;
                    $hospedeiro['INTELIGENCIA'] = $hospedeiro['INTELIGENCIA'] + ($hospedeiro['INTELIGENCIA'] * $aux);
                }

                if ($hospedeiro['IDADE'] < 30) {
                    // Incluindo velocidade e inteligência
                    $aux = $hospedeiro['QTD_ESPORTE'] * 0.06;
                    $hospedeiro['VELOCIDADE'] = $hospedeiro['VELOCIDADE'] + ($hospedeiro['VELOCIDADE'] * $aux);
                    $hospedeiro['FORCA'] = $hospedeiro['FORCA'] + ($hospedeiro['FORCA'] * $aux);
                    // Incluindo inteligência
                    $aux = $hospedeiro['QTD_ESPORTE'] * 0.06;
                    $hospedeiro['INTELIGENCIA'] = $hospedeiro['INTELIGENCIA'] + ($hospedeiro['INTELIGENCIA'] * $aux);
                }

                if ($hospedeiro['IDADE'] > 30) {
                    // Incluindo velocidade e inteligência
                    $aux = $hospedeiro['QTD_ESPORTE'] * 0.04;
                    $hospedeiro['VELOCIDADE'] = $hospedeiro['VELOCIDADE'] + ($hospedeiro['VELOCIDADE'] * $aux);
                    $hospedeiro['FORCA'] = $hospedeiro['FORCA'] + ($hospedeiro['FORCA'] * $aux);
                    // Incluindo inteligência
                    $aux = $hospedeiro['QTD_ESPORTE'] * 0.05;
                    $hospedeiro['INTELIGENCIA'] = $hospedeiro['INTELIGENCIA'] + ($hospedeiro['INTELIGENCIA'] * $aux);
                }

                // Caso a idade for maior que 60 anos
                if ($hospedeiro['IDADE'] > 60) {
                    // Incluindo velocidade e inteligência
                    $aux = $hospedeiro['QTD_ESPORTE'] * 0.02;
                    $hospedeiro['VELOCIDADE'] = $hospedeiro['VELOCIDADE'] + ($hospedeiro['VELOCIDADE'] * $aux);
                    $hospedeiro['FORCA'] = $hospedeiro['FORCA'] + ($hospedeiro['FORCA'] * $aux);
                    // Incluindo inteligência
                    $aux = $hospedeiro['QTD_ESPORTE'] * 0.01;
                    $hospedeiro['INTELIGENCIA'] = $hospedeiro['INTELIGENCIA'] + ($hospedeiro['INTELIGENCIA'] * $aux);
                }
            }

            if ($hospedeiro['QTD_JOGO'] > 0) {
                // Caso a idade for menor que 18
                if ($hospedeiro['IDADE'] < 18) {
                    // Incluindo inteligência
                    $aux = $hospedeiro['QTD_JOGO'] * 0.04;
                    $hospedeiro['INTELIGENCIA'] = $hospedeiro['INTELIGENCIA'] + ($hospedeiro['INTELIGENCIA'] * $aux);
                }

                if ($hospedeiro['IDADE'] < 30) {
                    // Incluindo inteligência
                    $aux = $hospedeiro['QTD_JOGO'] * 0.06;
                    $hospedeiro['INTELIGENCIA'] = $hospedeiro['INTELIGENCIA'] + ($hospedeiro['INTELIGENCIA'] * $aux);
                }

                if ($hospedeiro['IDADE'] > 30) {
                    // Incluindo inteligência
                    $aux = $hospedeiro['QTD_JOGO'] * 0.05;
                    $hospedeiro['INTELIGENCIA'] = $hospedeiro['INTELIGENCIA'] + ($hospedeiro['INTELIGENCIA'] * $aux);
                }

                // Caso a idade for maior que 60 anos
                if ($hospedeiro['IDADE'] > 60) {
                    // Incluindo inteligência
                    $aux = $hospedeiro['QTD_JOGO'] * 0.01;
                    $hospedeiro['INTELIGENCIA'] = $hospedeiro['INTELIGENCIA'] + ($hospedeiro['INTELIGENCIA'] * $aux);
                }
            }

            if ($hospedeiro['QTD_GENERO_MUSICAL'] > 0) {
                // Caso a idade for menor que 18
                if ($hospedeiro['IDADE'] < 18) {
                    // Incluindo velocidade
                    $aux = $hospedeiro['QTD_GENERO_MUSICAL'] * 0.03;
                    $hospedeiro['VELOCIDADE'] = $hospedeiro['VELOCIDADE'] + ($hospedeiro['VELOCIDADE'] * $aux);
                    // Incluindo Força
                    $hospedeiro['FORCA'] = $hospedeiro['FORCA'] + ($hospedeiro['FORCA'] * ($aux/2));
                }

                if ($hospedeiro['IDADE'] < 30) {
                    // Incluindo velocidade
                    $aux = $hospedeiro['QTD_GENERO_MUSICAL'] * 0.05;
                    $hospedeiro['VELOCIDADE'] = $hospedeiro['VELOCIDADE'] + ($hospedeiro['VELOCIDADE'] * $aux);
                    // Incluindo Força
                    $hospedeiro['FORCA'] = $hospedeiro['FORCA'] + ($hospedeiro['FORCA'] * ($aux/2));
                }

                if ($hospedeiro['IDADE'] > 30) {
                    // Incluindo velocidade
                    $aux = $hospedeiro['QTD_GENERO_MUSICAL'] * 0.03;
                    $hospedeiro['VELOCIDADE'] = $hospedeiro['VELOCIDADE'] + ($hospedeiro['VELOCIDADE'] * $aux);
                    // Incluindo Força
                    $hospedeiro['FORCA'] = $hospedeiro['FORCA'] + ($hospedeiro['FORCA'] * ($aux/2));
                }

                // Caso a idade for maior que 60 anos
                if ($hospedeiro['IDADE'] > 60) {
                    // Incluindo velocidade
                    $aux = $hospedeiro['QTD_GENERO_MUSICAL'] * 0.02;
                    $hospedeiro['VELOCIDADE'] = $hospedeiro['VELOCIDADE'] + ($hospedeiro['VELOCIDADE'] * $aux);
                    // Incluindo Força
                    $hospedeiro['FORCA'] = $hospedeiro['FORCA'] + ($hospedeiro['FORCA'] * ($aux/2));
                }
            }

            // Limita os atributos no max 100
            if ($hospedeiro['VELOCIDADE'] > 100)
                $hospedeiro['VELOCIDADE'] = 100;
            if ($hospedeiro['FORCA'] > 100) 
                $hospedeiro['FORCA'] = 100;
            if ($hospedeiro['INTELIGENCIA'] > 100) 
                $hospedeiro['INTELIGENCIA'] = 100;

            // Para deixar os números inteiros
            $hospedeiro['FORCA'] = intval($hospedeiro['FORCA']);
            $hospedeiro['VELOCIDADE'] = intval($hospedeiro['VELOCIDADE']);
            $hospedeiro['INTELIGENCIA'] = intval($hospedeiro['INTELIGENCIA']);

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

    public function getGenerosMusicais()
    {
        $sql = "SELECT CODGENERO, GENERO
                FROM LABORATORIO.GOSTO_MUSICAL
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

    public function getEsportes()
    {
        $sql = "SELECT CODESPORTE, NOME
                FROM LABORATORIO.ESPORTE
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

    public function getJogosPreferidos()
    {
        $sql = "SELECT CODJOGO, NOME
                FROM LABORATORIO.JOGO
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

    public function get_Hospedeiro_Gosto_Musical()
    {
        $post = json_decode(file_get_contents('php://input'));

        $sql = "SELECT GM.CODGENERO, GM.GENERO
                FROM LABORATORIO.HOSPEDEIRO H
                LEFT JOIN LABORATORIO.HOSPEDEIRO_GOSTO_MUSICAL HGM ON
                    H.CODHOSPEDEIRO = HGM.CODHOSPEDEIRO
                LEFT JOIN LABORATORIO.GOSTO_MUSICAL GM ON 
                    GM.CODGENERO = HGM.CODGENERO
                WHERE
                    H.CODHOSPEDEIRO = :CODHOSPEDEIRO";

        $result = $this->db->select($sql, array('CODHOSPEDEIRO'=>intval($post->CODHOSPEDEIRO)));

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

    public function get_Hospedeiro_Esporte()
    {
        $post = json_decode(file_get_contents('php://input'));

        $sql = "SELECT E.CODESPORTE, E.NOME
                FROM LABORATORIO.HOSPEDEIRO H
                LEFT JOIN LABORATORIO.HOSPEDEIRO_ESPORTE HE ON
                    HE.CODHOSPEDEIRO = H.CODHOSPEDEIRO
                LEFT JOIN LABORATORIO.ESPORTE E ON
                    E.CODESPORTE = HE.CODESPORTE
                WHERE
                    H.CODHOSPEDEIRO = :CODHOSPEDEIRO";

        $result = $this->db->select($sql, array('CODHOSPEDEIRO'=>intval($post->CODHOSPEDEIRO)));

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

    public function get_Hospedeiro_Jogo()
    {
        $post = json_decode(file_get_contents('php://input'));

        $sql = "SELECT J.CODJOGO, J.NOME
                FROM LABORATORIO.HOSPEDEIRO H
                LEFT JOIN LABORATORIO.HOSPEDEIRO_JOGO HJ ON
                    HJ.CODHOSPEDEIRO = H.CODHOSPEDEIRO
                LEFT JOIN LABORATORIO.JOGO J ON 
                    J.CODJOGO = HJ.CODJOGO
                WHERE
                    H.CODHOSPEDEIRO = :CODHOSPEDEIRO";

        $result = $this->db->select($sql, array('CODHOSPEDEIRO'=>intval($post->CODHOSPEDEIRO)));

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

            $insert = $this->db->insert($sql, array('NOME' => $post->dados->NOME, 'IDADE'=> intval($post->dados->IDADE), 'SEXO'=> $post->dados->SEXO, 'PESO'=> $post->dados->PESO, 'ALTURA' => floatval($post->dados->ALTURA), 'TIPO_SANGUINEO'=>$post->dados->TIPO_SANGUINEO, 'CODSTATUS' => $post->dados->CODSTATUS));

            if (!$insert) {
                $msg = array(
                    'code' => 0,
                    'msg' => 'Erro ao realizar operação.'
                );
                echo(json_encode($msg));exit;
            }

            if (!empty($post->dados->GOSTO_MUSICAL)) {
                $sql = "DELETE FROM LABORATORIO.HOSPEDEIRO_GOSTO_MUSICAL WHERE CODHOSPEDEIRO = :CODHOSPEDEIRO";
                $delete = $this->db->delete($sql, array('CODHOSPEDEIRO'=>$post->dados->CODHOSPEDEIRO));

                for($i=0; $i < count($post->dados->GOSTO_MUSICAL); $i++) {
                    $sql = "INSERT INTO LABORATORIO.HOSPEDEIRO_GOSTO_MUSICAL (CODHOSPEDEIRO, CODGENERO) VALUES
                    ((SELECT MAX(CODHOSPEDEIRO) FROM LABORATORIO.HOSPEDEIRO), :CODGENERO)";
                    $insert = $this->db->delete($sql, array('CODGENERO' => $post->dados->GOSTO_MUSICAL[$i]->CODGENERO));
                }
            }

            if (!empty($post->dados->ESPORTES)) {
                $sql = "DELETE FROM LABORATORIO.HOSPEDEIRO_ESPORTE WHERE CODHOSPEDEIRO = :CODHOSPEDEIRO";
                $delete = $this->db->delete($sql, array('CODHOSPEDEIRO'=>$post->dados->CODHOSPEDEIRO));

                for($i=0; $i < count($post->dados->ESPORTES); $i++) {
                    $sql = "INSERT INTO LABORATORIO.HOSPEDEIRO_ESPORTE (CODHOSPEDEIRO, CODESPORTE) VALUES
                    ((SELECT MAX(CODHOSPEDEIRO) FROM LABORATORIO.HOSPEDEIRO), :CODESPORTE)";
                    $insert = $this->db->delete($sql, array('CODESPORTE' => $post->dados->ESPORTES[$i]->CODESPORTE));
                }
            }

            if (!empty($post->dados->HOSPEDEIRO_JOGO)) {
                $sql = "DELETE FROM LABORATORIO.HOSPEDEIRO_JOGO WHERE CODHOSPEDEIRO = :CODHOSPEDEIRO";
                $delete = $this->db->delete($sql, array('CODHOSPEDEIRO'=>$post->dados->CODHOSPEDEIRO));

                for($i=0; $i < count($post->dados->ESPORTES); $i++) {
                    $sql = "INSERT INTO LABORATORIO.HOSPEDEIRO_JOGO (CODHOSPEDEIRO, CODJOGO) VALUES
                    ((SELECT MAX(CODHOSPEDEIRO) FROM LABORATORIO.HOSPEDEIRO), :CODJOGO)";
                    $insert = $this->db->delete($sql, array('CODJOGO' => $post->dados->JOGOS_PREFERIDOS[$i]->CODJOGO));
                }
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

            if (!empty($post->dados->GOSTO_MUSICAL)) {
                $sql = "DELETE FROM LABORATORIO.HOSPEDEIRO_GOSTO_MUSICAL WHERE CODHOSPEDEIRO = :CODHOSPEDEIRO";
                $delete = $this->db->delete($sql, array('CODHOSPEDEIRO'=>$post->dados->CODHOSPEDEIRO));

                for($i=0; $i < count($post->dados->GOSTO_MUSICAL); $i++) {
                    if (empty($post->dados->GOSTO_MUSICAL[$i]->CODGENERO))
                        continue;
                    $sql = "INSERT INTO LABORATORIO.HOSPEDEIRO_GOSTO_MUSICAL (CODHOSPEDEIRO, CODGENERO) VALUES
                    (:CODHOSPEDEIRO, :CODGENERO)";
                    $insert = $this->db->insert($sql, array('CODHOSPEDEIRO'=> $post->dados->CODHOSPEDEIRO, 'CODGENERO' => $post->dados->GOSTO_MUSICAL[$i]->CODGENERO));
                }
            }

            if (!empty($post->dados->ESPORTES)) {
                $sql = "DELETE FROM LABORATORIO.HOSPEDEIRO_ESPORTE WHERE CODHOSPEDEIRO = :CODHOSPEDEIRO";
                $delete = $this->db->delete($sql, array('CODHOSPEDEIRO'=>$post->dados->CODHOSPEDEIRO));

                for($i=0; $i < count($post->dados->ESPORTES); $i++) {
                    if (empty($post->dados->ESPORTES[$i]->CODESPORTE))
                        continue;
                    $sql = "INSERT INTO LABORATORIO.HOSPEDEIRO_ESPORTE (CODHOSPEDEIRO, CODESPORTE) VALUES
                    (:CODHOSPEDEIRO, :CODESPORTE)";
                    $insert = $this->db->insert($sql, array('CODHOSPEDEIRO'=> $post->dados->CODHOSPEDEIRO, 'CODESPORTE' => $post->dados->ESPORTES[$i]->CODESPORTE));
                }
            }

            if (!empty($post->dados->JOGOS_PREFERIDOS)) {
                $sql = "DELETE FROM LABORATORIO.HOSPEDEIRO_JOGO WHERE CODHOSPEDEIRO = :CODHOSPEDEIRO";
                $delete = $this->db->delete($sql, array('CODHOSPEDEIRO'=>$post->dados->CODHOSPEDEIRO));

                for($i=0; $i < count($post->dados->ESPORTES); $i++) {
                    if (empty($post->dados->JOGOS_PREFERIDOS[$i]->CODJOGO))
                        continue;
                    $sql = "INSERT INTO LABORATORIO.HOSPEDEIRO_JOGO (CODHOSPEDEIRO, CODJOGO) VALUES
                    (:CODHOSPEDEIRO, :CODJOGO)";
                    $insert = $this->db->insert($sql, array('CODHOSPEDEIRO'=> $post->dados->CODHOSPEDEIRO, 'CODJOGO' => $post->dados->JOGOS_PREFERIDOS[$i]->CODJOGO));
                }
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