<?php
namespace APP\Controller;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Illuminate\Database\Capsule\Manager as DB;
use Respect\Validation\Validator as v;
use APP\Models\User;
use APP\Auth\Auth as Auth;

/**
 * Class AuthController
 * @package AuthController\Controller
 */

class AuthController extends AbstractController
{
    /**
     * @param Request $request
     * @param Response $response
     * @param $args
     * @return Response
     */

    // Display Login Page
    public function login(Request $request, Response $response, $args)
    {
        $data = array('title' => 'Login');
        return $this->view->render($response, 'Login.html', $data);
    }

    // Login - Post
    public function postLogin(Request $request, Response $response, $args)
    {
        // validation
        $validation = $this->validator->validate($request, [
            'email' => v::notEmpty()->email(),
            'password' => v::notEmpty()
        ]);

        if ($validation->failed()) {
            // failed validation from APP\Validator
            return $response->withRedirect('/login');
        } else {
            // good data
            $allVars = (array)$request->getParsedBody();
            $email = $allVars['email'];
            $password = $allVars['password'];

            //something
            $auth = new Auth;
            $auth = $auth->attempt($email, $password);

            if ($auth) {
                //true
                return $response->withRedirect('/admin');
            } else {
                //false send back to login
                $this->flash->addMessage('err', 'Incorrect username or password!');

                return $response->withRedirect('/login');
            }
        }
    }

    // Logout
    public function logout(Request $request, Response $response, $args)
    {
        //unset session variable.
        unset($_SESSION['admin']);
        return $response->withRedirect('/');
    }

    // Register
    public function viewRegister(Request $request, Response $response, $args)
    {
        $data = array('title' => 'Register');
        return $this->view->render($response, 'Register.html', $data);
    }

    // Register - Post
    public function postRegister(Request $request, Response $response, $args)
    {
        // validation
        $validation = $this->validator->validate($request, [
            'name' => v::notEmpty(),
            'email' => v::notEmpty()->email(),
            'password' => v::notEmpty()
        ]);

        if ($validation->failed()) {
            // failed validation from APP\Validator

            $this->view->getEnvironment()->addGlobal('DATA', "HELLOO");

            $_SESSION['DATA'] = (array)$request->getParsedBody();

            return $response->withRedirect('/register');
        } else {
            // good data
            $allVars = (array)$request->getParsedBody();
            $name = $allVars['name'];
            $email = $allVars['email'];
            $password = $allVars['password'];

            $newUser = User::create([
                'name' => $name,
                'email' => $email,
                'password' => password_hash($password, PASSWORD_DEFAULT)
            ]);

            // redirect to login - or anywhere
            return $response->withRedirect('/login');
        }
    }
}
