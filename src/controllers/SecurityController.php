<?php

require_once 'src/controllers/AppController.php';
class SecurityController extends AppController {

    //przykładowa statyczna baza danych
        private static array $users = [
        [
            'email' => 'anna@example.com',
            'password' => '$2a$12$ZdCBDHmtSppRoKqVGHKKnemQt.eTV8tmSJjm1pgLd.yNXgyz3Dk0K', // test123
            'first_name' => 'Anna'
        ],
        [
            'email' => 'bartek@example.com',
            'password' => '$2a$12$.DXJfYSynm1c4qhyKxrBbOO4d0TMa/ttma/aLuL.cql.O2g3HkC.u', // haslo456
            'first_name' => 'Bartek'
        ],
        [
            'email' => 'celina@example.com',
            'password' => '$2a$12$NTs.SGMT2UZhKCwUUud58uUfe/gFuCYKdUxEi6GpWUVunCWlrfmA.', // qwerty
            'first_name' => 'Celina'
        ],
    ];


    public function login() {
        //TODO get data from login form
        // check if users is in Database
        // render dashboard after succesfull authentication
        // regex tak, żeby wyświetlić jedną kartę po id

        //include 'public/views/login.html';

        if (!$this->isPost()) {
            return $this->render('login');
        }

        //var_dump($_POST); //pokazanie komunikatu przy akcji na stronie

        if ($this->isPost()){ 

            $email = $_POST["email"] ?? '';
            $password = $_POST["password"] ?? '';

            if (empty($email) || empty($password)) {
            return $this->render('login', ['messages' => 'Fill all fields']);
            }   

            $userRow = null;
            foreach (self::$users as $u) {
            if (strcasecmp($u['email'], $email) === 0) {
                $userRow = $u;
                break;
                }
            }

            if (!$userRow) {
            return $this->render('login', ['messages' => 'User not found']);
            }

            if (!password_verify($password, $userRow['password'])) {
            return $this->render('login', ['messages' => 'Wrong password']);
            }

            //return $this->render("dashboard", ['cards' => []]);
 
            $url = "http://$_SERVER[HTTP_HOST]";
            header("Location: {$url}/dashboard");

            //RÓŻNE WAŻNE OPERATORY
            //early return -jednolinijkowy if
            //ternary operator - jednolinijkowy if else (w każdym języku)
            //elvis oparator - ?: (tylko php)
            //coalesing operator
            //spaceship operator
        }


        return $this->render('login', ["message" => "Hasło bledne"]);  //tablica asocjacyjna
    }

    public function register() {

        if (!$this->isPost()) {
            return $this->render('register');
        }

        //var_dump($_POST); //pokazanie komunikatu przy akcji na stronie

        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $firstName = $_POST['firstname'] ?? '';
        $lastName = $_POST['lastname'] ?? '';

        if (empty($email) || empty($password) || empty($firstName) || empty($lastName)) {
            return $this->render('register', ['messages' => 'Fill all fields']);
        }

	    // TODO this will be checked in database
        foreach (self::$users as $u) {
            if (strcasecmp($u['email'], $email) === 0) {
                return $this->render('register', ['messages' => 'Email is taken']);
            }
        }

        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        self::$users[] = [
            'email' => $email,
            'password' => $hashedPassword,
            'first_name' => $firstName,
            'lastName' => $lastName
        ];

        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: {$url}/login");
        

        return $this->render("register");
    }


    protected function isGet(): bool
    {
        return $_SERVER["REQUEST_METHOD"] === 'GET';
    }

    protected function isPost(): bool
    {
        return $_SERVER["REQUEST_METHOD"] === 'POST';
    }
}
