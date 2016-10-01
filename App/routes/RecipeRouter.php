<?php
  require_once("../storage/QueryFilterBuilder.php");
  require_once("../models/Model_Recipe.php");
  require_once("AbstractRouter.php");

  class RecipeRouter extends AbstractRouter{
    public function __construct($app, $type = "recipe"){
      $this->app = $app;
      $this->type = $type;
    }
    
    public function addIngredient($request, $response, $args){
      $params = $request->getParams();
      $recipe = R::load($this->type, $request->getAttribute('recipe_id'));
      $ingredient = R::load('ingredient', $request->getAttribute('ingredient_id'));
      $recipe->ownIngredient[] = $ingredient;
      R::store($recipe);
      return $response->withJson($recipe);
    }
  }
?>