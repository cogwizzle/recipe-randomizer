<?php
  class Model_Recipe extends RedBean_SimpleModel{
    public function update(){
      if(!isset($this->bean->title)){
        throw new Exception("Unable to persist recipe.  Recipe must have a recipe title.");
      }
    }
    
    public function open(){
      $this->bean->ownIngredient;
    }
  }
?>