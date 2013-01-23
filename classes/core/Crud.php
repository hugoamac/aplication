<?php

class Crud {

    /**
     * Propriedade responsável por receber a tabela no pattern table data gateway
     * */
    protected $table;

    /**
     * Propriedade responsável por receber o objeto PDO
     * */
    protected $db;

    /**
     * Propriedade responsável por receber o objeto Pagination
     */
    public $pagination;

    /**
     * 
     * Propriedade responsável para receber a classe instanciada
     */
    private static $_instance = array();

    /**
     * 
     * @param type $conexao
     */
    private $_constantesSql = array("NULL", "IS NULL", "IS NOT NULL", "NOW()");

    public function __construct($conexao = BANCO) {

        $this->pagination = new Pagination();

        switch ($conexao) {

            case "ONLINE":

                try {
                    $this->db = new PDO("mysql:host=" . HOST_ONLINE . ";dbname=" . DATABASE_ONLINE, USER_ONLINE, PASS_ONLINE, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
                } catch (PDOException $e) {

                    print "Erro:" . $e->getMessage . "<br/>";
                    die();
                }
                break;
            default :
                try {
                    $this->db = new PDO("mysql:host=" . HOST . ";dbname=" . DATABASE, USER, PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
                } catch (PDOException $e) {

                    print "Erro:" . $e->getMessage . "<br/>";
                    die();
                }
                break;
        }
    }

    public function __destruct() {
        $this->closeDb();
    }

    public function closeDb() {

        $this->db = NULL;
    }

    /**
     * Método responsável para recuperar a instancai do Objeto PDO <br/>
     * @return object <b>PDO</b>
     * */
    public function getDb() {

        return $this->db;
    }

    /**
     * 
     * @param string $class é a classe a ser instanciada
     */
    protected static function getInstance($class) {

        if (isset(self::$_instance) || empty(self::$_instance)) {
            self::$_instance[$class] = new $class();
        }

        return self::$_instance[$class];
    }

    public function setTable($table) {

        $this->table = $table;
    }

    /**
     * Método responsável para inserir dados no banco<br/>
     * @param array $dados <p>os dados a serem inseridos</p>
     * @return <b>int</b> <p>Se os dados forem inseridos com sucesso
     * ou <b> false </b> caso contrário.</p>
     * */
    public function insert(Array $dados) {

        self::__construct();

        foreach ($dados as $col => $val) {
            if (!in_array($col, $this->describe())) {
                unset($dados[$col]);
            } elseif (empty($val)) {
                if (strlen($val) != 1) {
                    unset($dados[$col]);
                }
            }
        }

        $cols = array_keys($dados);
        $vals = array_values($dados);

        for ($i = 0; $i < count($vals); $i++) {
            $bind[$i] = "?";
        }

        $cols = implode(",", $cols);
        $bind = implode(",", $bind);
        //$vals = "'" . implode("','", $vals) . "'";

        $sql = "INSERT INTO `{$this->table}` ({$cols}) VALUES ({$bind}) ";

        $stm = $this->db->prepare($sql);

        if ($stm->execute($vals)) {

            $rs = (int) $this->db->lastInsertId();
            self::__destruct();

            return $rs;
        }
        self::__destruct();
        return FALSE;
    }

    /**
     * Método responsável para recupera somente uma linha no banco.<br/>
     * @param array $where <p>com os critério coluna valor</p>
     * @return <b>array</b> Se os dados forem encontrados
     * ou <b> FALSE </b> caso contrário.
     * */
    public function find(Array $where) {

        self::__construct();

        foreach ($where as $col => $val) {
            if (!in_array($col, $this->describe())) {
                unset($where[$col]);
            } else {
                //$campos[] = "{$col} = '{$val}'";
                $campos[] = "{$col} = ?";
                $bind[] = $val;
            }
        }

        $and = count($where) > 1 ? " and " : "";

        $where = "WHERE " . implode($and, $campos);


        $sql = " SELECT * FROM `{$this->table}` {$where} ";


        $q = $this->db->prepare($sql);
        $q->setFetchMode(PDO::FETCH_ASSOC);
        $q->execute($bind);
        $rs = $q->fetch();

        if ($rs) {
            foreach ($rs as $c => $v) {
                $rs[$c] = stripslashes($v);
            }
        }
        self::__destruct();
        return $rs;
    }

    /**
     * Método responsável para recupera um conjunto de linhas do banco<br/>
     * @param array $where <p>com os critério coluna valor</p>
     * @param array $operator <p>com os operadores coluna operador</p>
     * @param string $order <p>com os critério de ordenação da consulta</p>
     * @param string $limit <p>com o critério limite da consulta</p>
     * @param string $offset <p>com o critério intervalo de linhas</p>
     * @return <b>array array</b> Se os dados forem encontrados
     * ou <b> FALSE </b> caso contrário.
     * */
    public function findAll($where = array(), $operator = array(), $order = null, $limit = null, $offset = null) {

        self::__construct();

        if (count($where) > 0) {
            foreach ($where as $col => $val) {
                if (!in_array($col, $this->describe())) {
                    unset($where[$col]);
                } else {

                    if (isset($operator[$col])) {
                        //$campos[] = "{$col} {$operator[$col]} '{$val}'";

                        if (in_array($val, $this->_constantesSql)) {
                            $campos[] = "{$col} {$operator[$col]} $val";
                        } else {
                            $campos[] = "{$col} {$operator[$col]} ?";
                            $bind[] = $val;
                        }
                    } else {
                        //$campos[] = "{$col} = '{$val}'";

                        if (in_array($val, $this->_constantesSql)) {
                            $campos[] = "{$col} $val";
                        } else {
                            $campos[] = "{$col} = ?";
                            $bind[] = $val;
                        }
                    }
                }
            }

            $and = count($where) > 1 ? " and " : "";
            $where = "WHERE " . implode($and, $campos);
        }

        $where = ($where != null ? "{$where}" : "");
        $orderby = ($order != null ? "ORDER BY {$order}" : "");
        $limit = ($limit != null ? "LIMIT {$limit}" : "");
        $offset = ($offset != null ? "OFFSET {$offset}" : "");

        $sql = " SELECT * FROM `{$this->table}` {$where} {$orderby} {$limit} {$offset} ";

        $q = $this->db->prepare($sql);
        $q->setFetchMode(PDO::FETCH_ASSOC);
        $q->execute($bind);
        $rs = $q->fetchAll();

        if ($rs) {
            foreach ($rs as $c => $vv) {
                foreach ($vv as $a => $v) {
                    $rs[$c][$a] = stripslashes($v);
                }
            }
        }

        self::__destruct();
        return $rs;
    }

    public function Paginator($where = array(), $operator = array(), $order = null) {

        self::__construct();

        if (count($where) > 0) {
            foreach ($where as $col => $val) {
                if (!in_array($col, $this->describe())) {
                    unset($where[$col]);
                } else {

                    if (isset($operator[$col])) {
                        //$campos[] = "{$col} {$operator[$col]} '{$val}'";

                        if (in_array($val, $this->_constantesSql)) {
                            $campos[] = "{$col} {$operator[$col]} $val";
                        } else {
                            $campos[] = "{$col} {$operator[$col]} ?";
                            $bind[] = $val;
                        }
                    } else {
                        //$campos[] = "{$col} = '{$val}'";

                        if (in_array($val, $this->_constantesSql)) {
                            $campos[] = "{$col} $val";
                        } else {
                            $campos[] = "{$col} = ?";
                            $bind[] = $val;
                        }
                    }
                }
            }

            $and = count($where) > 1 ? " and " : "";
            $where = "WHERE " . implode($and, $campos);
        }

        $where = ($where != null ? "{$where}" : "");
        $orderby = ($order != null ? "ORDER BY {$order}" : "");

        $sql = " SELECT * FROM `{$this->table}` {$where} {$orderby}";

        $sql_count = str_replace("*", "COUNT(*) as COUNT_TOTAL", $sql);

        $res = $this->db->prepare($sql_count);
        $res->execute();
        $r = $res->fetch(PDO::FETCH_ASSOC);

        $total = (INT) $r["COUNT_TOTAL"];
        $this->pagination->setPaginators($total);

        $limit = " LIMIT {$this->pagination->getLimitPerPage()}";
        $offset = " OFFSET {$this->pagination->getQtde()}";

        $sql = " SELECT * FROM `{$this->table}` {$where} {$orderby} {$limit} {$offset}";

        $q = $this->db->prepare($sql);
        $q->setFetchMode(PDO::FETCH_ASSOC);
        $q->execute($bind);
        $rs = $q->fetchAll();

        if ($rs) {
            foreach ($rs as $c => $vv) {
                foreach ($vv as $a => $v) {
                    $rs[$c][$a] = stripslashes($v);
                }
            }
        }

        self::__destruct();
        return $rs;
    }

    /**
     * Método responsável para atualizar dados do banco<br/>
     * @param array $dados <p>com os dados a serem atualizados
     * @param array $where <p>com os critério coluna valor</p>
     * @param array $operator <p>com os operadores coluna operador</p>
     * @return <b>boolean TRUE</b> Se os dados forem atualizados
     * ou <b> FALSE </b> caso contrário.
     * */
    public function update(Array $dados, Array $where, $operator = array()) {
        self::__construct();

        $i = 1;
        foreach ($dados as $ind => $val) {

            if (!in_array($ind, $this->describe())) {
                unset($dados[$ind]);
            } elseif (empty($val)) {
                if (strlen($val) != 1) {
                    unset($dados[$ind]);
                } elseif (strlen($val) == 1) {
                    $campos[] = "{$ind} = ?";
                    $bind[$i++] = "0";
                }
            } else {
                //$campos[] = "{$ind} = '{$val}'";
                if (in_array($val, $this->_constantesSql)) {
                    $campos[] = "{$ind} = $val";
                } else {
                    $campos[] = "{$ind} = ?";
                    $bind[$i++] = $val;
                }
            }
        }

        foreach ($where as $col => $val) {
            if (!in_array($col, $this->describe())) {
                unset($where[$col]);
            } else {

                if (isset($operator[$col])) {
                    //$campos_where[] = "{$col} {$operator[$col]} '{$val}'";

                    if (in_array($val, $this->_constantesSql)) {
                        $campos_where[] = "{$col} {$operator[$col]} $val";
                    } else {
                        $campos_where[] = "{$col} {$operator[$col]} ?";
                        $bind[$i++] = $val;
                    }
                } else {
                    //$campos_where[] = "{$col} = '{$val}'";

                    if (in_array($val, $this->_constantesSql)) {
                        $campos_where[] = "{$col} $val";
                    } else {
                        $campos_where[] = "{$col} = ?";
                        $bind[$i++] = $val;
                    }
                }
            }
        }

        $and = count($where) > 1 ? " and " : "";
        $where = "WHERE " . implode($and, $campos_where);


        $campos = implode(", ", $campos);

        $sql = " UPDATE `{$this->table}` SET {$campos}  {$where} ";

        $stm = $this->db->prepare($sql);

        foreach ($bind as $simbolo => $valor) {
            $stm->bindValue($simbolo, $valor);
        }

        $rm = $stm->execute();
        self::__destruct();

        return $rm;
    }

    /**
     * Método responsável para excluir dados do banco<br/>
     * @param array $where <p>com os critério coluna valor</p>
     * @param array $operator <p>com os operadores coluna operador</p>
     * @return <b>boolean TRUE</b> Se os dados forem excluidos
     * ou <b> FALSE </b> caso contrário.
     * */
    public function delete(Array $where, $operator = array()) {

        self::__construct();
        foreach ($where as $col => $val) {
            if (!in_array($col, $this->describe())) {
                unset($where[$col]);
            } else {
                if (isset($operator[$col])) {
                    //$campos_where[] = "{$col} {$operator[$col]} '{$val}'";
                    $campos_where[] = "{$col} {$operator[$col]} ?";
                    $bind[] = $val;
                } else {
                    //$campos_where[] = "{$col} = '{$val}'";
                    $campos_where[] = "{$col} = ?";
                    $bind[] = $val;
                }
            }
        }

        $and = count($where) > 1 ? " and " : "";
        $where = "WHERE " . implode($and, $campos_where);

        $sql = " DELETE FROM `{$this->table}`  {$where} ";

        $stm = $this->db->prepare($sql);

        $stm->execute($bind);

        if ($stm->rowCount() > 0) {

            self::__destruct();

            return TRUE;
        }

        self::__destruct();

        return FALSE;
    }

    /**
     * Método responsável para descrever as entidades do banco<br/>
     * @return <b>array</b> com as colunas da tabela
     * */
    private function describe() {


        $sql = "describe {$this->table}";
        $q = $this->db->prepare($sql);

        $q->setFetchMode(PDO::FETCH_ASSOC);
        $q->execute();
        $vvDescribe = $q->fetchAll();
        foreach ($vvDescribe as $vsDescribe) {
            $vsCols[] = $vsDescribe["Field"];
        }

        return $vsCols;
    }

    public function fetchPaginator($sql) {

        $sql_count = str_replace("*", " COUNT(*) count_total", $sql);


        $Db = $this->getDb();
        $query = $Db->query($sql_count);
        $res = $query->fetch(PDO::FETCH_ASSOC);
        if ($res) {
            $count_total = (INT) $res['count_total'];
        }

        $this->pagination->setPaginators($count_total);
        $limit = " LIMIT {$this->pagination->getLimitPerPage()}";
        $offset = " OFFSET {$this->pagination->getQtde()}";

        $sql = $sql . $limit . $offset;
        $query = $Db->query($sql);
        $res = $query->fetchAll(PDO::FETCH_ASSOC);
        if ($res) {
            foreach ($res as $c => $vv) {
                foreach ($vv as $a => $v) {
                    $res[$c][$a] = stripslashes($v);
                }
            }
        }

        return $res;
    }

}

?>
