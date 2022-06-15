<?php

//路由加Response和Request即可
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

//使用資料庫範例
$app->get('/friends/all', function (Request $request, Response $response) {
    $sql = "SELECT * FROM login_log";
    try {
        $db = new DB();
        $conn = $db->connect();
        $stmt = $conn->query($sql);
        $friends = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        $response->getBody()->write(json_encode($friends));

        return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(200);

    }catch (PDOException $e) {
        $response->getBody()->write("error");
        return $response;
    }
        
});