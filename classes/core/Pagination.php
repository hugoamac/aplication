<?php

//292,468,022,53
//118741132
//10699

/**
 * Description of Pagination
 *
 * @author hugo
 */
class Pagination {

    protected $_paginator = "page";
    protected $_paginators = array();
    protected $_init;
    protected $_limit_per_page = 20;
    protected $_first_page = 1;
    protected $_last_page;
    protected $_next;
    protected $_previous;
    protected $_total_page;
    protected $_current_page;
    protected $_total_data;
    protected $_range = 5;
    protected $_query_string;

    public function __construct($limit = NULL) {

        if (NULL != $limit) {
            $this->setLimitPerPage($limit);
        }
        $this->setInit();
        $this->getCurrentPage();
        $this->buildQueryString();
    }

    private function buildQueryString() {
        if (!empty($_SERVER["QUERY_STRING"])) {
            $vsQueryString = explode("&", $_SERVER["QUERY_STRING"]);
            foreach ($vsQueryString as $val) {
                $param = reset(explode("=", $val));
                $valor = end(explode("=", $val));
                if ($param != $this->_paginator)
                    $v[$param] = $valor;
            }
        }
        if (!empty($v))
            $build = http_build_query($v);
        $query_string = $build ? "?" . $build . "&" : "?";
        $this->_query_string = $_SERVER["PHP_SELF"] . $query_string;
    }

    private function getQueryString() {

        return $this->_query_string;
    }

    private function setLimitPerPage($limit) {
        $this->_limit_per_page = $limit;
    }

    public function getLimitPerPage() {
        return $this->_limit_per_page;
    }

    private function setInit() {
        $query_string = $_SERVER["QUERY_STRING"];
        $pattern = "/({$this->_paginator}=[0-9]{1,})/";
        $init = (preg_match($pattern, $query_string, $page)) ? (INT) end(explode("=", $page[0])) : 0;
        $this->_init = $init > 0 ? (INT) $init : 0;
    }

    public function getInit() {
        return $this->_init;
    }

    private function getCurrentPage() {
        return $this->_current_page = $this->getInit() ? $this->getInit() : 1;
    }

    private function setRange($range) {

        $this->_range = $range;
    }

    private function getRange() {

        return $this->_range;
    }

    private function setTotalPage($total_page) {

        $this->_total_page = (INT) $total_page;
    }

    public function getTotalPage() {

        return (INT) $this->_total_page;
    }

    private function setTotalData($total) {

        $this->_total_data = $total;
    }

    public function getTotalData() {

        return $this->_total_data;
    }

    public function setPaginators($data) {

        if (is_array($data)) {

            $total = (INT) sizeof($data);
        }
        if (is_int($data)) {

            $total = (INT) $data;
        }

        $total_page = (INT) ceil($total / $this->getLimitPerPage());

        $this->setTotalData($total);
        $this->setTotalPage($total_page);
        $this->setLastPage($total_page);



        if ($this->getPrevious()) {
            $this->_paginators["previous"] = "{$this->getQueryString()}{$this->_paginator}={$this->getPrevious()}";
        }

        if ($this->getFirstPage()) {
            $this->_paginators["first"] = "{$this->getQueryString()}{$this->_paginator}={$this->getFirstPage()}";
        }

        for ($i = $this->getCurrentPage() - $this->getRange(); $i < (($this->_current_page + $this->getRange() ) + 1); $i++) {

            if (($i > 0) && ($i <= $this->getTotalPage())) {
                if ($i != $this->getFirstPage() && $i != $this->getLastPage())
                    $this->_paginators[$this->_paginator][$i] = "{$this->getQueryString()}{$this->_paginator}={$i}";
            }
        }

        if ($this->getLastPage()) {
            $this->_paginators["last"] = "{$this->getQueryString()}{$this->_paginator}={$this->getLastPage()}";
        }

        if ($this->getNext()) {
            $this->_paginators["next"] = "{$this->getQueryString()}{$this->_paginator}={$this->getNext()}";
        }
    }

    public function getPaginators() {

        return $this->_paginators;
    }

    private function getFirstPage() {
        return $this->getCurrentPage() == 1 ? FALSE : $this->_first_page;
    }

    private function setLastPage($total_page) {

        $this->_last_page = $this->getCurrentPage() == $total_page ? FALSE : $total_page;
    }

    private function getLastPage() {
        return $this->_last_page;
    }

    private function getNext() {

        if ($this->getCurrentPage() && $this->getCurrentPage() < $this->getTotalPage()) {

            return $this->_next = $this->getCurrentPage() + 1;
        }

        return FALSE;
    }

    private function getPrevious() {

        if ($this->getCurrentPage() && $this->getCurrentPage() != 1) {
            if ($this->getCurrentPage() > $this->getTotalPage()) {
                header('Location:/error/404.php');
            }
            return $this->_next = $this->getCurrentPage() - 1;
        }
        return FALSE;
    }

    public function printPainelResultado() {

        return "Total de Registros: {$this->getTotalData()}<br/>
                Página {$this->getCurrentPage()} - {$this->getTotalPage()}
               ";
    }

    public function getQtde() {

        return (($this->getCurrentPage() - 1) * $this->getLimitPerPage());
    }

}

?>
