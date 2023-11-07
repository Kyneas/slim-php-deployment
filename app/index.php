<?php
// Error Handling
error_reporting(-1);
ini_set('display_errors', 1);

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Slim\Routing\RouteCollectorProxy;

require __DIR__ . '/../vendor/autoload.php';


//
require_once "./controllers/UsuarioController.php";
require_once "./db/AccesoDatos.php";
//
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();
//
// Instantiate App
$app = AppFactory::create();

// Add error middleware
$app->addErrorMiddleware(true, true, true);

// Add parse body
$app->addBodyParsingMiddleware();

//Set base path
$app->setBasePath('/slim-php-deployment/app');

// Routes
// $app->get('[/]', function (Request $request, Response $response) {
//     $payload = json_encode(array('method' => 'GET', 'msg' => "Sin parametros"));
//     $response->getBody()->write($payload);
//     return $response->withHeader('Content-Type', 'application/json');
// });

// $app->get('/test', function (Request $request, Response $response) {
//     $payload = json_encode(array('method' => 'GET', 'msg' => "test"));
//     $response->getBody()->write($payload);
//     return $response->withHeader('Content-Type', 'application/json');
// });

$app->get('/us/todos', \UsuarioController::class . ':TraerTodos');
// $app->get('/us/uno', \UsuarioController::class . ':TraerUno');
$app->post('/us/nuevo', \UsuarioController::class . ':CargarUno');

$app->get('/pr/todos', \UsuarioController::class . ':TraerTodos');

// $app->post('[/]', function (Request $request, Response $response) {
//     $payload = json_encode(array('method' => 'POST', 'msg' => "Bienvenido a SlimFramework 2023"));
//     $response->getBody()->write($payload);
//     return $response->withHeader('Content-Type', 'application/json');
// });

// $app->post('/test', function (Request $request, Response $response) {
//     $payload = json_encode(array('method' => 'POST', 'msg' => "test POST"));
//     $response->getBody()->write($payload);
//     return $response->withHeader('Content-Type', 'application/json');
// });

$app->run();
