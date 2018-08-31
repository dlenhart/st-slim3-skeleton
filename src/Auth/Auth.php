<?php
namespace APP\Auth;

use APP\Models\User;

class Auth
{
    public function getUser()
    {
        //return name and email for auth.

        if (isset($_SESSION['admin'])) {
            $user = User::select('name', 'email')
                ->where('email', '=', $_SESSION['admin'])
                ->first();
        } else {
            //
            $user = null;
        }

        return $user;
    }

    public function isAuthenticated()
    {
        return isset($_SESSION['admin']);
    }

    public function attempt($email, $password)
    {
        $user = User::where('email', '=', $email)->first();

        echo $user->password;

        if (!$user) {
            return false;
        }

        if (password_verify($password, $user->password)) {
            $_SESSION['admin'] = $email;
            return true;
        }

        return false;
    }
}
