<?php

require_once 'src/controllers/AppController.php';
require_once __DIR__.'/../../Repository/UserRepository.php';

class SecurityController extends AppController {

    private $userRepository;
    
    public function __construct() {
        $this->userRepository = new UserRepository();
    }

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
            
            /*
            $userRow = null;
            foreach (self::$users as $u) {
            if (strcasecmp($u['email'], $email) === 0) {
                $userRow = $u;
                break;
                }
            }
            */

            $userRow = $this->userRepository->getUsersByEmail($email);

            if (!$userRow) {
            return $this->render('login', ['messages' => 'User not found']);
            }

            if (!password_verify($password, $userRow['password'])) {
            return $this->render('login', ['messages' => 'Wrong password']);
            }

            // zweryfikowanie emaila
            filter_var($email, FILTER_VALIDATE_EMAIL);
            error_log("Login failed for email: {$email}");

            //return $this->render("dashboard", ['cards' => []]);
            //TODO create user session, token or smth (nie robić, zrobimy na zajęciach później)
 
            session_set_cookie_params([
            'httponly' => true,
            'secure'   => false,   // true jeśli HTTPS
            'samesite' => 'Strict'
            ]);

            session_start();

            session_regenerate_id(true); // 🔐 B3 – ochrona przed session fixation

            $_SESSION['user'] = [
            'email' => $userRow['email'],
            'first_name' => $userRow['first_name']
            ];


            $url = "http://$_SERVER[HTTP_HOST]";
            header("Location: {$url}/dashboard");

            //RÓŻNE WAŻNE OPERATORY
            //early return -jednolinijkowy if
            //ternary operator - jednolinijkowy if else (w każdym języku)
            //elvis oparator - ?: (tylko php)
            //coalesing operator
            //spaceship operator
        }


        return $this->render('login', ["message" => "Wrond Password"]);  //tablica asocjacyjna
    }

    public function register() {

        if (!$this->isPost()) {
            return $this->render('register');
        }

        //var_dump($_POST); //pokazanie komunikatu przy akcji na stronie

        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $password2 = $_POST['password2'] ?? '';
        $firstName = $_POST['firstName'] ?? '';
        $lastName = $_POST['lastName'] ?? '';

        if (empty($email) || empty($password) || empty($firstName) || empty($lastName)) {
            return $this->render('register', ['messages' => 'Fill all fields']);
        }

        if($password !== $password2) {
            return $this->render('register', ['messages' => 'Hasła są różne']);
        }

	    // TODO this will be checked in database
        /*
        foreach (self::$users as $u) {
            if (strcasecmp($u['email'], $email) === 0) {
                return $this->render('register', ['messages' => 'Email is taken']);
            }
        }
        */

        if ($this->userRepository->getUsersByEmail($email)) {
        return $this->render('register', ['messages' => 'Email is taken']);
        }

        // TODO check if user with this email already exists

        $hashedPassword = password_hash($password, PASSWORD_BCRYPT); //haszowanie hasła - hasz zaczyna się od $2y$

        $this->userRepository->createUser(
            $email, $hashedPassword, $firstName, $lastName
        );

        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: {$url}/login");

        return $this->render("login", ['messages' => 'User registered successfully, please login']);
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
