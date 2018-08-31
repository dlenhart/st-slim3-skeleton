<?php
/*
author:  Drew Lenhart
des:	routes - api
e.g. -   $app->get("route/url", '{{controller}}:{{method}}');
*/

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->get('/api/sample', 'ApiController:example');
$app->post('/api/samplePost', 'ApiController:examplePost');

// Swagger API link
$app->get('/v1/docs', function ($request, $response, $args) {
    $dir = __DIR__ . '/../Controller'; // Scan Controller folder

    $swagger = \Swagger\scan([$dir]);

    $response->write($swagger);
    $response = $response->withHeader('Content-Type', 'application/json');
    return $response;
});
