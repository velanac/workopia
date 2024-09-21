<?php

namespace App\Controllers;

use Framework\Database;
use Framework\Validation;
use Framework\Session;

class UserController
{
    protected $db;

    public function __construct()
    {
        $config = require basePath('config/db.php');
        $this->db = new Database($config);
    }

    public function login()
    {
        loadView('users/login');
    }

    public function create()
    {
        loadView('users/create');
    }

    public function store()
    {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $city = $_POST['city'];
        $state = $_POST['state'];
        $password = $_POST['password'];
        $confirmationPassword = $_POST['password_confirmation'];

        $errors = [];

        // Validation
        if (!Validation::email($email)) {
            $errors['email'] = 'Please enter a valid email address';
        }

        if (!Validation::string($name, 2, 50)) {
            $errors['name'] = 'Name must be between 2 and 50 characters';
        }

        if (!Validation::string($password, 6, 50)) {
            $errors['password'] = 'Password must be between 6 and 50 characters';
        }

        if (!Validation::match($confirmationPassword, $password)) {
            $errors['password_confirmation'] = 'Passwords not match';
        }

        if (!empty($errors)) {
            loadView('users/create', ['errors' =>  $errors, 'user' => [
                'name' => $name,
                'email' => $email,
                'city' => $city,
                'state' => $state
            ]]);
            exit;
        }

        // Check if email exist
        $params = ['email' => $email];

        $user = $this->db->query("SELECT * FROM users WHERE email = :email", $params)->fetch();

        if ($user) {
            $errors['email'] = 'That email already exist';

            loadView('users/create', ['errors' =>  $errors, 'user' => [
                'name' => $name,
                'email' => $email,
                'city' => $city,
                'state' => $state
            ]]);

            exit;
        }

        $params = [
            'name' => $name,
            'email' => $email,
            'city' => $city,
            'state' => $state,
            'password' => password_hash($password, PASSWORD_DEFAULT)
        ];

        $this->db->query('INSERT INTO users  (name, email, city,state, password)
        VALUES (:name,:email,:city,:state,:password)', $params);

        $userId = $this->db->conn->lastInsertId();

        Session::set('user', [
            'userId' => $userId,
            'name' => $name,
            'email' => $email,
            'city' => $city,
            'state' => $state
        ]);

        redirect('/');
    }

    public function logout()
    {
        Session::clearAll();

        $params = session_get_cookie_params();
        setcookie('PHPSESID', '', time() - 86400, $params['path'], $params['domain']);

        redirect('/');
    }
}
