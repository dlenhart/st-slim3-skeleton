<?php
/*
author:  Drew Lenhart
des:	routes - admin
e.g. -   $app->get("route/url", '{{controller}}:{{method}}');
*/

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->get('/admin', 'AdminController:index')->add($authenticate); // authtication middleware

// Register
$app->get('/register', 'AuthController:viewRegister')->add($oldFormData)->add($validationErrors);
$app->post('/register', 'AuthController:postRegister');

// Login/logout
$app->get('/login', 'AuthController:login')->add($validationErrors);
$app->post('/login', 'AuthController:postLogin');
$app->get('/logout', 'AuthController:logout');

$app->get('/messages', 'AuthController:testMessages');
