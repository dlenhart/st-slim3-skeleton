<?php
// Application middleware
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

// Strip trailing slash if user enters one
$app->add(function (Request $request, Response $response, callable $next) {
    $uri = $request->getUri();
    $path = $uri->getPath();
    if ($path != '/' && substr($path, -1) == '/') {
        // permanently redirect paths with a trailing slash
        // to their non-trailing counterpart
        $uri = $uri->withPath(substr($path, 0, -1));
        return $response->withRedirect((string)$uri, 301);
    }

    return $next($request, $response);
});

//Auth middleware
$authenticate = function ($request, $response, $next) {
    if (!isset($_SESSION['admin'])) {
        $path = $request->getAttribute('routeInfo');
        $path = $path['request'][1];

        //add path to flash msgs for login flash message!
        $this->flash->addMessage('url', $path);
        return $response->withRedirect('/login');
    }

    $response = $next($request, $response);
    return $response;
};

// Validation Errors middleware
$validationErrors = function (Request $request, Response $response, $next) {
    //get session errors
    if (isset($_SESSION['ERRORS'])) {
        // Add to global variable
        $this->view->getEnvironment()->addGlobal('ERRORS', $_SESSION['ERRORS']);

        // remove session var
        unset($_SESSION['ERRORS']);
    }

    return $next($request, $response);
};

// Form Data middleware
$oldFormData = function (Request $request, Response $response, $next) {
    if (isset($_SESSION['DATA'])) {
        $this->view->getEnvironment()->addGlobal('DATA', $_SESSION['DATA']);

        $_SESSION['DATA'] = (array)$request->getParsedBody();
    }

    return $next($request, $response);
};
