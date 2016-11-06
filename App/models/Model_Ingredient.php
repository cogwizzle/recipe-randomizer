<?php
  class Model_Ingredient extends RedBean_SimpleModel{
    public function update(){
      if(!isset($this->bean->name) || !isset($this->bean->amount)){
        throw new Exception("Unable to ingredient.  Ingredient must have a name and an ammount.");
      }
    }
  }
?>
