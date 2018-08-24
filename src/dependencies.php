<?php
// Configuration for Slim Dependency Injection Container

$container = $app->getContainer();

// Using Twig as template engine
$container['view'] = function ($container) {
    $view = new \Slim\Views\Twig('src/Views', [
        'cache' => false //'cache'
    ]);
    $view->addExtension(new \Slim\Views\TwigExtension(
        $container['router'],
        $container['request']->getUri()
    ));
	$view->getEnvironment()->addGlobal('flash', $container['flash']);
    return $view;
};

// 404 Not Found
$container['notFoundHandler'] = function ($container) {
    return function ($request, $response) use ($container) {
		$title = "OOPS!";
		$data = array('title' => $title);
        return $container->view->render($response, '404.html', $data) 
            ->withStatus(404)
            ->withHeader('Content-Type', 'text/html');
    };
};

$container['cache'] = function ($container) {
    return new \Slim\HttpCache\CacheProvider();
};

// Flash messages
$container['flash'] = function ($container) {
    return new \Slim\Flash\Messages();
};

// Customized below

//Guzzle HTTP client
$container['httpClient'] = function($container) {
    return new \GuzzleHttp\Client();
};

// Respect Validator
$container['validator'] = function ($container) {
    return new \APP\Validation\Validator;
};

// HomeController
$container['HomeController'] = function ($container) {
    return new \APP\Controller\HomeController($container);
};

// ApiController
$container['ApiController'] = function ($container) {
    return new \APP\Controller\ApiController($container);
};