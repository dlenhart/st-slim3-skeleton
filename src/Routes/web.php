<?php
/*
author:  Drew Lenhart
des:	routes - web
e.g. -   $app->get("route/url", '{{controller}}:{{method}}');
*/

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->get('/', 'HomeController:index');
$app->get('/createSample', 'HomeController:createDatabaseSample');
$app->get('/validationSample', 'HomeController:validationSample');
