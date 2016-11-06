<?php
  require_once(__DIR__ . "/../storage/QueryFilterBuilder.php");
  require_once(__DIR__ . "/../models/Model_Recipe.php");
  require_once(__DIR__ . "/AbstractRouter.php");

  class RecipeRouter extends AbstractRouter{
    /**
      Default constructor.

      @param container Slim php container.
      @param type Default type is recipe.
    */
    public function __construct($container, $type = "recipe"){
      $this->container = $container;
      $this->type = $type;
    }

    /**
      Adds an ingredient to a recipe.

      @param request HTTP request.
      @param response HTTP response.
      @param args Arguments.
      @return Recipe.
    */    
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
