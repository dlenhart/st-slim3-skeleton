<?php
/*
author:  Drew Lenhart
des:	routes - web
e.g. -   $app->get("route/url", '{{controller}}:{{method}}');
*/

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->get('/', 'HomeController:index');

// Create Sample SQLite database
$app->get('/createSample', 'CreateSampleController:createDatabaseSample'); 

// Create Users table....
$app->get('/createUsers', 'CreateSampleController:createUserTable'); 
