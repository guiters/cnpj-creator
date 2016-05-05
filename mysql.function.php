<?php

/*
 *  Sistema de administracao da rede Sou Patrao
 *  Desenvolvedor: Guilherme Camacho 
 *  Projeto: admin-system
 *  Versão do arquivo: 0.1
 *  Codificação do arquivo: UTF-8
 *  Nome do arquivo: mysql.function.php
 *  Data do arquivo: 15/12/2014
 *  Hora do arquivo: 21:23:28
 */

require_once 'mysql.class.php';

function numbertype($x) {
    if ($x % 2 == 0) {
        return true;
    } else {
        return FALSE;
    }
}

/*
 * Function init_data
 * 
 * Manipulação de dados da classe mysql
 * Retorna tudo que a classe mysql faz dependendo da ação que foi solicitada
 * Ações:
 * ### insert: ### 
 * $table = tabela solicitada
 * $data = array ordenado com os dados seguindo a ordem da base
 * ### update: ### 
 * $table = tabela solicitada
 * $data = array ordenado com os dados seguindo a ordem da base
 * $where = onde esta o dado para ser alterado
 * ### delete: ### 
 * $table = tabela solicitada
 * $where = onde esta o dado para ser apagado
 * ### select: ###
 * $table = tabela solicitada
 * $where = onde esta o dado para ser selecionado
 * ### check: ###
 * $table = tabela solicitada
 * $where = array dado 0 coluna na base e dado 1 dado para ser checado
 * 
 * @return TRUE or FALSE
 */

function init_data($action, $table, $data, $where = null) {
    $bd = new bd();
    if (isset($where)) {
        if (is_array($where)) {
            if (count($where) == 2) {
                $where2 = '' . $where[0] . '=' . '"' . $where[1] . '"';
            } else {
                $where2 = '';
                for ($i = 0; $i < count($where); $i++) {
                    if (numbertype($i)) {
                        $where2 .= $where[$i] . '=';
                    } elseif (!numbertype($i)) {
                        $where2 .= '"' . $where[$i] . '"';
                        if ($where[$i] != end($where)) {
                            $where2 .= ' AND ';
                        }
                    }
                }
            }
        }
        $where = $where2;
    }
    if ($action == 'insert') {
        $res = $bd->insert($table, $data);
    } else if ($action == 'update') {
        $res = $bd->update($table, $data, $where);
    } else if ($action == 'delete') {
        $res = $bd->delete($table, $where);
    } else if ($action == 'select') {
        $res = $bd->select($table, $where);
    } else if ($action == 'check') {
        $check = $bd->select($table, $where);
        if ($check != null) {
            $res = TRUE;
        } else {
            $res = FALSE;
        }
    }

    return $res;
}
