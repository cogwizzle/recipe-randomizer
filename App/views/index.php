<?php
  require(__DIR__ . '/../../vendor/autoload.php');
  require_once(__DIR__ . '/../../Persistence/rb.php');
  require_once(__DIR__ . '/../routes/IngredientRouter.php');
  require_once(__DIR__ . '/../routes/RecipeRouter.php');

  R::setup('sqlite:' . __DIR__ . '/../../Persistence/dbfile.db');
  R::fancyDebug(true);

  $config = array('debug' => true);
  $app = new \Slim\App($config);
  
  //TODO 1.0 Doesn't workin the url with php localhost.  You will need to use apache2.
  $app->get('/hello/{name}', function($request, $response){
    $name = $request->getAttribute('name');
    $response->getBody()->write("Hello, $name");

    return $response;
  });
  
  $app->group("/api/1.0/", function(){
    $this->post('recipe', 'RecipeRouter:create');
    
    $this->post('recipe/{id}', 'RecipeRouter:update');
    
    $this->get('recipe', 'RecipeRouter:read');
    
    $this->get('recipe/{id}', 'RecipeRouter:readOne');
    
    $this->delete('recipe', 'RecipeRouter:deleteAll');
    
    $this->delete('recipe/{id}', 'RecipeRouter:delete');
    
    $this->get('recipe/{recipe_id}/addIngredient/{ingredient_id}', 'RecipeRouter:addIngredient');
    
    $this->post('ingredient', 'IngredientRouter:create');
    
    $this->post('ingredient/{id}', 'IngredientRouter:update');
    
    $this->get('ingredient', 'IngredientRouter:read');
    
    $this->get('ingredient/{id}', 'IngredientRouter:readOne');
    
    $this->delete('ingredient', 'IngredientRouter:deleteAll');
    
    $this->delete('ingredient/{id}', 'IngredientRouter:delete');
  });
  
  $app->run();
?>
