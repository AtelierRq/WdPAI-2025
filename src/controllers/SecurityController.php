<?php

require_once 'src/controllers/AppController.php';
class SecurityController extends AppController {
    public function login() {
        //TODO get data from login form
        // check if users is in Database
        // render dashboard after succesfull authentication

        include 'public/views/login.html';

        return $this->render('login', ["message" => "Hasło bledne"]);  //tablica asocjacyjna
    }

    public function register() {
        return $this->render("register");
    }

}