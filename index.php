<?php 

require_once("vendor/autoload.php");

$app = new \Slim\Slim();

$app->config('debug', true);

$app->get('/', function() {
    
	echo "<h1>Se estiver vendo essa pagina é porque tudo foi bem!!!</h1>";

});

$app->run();

 ?>