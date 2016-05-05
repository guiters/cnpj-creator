<?php

/* 
 *  Sistema de administracao da rede Sou Patrao
 *  Desenvolvedor: Guilherme Camacho 
 *  Projeto: admin-system
 *  Versão do arquivo: 0.1
 *  Codificação do arquivo: UTF-8
 *  Nome do arquivo: mysql.class.php
 *  Data do arquivo: 15/12/2014
 *  Hora do arquivo: 21:20:25
 */

class bd {

    public $base = 'empresas_brasil';
    protected $host = '127.0.0.1';
    protected $user = 'root';
    protected $pass = '';

    function connect($base = 'global') {
        $conecta2 = mysql_connect($this->host, $this->user, $this->pass, TRUE) or die(mysql_error());
        mysql_select_db($base, $conecta2) or die(mysql_error());
    }

    function select($table, $where = null) {
        $this->connect($this->base);

        $sql = 'SELECT * FROM ' . $table;

        if ($where == null) {
            $sql .= '';
        } else {
            $sql .= ' WHERE ' . $where;
        }0-
        $result = '';
        $res = mysql_query($sql) or die($this->fala($sql));
        while ($row = mysql_fetch_assoc($res)) {
            $result[] = $row;
        }
        return $result;
    }

    function select_distinct($table, $col, $where = null) {
        $this->connect($this->base);
        $sql = 'SELECT DISTINCT ' . $col . ' FROM ' . $table;

        if ($where == null) {
            $sql .= '';
        } else {
            $sql .= ' WHERE ' . $where;
        }
        $result = '';
        $res = mysql_query($sql) or die($this->fala($sql));
        while ($row = mysql_fetch_assoc($res)) {
            $result[] = $row;
        }
        return $result;
    }

    function select_inner($table1, $table2, $on, $where = null) {
        $this->connect($this->base);
        $sql = 'SELECT * FROM ' . $table1 . ' INNER JOIN ' . $table2 . ' ON ' . $on;

        if ($where == null) {
            $sql .= '';
        } else {
            $sql .= ' WHERE ' . $where;
        }
        $result = '';
        $res = mysql_query($sql) or die($this->fala($sql));
        while ($row = mysql_fetch_assoc($res)) {
            $result[] = $row;
        }
        return $result;
    }

    function insert($table, $data) {
        $this->connect($this->base);
        $sql = 'INSERT  INTO ' . $table . ' VALUES (';
        for ($i = 0; $i < count($data); $i++) {
            if (($i + 1) == count($data)) {
                $sql .= " '" . $data[$i] . "'";
            } elseif ($i == 0) {
                $sql .= "'" . $data[$i] . "'" . ", ";
            } else {
                $sql .= " '" . $data[$i] . "'" . ", ";
            }
        }
        $sql .=')';

        $res = mysql_query($sql) or die($this->fala($sql));

        if ($res) {
            return mysql_insert_id();
        } else {
            return FALSE;
        }
    }

    function update($table, $data, $where) {
        $this->connect($this->base);
        $b = 0;
        $query_a = array();
        $vars = array();
        $result = mysql_query("SELECT * FROM $table");

        for ($i = 0; $i < mysql_num_fields($result); $i++) {
            $vars[] = mysql_field_name($result, $b);
            $b++;
        }
        $sql = "";
        for ($i = 0; $i < count($data); $i++) {
            if (($i + 1) == count($data)) {
                $sql .= $vars[$i] . "='" . $data[$i] . "'";
            } else {
                $sql .= $vars[$i] . "='" . $data[$i] . "'" . ", ";
            }
        }

        $query = "UPDATE $table SET $sql WHERE $where";
        $res = mysql_query($query) or die($this->fala($sql));

        if ($res) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function delete($table, $where) {
        $this->connect($this->base);
        $sql = 'DELETE FROM ' . $table . ' WHERE ' . $where;

        $res = mysql_query($sql) or die($this->fala($sql));

        if ($res) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function fala($msg) {
        mysql_error();
        echo $msg;
    }

}
