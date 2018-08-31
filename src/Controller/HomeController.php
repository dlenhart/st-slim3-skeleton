<?php
namespace APP\Controller;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Illuminate\Database\Capsule\Manager as DB;
use Illuminate\Support\Facades\Schema;
use APP\Models\Sample;

/**
 * Class HomeController
 * @package HomeController\Controller
 */

class HomeController extends AbstractController
{
    /**
     * @param Request $request
     * @param Response $response
     * @param $args
     * @return Response
     */

    // Home Page
    public function index(Request $request, Response $response, $args)
    {
        $data = array('title' => 'Home');
        return $this->view->render($response, 'Home.html', $data);
    }
    
}
