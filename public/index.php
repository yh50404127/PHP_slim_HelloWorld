<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Selective\BasePath\BasePathMiddleware;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../config/db.php'; //載入資料庫


$app = AppFactory::create();
$app->addRoutingMiddleware();
$app->add(new BasePathMiddleware($app));
$app->addErrorMiddleware(true, true, true);

//回傳HTML檔
$app->get('/', function (Request $request, Response $response) {
    $file = '../views/aaa.html';
    $response->getBody()->write(file_get_contents($file));
    return $response;
});

//路由參數範例
$app->get('/{name}', function (Request $request, Response $response, array $args) {
    $response->getBody()->write("Hello ".$args['name']);
    return $response;
});

////回傳HTML檔
$app->get('/xxx/bbb', function (Request $request, Response $response) {
    $file = '../views/bbb.html';
    $response->getBody()->write(file_get_contents($file));
    return $response;
});

//POST參數使用
$app->post('/xxx/ccc', function (Request $request, Response $response) {
    $ParsedBody = $request->getParsedBody();
    $user = $ParsedBody['user'];
    $pass = $ParsedBody['pass'];
    $ok = "帳號:" . $user . "<br />" . "密碼:" . $pass;
    $response->getBody()->write($ok);
    return $response;
});

//GET參數使用
$app->get('/xxx/ddd', function (Request $request, Response $response) {
    $Param = $request->getQueryParams();
    $response->getBody()->write($Param['a']);
    return $response;
});

//重定向範例(路由前加../)
$app->get('/xxx/eee', function (Request $request, Response $response) {
    return $response
            ->withHeader('Location', '../xxx/bbb')
            ->withStatus(302);
});

//載入路由
require __DIR__ . '/../routes/friends.php';

$app->run();
