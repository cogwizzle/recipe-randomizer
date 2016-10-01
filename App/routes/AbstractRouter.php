<?php

  abstract class AbstractRouter{
    protected $app;
    protected $type;
    
    public function __construct($app, $type){
      $this->app = $app;
      $this->type = $type;
    }
    
    public function create($request, $response, $args){
      $params = $request->getParams();
      $recipe = R::dispense($this->type);
      $recipe->import($params);
      R::store($recipe);
      return $response->withJson($recipe);
    }
    
    public function read($request, $response, $args){
      $params = $request->getQueryParams();
      $builder = new QueryFilterBuilder();
      foreach($params as $key => $value){
        $builder->filterLike($key, $value);
      }
      R::find($this->type, $builder->buildQuery(), $builder->queryParams);
    }
    
    public function readOne($request, $response, $args){
      $id = $request->getAttribute('id');
      $recipe = R::load($this->type, $id);
      return $response->withJson($recipe->export());
    }
    
    public function update($request, $response, $args){
      $id = $request->getAttribute('id');
      $params = $request->getParams();
      $reciepe = R::load($this->type, $id);
      $recipe->import($params);
      R::store($recipe);
      return $response->withJson($recipe->export());
    }
    
    public function updateSafe($request, $response, $args){
      throw new Exception("Not implemented.");
    }
    
    public function delete($request, $response, $args){
      $id = $request->getAttribute('id');
      $bean = R::load($this->type, $id);
      R::trash($bean);
      return $response->withJson(array());
    }
    
    public function deleteAll($request, $response, $args){
      R::wipe($this->type);
      return $response->withJson(array());
    }
  }
?>