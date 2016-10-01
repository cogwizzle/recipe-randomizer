<?php
  class QueryFilterBuilder{
    public $queryParams;
    private $sqlStatements;
    
    public function __construct(){
      $this->queryParams = array();
      $this->sqlStatements =array();
    }
    
    public function filterLike($paramName, $param){
      $sql = "$paramName like ?";
      appendFilter($sql, $param);
    }
    
    public function filterEqual($paramName, $param){
      $sql = "$paramName = ?";
      appendFilter($sql, $param);
    }
    
    private function appendFilter($sql, $param){
      array_push($this->queryParams, $param);
      array_push($this->sqlStatements, $sql);
    }
    
    public function buildQuery(){
      return implode($this->sqlStatements, " AND ");
    }
  }
?>