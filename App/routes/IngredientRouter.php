<?php
  require_once("../storage/QueryFilterBuilder.php");
  require_once("../models/Model_Ingredient.php");
  require_once("AbstractRouter.php");

  class IngredientRouter extends AbstractRouter{
    public function __construct($app, $type = "ingredient"){
      $this->app = $app;
      $this->type = $type;
    }
  }
?>