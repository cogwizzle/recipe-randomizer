<?php
  /**
    Definition for how most routers should work.

    @author Joe Fehrman
    @since 11/06/2016
  */
  abstract class AbstractRouter{
    protected $container;
    protected $type;
   
    /**
      Default Constructor.

      @param $container Slim container.
      @param $type Type of bean.
    */ 
    public function __construct($container, $type){
      $this->container = $container;
      $this->type = $type;
    }
   
    /**
      Create a new bean.

      @param $request HTTP request.
      @param $response HTTP response.
      @param $args Arguments.
    */ 
    public function create($request, $response, $args){
      $params = $request->getParams();
      $bean = R::dispense($this->type);
      $bean->import($params);
      R::store($bean);
      return $response->withJson($bean);
    }
    
    /**
      Query the persistence layer for beans.

      @param $request HTTP request.
      @param $response HTTP response.
      @param $args Arguments.
    */ 
    public function read($request, $response, $args){
      $params = $request->getQueryParams();
      $builder = new QueryFilterBuilder();
      foreach($params as $key => $value){
        $builder->filterLike($key, $value);
      }
      $beans = R::find($this->type, $builder->buildQuery(), $builder->queryParams);
      return $response->withJson($beans);
    }
    
    /**
      Query the persistence layer for a bean.

      @param $request HTTP request.
      @param $response HTTP response.
      @param $args Arguments.
    */ 
    public function readOne($request, $response, $args){
      $id = $request->getAttribute('id');
      $bean = R::load($this->type, $id);
      return $response->withJson($bean->export());
    }
    
    /**
      Update a bean based on bean id.

      @param $request HTTP request.
      @param $response HTTP response.
      @param $args Arguments.
    */ 
    public function update($request, $response, $args){
      $id = $request->getAttribute('id');
      $params = $request->getParams();
      $reciepe = R::load($this->type, $id);
      $bean->import($params);
      R::store($bean);
      return $response->withJson($bean->export());
    }
    
    /**
      Update an id safely.

      @param $request HTTP request.
      @param $response HTTP response.
      @param $args Arguments.
    */ 
    public function updateSafe($request, $response, $args){
      throw new Exception("Not implemented.");
    }
    
    /**
      Delete a bean based on id.

      @param $request HTTP request.
      @param $response HTTP response.
      @param $args Arguments.
    */ 
    public function delete($request, $response, $args){
      $id = $request->getAttribute('id');
      $bean = R::load($this->type, $id);
      R::trash($bean);
      return $response->withJson(array());
    }
    
    /**
      Delete all beans of a given type.

      @param $request HTTP request.
      @param $response HTTP response.
      @param $args Arguments.
    */ 
    public function deleteAll($request, $response, $args){
      R::wipe($this->type);
      return $response->withJson(array());
    }
  }
?>
