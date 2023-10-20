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
                WHERE
                    X.CODSTATUS = 2 /* NÃO ELIMINADO */
                GROUP BY
                    X.CODHOSPEDEIRO
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
}