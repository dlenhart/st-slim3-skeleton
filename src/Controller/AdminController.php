<?php
namespace APP\Controller;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Illuminate\Database\Capsule\Manager as DB;
use Illuminate\Support\Facades\Schema;
use APP\Models\Sample;

/**
 * Class AdminController
 * @package AdminController\Controller
 */

class AdminController extends AbstractController
{
    /**
     * @param Request $request
     * @param Response $response
     * @param $args
     * @return Response
     */

    // Admin Home
    public function index(Request $request, Response $response, $args)
    {
        $data = array('title' => 'Admin');
        return $this->view->render($response, 'Admin-Home.html', $data);
    }
}
